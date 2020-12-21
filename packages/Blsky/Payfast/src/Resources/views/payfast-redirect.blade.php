<?php $payfast = app('Blsky\Payfast\Payment\Payfast') ?>

<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    You will be redirected to the Payfast website in a few seconds.


    <form action="{{ $payfast->getPayfastUrl() }}" id="payfast_checkout" method="POST">
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">

        @foreach ($payfast->getFormFields() as $name => $value)

        <input type="hidden" name="{{ $name }}" value="{{ $value }}">

        @endforeach

    </form>

    <script type="text/javascript">
        document.getElementById("payfast_checkout").submit();
    </script>
</body>