<?php

namespace Blsky\Payfast\Payment;

use Illuminate\Support\Facades\Log;
use Webkul\Payment\Payment\Payment;

class Payfast extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'payfast';

    /**
     * Return  redirect url
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('payfast.redirect');
    }

    public function getPayfastUrl()
    {
        if ($this->getConfigData('sandbox')) {
            return 'https://sandbox.payfast.co.za​/eng/process'; //?' . http_build_query($params);
        } else {
            return 'https://www.payfast.co.za​/eng/process'; //?' . http_build_query($params);
        }
    }

    /**
     * Return form field array
     *
     * @return array
     */
    public function getFormFields()
    {
        $cart = $this->getCart();
        $fields = [
            'merchant_id'     => $this->getConfigData('merchant_id'),
            'merchant_key'    => $this->getConfigData('merchant_key'),
            'm_payment_id'    =>  $cart->id,
            'return_url'      => route('payfast.success'),
            'cancel_url'      => route('payfast.cancel'),
            'notify_url'      => route('payfast.itn'),
            'charset'         => 'utf-8',
            'item_name'       => 'Cart No: ' . $cart->id,
            'amount'          => $cart->grand_total,
        ];

        $field['signature'] = $this->generateSignature($fields, $this->getConfigData('pass_phrase'));

        return $fields;
    }

    /**
     * @param array $data
     * @param null $passPhrase
     * @return string
     */
    private function generateSignature($data, $passPhrase = null)
    {
        // Create parameter string
        $pfOutput = '';
        foreach ($data as $key => $val) {
            if (!empty($val)) {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        // Remove last ampersand
        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }
        return md5($getString);
    }
}
