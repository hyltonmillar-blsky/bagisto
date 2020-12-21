@if (count($sliderData))
    <section class="slider-block" style="">
        <image-slider :slides='@json($sliderData)' public_path="{{ url()->to('/') }}"></image-slider>
    </section>
@endif