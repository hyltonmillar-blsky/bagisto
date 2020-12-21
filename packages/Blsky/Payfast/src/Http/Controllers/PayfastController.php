<?php

namespace Blsky\Payfast\Http\Controllers;

use Illuminate\Http\Request;
use Blsky\Payfast\Helpers\Itn;
use Webkul\Checkout\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Webkul\Sales\Repositories\OrderRepository;

class PayfastController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * Itn object
     *
     * @var \Blsky\Payfast\Helpers\Itn
     */
    protected $itnHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\OrderRepository  $orderRepository
     * @param  \Blsky\Payfast\Helpers\Itn  $itnHelper
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        Itn $itnHelper
    ) {
        $this->orderRepository = $orderRepository;

        $this->itnHelper = $itnHelper;
    }

    /**
     * Redirects to the payfast.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('payfast::payfast-redirect');
    }

    /**
     * Cancel payment from payfast.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', 'Payfast payment has been canceled.');

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $cart = Cart::getCart();
        $order = $this->orderRepository->findOneByField(['cart_id' => $cart->id]);
        if (isset($order->cart_id) && ($order->cart_id == $cart->id)) {
            // payfast payment all good 
            Cart::deActivateCart();
            session()->flash('order', $order);
            return redirect()->route('shop.checkout.success');
        } else {
            // the order was not created during the itn, check logs for error detail.
            Log::warning('Success call did not come from Payfast');
            session()->flash('error', 'Error with Payfast payment information being received. Please try again.');
            return redirect()->route('shop.checkout.cart.index');
        }
    }

    /**
     * Payfast Itn listener
     *
     * @return \Illuminate\Http\Response
     */
    public function itn()
    {
        $this->itnHelper->processItn(request()->all());
        return response('done', 200);
    }
}
