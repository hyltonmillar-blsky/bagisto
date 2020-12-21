<?php

namespace Blsky\Payfast;

use Webkul\Checkout\Cart;

class PayfastCart extends Cart
{
    public $cart_id = null;

    /**
     * Validate order before creation
     *
     * @return array
     */
    public function PayfastprepareDataForOrder($id): array
    {
        $this->cart_id = $id;

        return $this->prepareDataForOrder();
    }

    public function PayfastgetCart($id): ?\Webkul\Checkout\Contracts\Cart
    {
        $this->cart_id = $id;

        return $this->getCart();
    }

    public function getCart(): ?\Webkul\Checkout\Contracts\Cart
    {
        $cart = null;

        if ($this->cart_id) {
            $cart = $this->cartRepository->find($this->cart_id);
        }

        $this->removeInactiveItems($cart);

        return $cart;
    }
}
