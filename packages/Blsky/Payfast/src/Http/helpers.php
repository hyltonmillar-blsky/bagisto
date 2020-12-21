<?php
    use Blsky\Payfast\PayfastCart;

    if (! function_exists('payfastcart')) {
        function payfastcart()
        {
            return app()->make(PayfastCart::class);
        }
    }