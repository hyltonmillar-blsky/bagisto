<?php

namespace Blsky\Payfast\Helpers;

use Blsky\Payfast\Facades\PayfastCart;
use Exception;
use Blsky\Payfast\Payment\Payfast;
use Illuminate\Support\Facades\Log;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;

class Itn
{
    /**
     * Itn post data
     *
     * @var array
     */
    protected $post;

    /**
     * Order object
     *
     * @var \Webkul\Sales\Contracts\Order
     */
    protected $order;

    /**
     * Cart object
     *
     * @var \Webkul\Checkout\Cart
     */
    protected $cart;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * InvoiceRepository object
     *
     * @var \Webkul\Sales\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * Payfast object
     *
     * @var \Blsky\Payfast\Payment\Payfast
     */
    protected $payfastObject;

    /**
     * Create a new helper instance.
     *
     * @param  Blsky\Payfast\PayfastCart  $cart
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @param  \Blsky\Payfast\Payment\Payfast $payfastObject
     * @return void
     */
    public function __construct(
        PayfastCart $cart,
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
        Payfast $payfastObject
    ) {
        $this->cart = $cart;
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->payfastObject = $payfastObject;
    }

    /**
     * This function process the Itn sent from payfast end
     *
     * @param  array  $pfData
     * @return null|void|\Exception
     */
    public function processItn($pfData)
    {
        // let payfast know that info has been received the data
        header('HTTP/1.0 200 OK');
        flush();

        $this->post = $pfData;
        $this->cart = PayfastCart::PayfastgetCart($this->post['m_payment_id']);

        // Strip any slashes in data
        foreach ($pfData as $key => $val) {
            $pfData[$key] = stripslashes($val);
        }
        $pfParamString = $this->buildQueryString($pfData);

        $this->ValidSignature($pfData, $pfParamString, $this->payfastObject->getConfigData('pass_phrase'));
        $this->ValidateHost(request());
        $this->ValidateAmount();
        $this->ValidateCurl();

        $this->orderRepository->create(PayfastCart::PayfastprepareDataForOrder($this->post['m_payment_id']));
        $this->getOrder();
        $this->processOrder();
        Log::debug('validations complete');

        try {
            //            $this->processOrder();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Load order via itn cart id
     *
     * @return void
     */
    protected function getOrder()
    {
        $this->order = $this->orderRepository->findOneByField(['cart_id' => $this->post['m_payment_id']]);
    }

    /**
     * Process order and create invoice
     *
     * @return void
     */
    protected function processOrder()
    {
        if ($this->post['payment_status'] == 'COMPLETE') {
            $this->orderRepository->update(['status' => 'processing'], $this->order->id);
            if ($this->order->canInvoice()) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData());
            }
        }
    }

    /**
     * Prepares order's invoice data for creation
     *
     * @return array
     */
    protected function prepareInvoiceData()
    {
        $invoiceData = [
            "order_id" => $this->order->id,
        ];

        foreach ($this->order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    function ValidSignature($pfData, $pfParamString, $pfPassphrase = null)
    {
        // Calculate security signature
        if ($pfPassphrase === null) {
            $tempParamString = $pfParamString;
        } else {
            $tempParamString = $pfParamString . '&passphrase=' . urlencode($pfPassphrase);
        }

        $signature = md5($tempParamString);
        if ($pfData['signature'] === $signature) {
            return true;
        } else {
            throw new Exception('Invalid Signature');
        }
    }

    public function ValidateHost($request)
    {
        // Variable initialization
        $validHosts = array(
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        );

        $validIps = [];

        foreach ($validHosts as $pfHostname) {
            $ips = gethostbynamel($pfHostname);

            if ($ips !== false)
                $validIps = array_merge($validIps, $ips);
        }

        // Remove duplicates
        $validIps = array_unique($validIps);
        $referrerIp = gethostbyname(parse_url($request->server('HTTP_REFERER'))['host']);
        if (!in_array($referrerIp, $validIps, true)) {
            throw new Exception('Not a valid Host');
        }
        return;
    }

    public function ValidateAmount()
    {
        if (floatval($this->post['amount_gross']) == floatval($this->cart->grand_total)) {
            return;
        } else {
            throw new Exception('The gross amount does not match the cart amount');
        }
    }

    public function ValidateCurl()
    {

        $params = $this->buildQueryString($this->post);

        // Variable initialization
        if ($this->payfastObject->getConfigData('pass_phrase')) {
            $url =  'https://sandbox.payfast.co.za​/eng/query/validate';
        } else {
            $url = 'https://www.payfast.co.za/eng/query/validate';
        }

        // Create default cURL object
        $ch = curl_init();

        // Set cURL options - Use curl_setopt for greater PHP compatibility
        // Base settings
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

        // Standard settings
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        // Execute CURL
        $response = curl_exec($ch);

        curl_close($ch);

        $lines = explode("\r\n", $response);
        $verifyResult = trim($lines[0]);

        if (strcasecmp($verifyResult, 'VALID') == 0) {
            return true;
        } else {
            throw new Exception('The Data is not valid');
        }
    }

    public function buildQueryString($data)
    {
        $vret = '';
        foreach ($data as $key => $val) {
            if ($key == 'signature') {
                continue;
            }

            $vret .= $key . '=' . urlencode(trim($val)) . '&';
        }

        $vret = substr($vret, 0, -1);

        return $vret;
    }
}
