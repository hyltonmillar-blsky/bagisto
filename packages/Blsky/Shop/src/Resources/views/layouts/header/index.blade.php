<?php
    $term = request()->input('term');
    $image_search = request()->input('image-search');

    if (! is_null($term)) {
        $serachQuery = 'term='.request()->input('term');
    }
?>

<div class="header bg-white" id="header">
    <div class="container-fluid  border-bottom">
        <div class="container py-2">
            <div class="row">
                <div class="col-auto">
                    <span class="text-primary text-sm">tagline</span>
                </div>
                <div class="col-auto">
                    <span class="text-primary"><small>Contact Details</small></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Header -->
    <div class="header-top container d-block ">
        <nav class="">
            <div class="row py-3 row justify-content-center">
                <!-- Logo -->
                <div class="col-10 col-md-12 col-lg-3 text-sm-center text-md-center">
                    <a href="{{ route('shop.home.index') }}" aria-label="Logo">
                            @if ($logo = core()->getCurrentChannel()->logo_url)
                                <img class="logo" style="width:auto; max-width:100%;" src="{{ $logo }}" alt="" />
                            @else
                                <img class="logo" src="{{ bagisto_asset('images/logo.svg') }}" alt="" />
                            @endif
                    </a>
                </div>
                <div class="col-2 col-md-12 col-lg-3 text-sm-center text-md-center d-block d-md-none">

                <span class="menu-box" ><span class="fa fa-2x fa-bars" style="cursor:pointer;"  id="hammenu"></span>
                </div>
                <!-- Search -->
                <div class="col-12 col-md-6 col-lg-6 d-none d-md-block">
  
                        <form class="input-group" role="search" action="{{ route('shop.search.index') }}" method="GET">
                            <input
                                    required
                                    name="term"
                                    type="search"
                                    value="{{ ! $image_search ? $term : '' }}"
                                    class="search-field px-2 form-control"
                                    id="search-bar"
                                    placeholder="{{ __('shop::app.header.search-text') }}"
                                >
                                <image-search-component></image-search-component>
                            <div class="input-group-append">
                                <button class="btn btn-primary" class="background: none;" aria-label="Search"><i class="fa fa-lg fa-search "></i></button>
                            </div>
                        </form>

                </div>
                <!-- Account / Login -->
                
                <div class="col-12 col-md-12 col-lg-3 right-content mt-3 justify-content-center  text-md-center text-lg-right">
                <span class="search-box"><span class="fa fa-lg fa-search" id="search"></span></span>
                    <ul class="right-content-menu">
                    {!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}

                        <li>
                            <span class="dropdown-toggle">
                                <i class="fa fa-lg fa-user"></i>

                                <span class="name">{{ __('shop::app.header.account') }}</span>

                                
                            </span>

                            @guest('customer')
                                <ul class="dropdown-list account guest" style="width:300px;">
                                    <li>
                                        <div class="">
                                            <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                                {{ __('shop::app.header.title') }}
                                            </label>
                                        </div>

                                        <div style="margin-top: 5px;">
                                            <span style="font-size: 12px;">{{ __('shop::app.header.dropdown-text') }}</span>
                                        </div>

                                        <div style="margin-top: 15px;">
                                            <a class="btn btn-primary btn-md" href="{{ route('customer.session.index') }}" style="color: #ffffff">
                                                {{ __('shop::app.header.sign-in') }}
                                            </a>

                                            <a class="btn btn-primary btn-md" href="{{ route('customer.register.index') }}" style="float: right; color: #ffffff">
                                                {{ __('shop::app.header.sign-up') }}
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            @endguest

                            @auth('customer')
                                @php
                                $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                                @endphp

                                <ul class="dropdown-list account customer">
                                    <li>
                                        <div>
                                            <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                                {{ auth()->guard('customer')->user()->first_name }}
                                            </label>
                                        </div>

                                        <ul>
                                            <li>
                                                <a href="{{ route('customer.profile.index') }}">{{ __('shop::app.header.profile') }}</a>
                                            </li>

                                            @if ($showWishlist)
                                                <li>
                                                    <a href="{{ route('customer.wishlist.index') }}">{{ __('shop::app.header.wishlist') }}</a>
                                                </li>
                                            @endif

                                            <li>
                                                <a href="{{ route('shop.checkout.cart.index') }}">{{ __('shop::app.header.cart') }}</a>
                                            </li>

                                            <li>
                                                <a href="{{ route('customer.session.destroy') }}">{{ __('shop::app.header.logout') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            @endauth
                        </li>

                        {!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}

                        <li class="cart-dropdown-container">

                            @include('shop::checkout.cart.mini-cart')

                        </li>

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}
                    </ul>
                    <!--<span class="menu-box" ><span class="fa fa-lg fa-bars" style="cursor:pointer;"  id="hammenu"></span>-->
                </div>
            </div>
        </nav>
    </div>


    <div class="header-top container pt-3 d-none">
        <div class="left-content">



        </div>

        <div class="right-content">

            <span class="search-box"><span class="fa fa-lg fa-search" id="search"></span></span>

            <ul class="right-content-menu">

                {!! view_render_event('bagisto.shop.layout.header.comppare-item.before') !!}

                @php
                    $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false
                @endphp

                @if ($showCompare)
                    <li class="compare-dropdown-container">
                        <a
                            @auth('customer')
                                href="{{ route('velocity.customer.product.compare') }}"
                            @endauth

                            @guest('customer')
                                href="{{ route('velocity.product.compare') }}"
                            @endguest
                            style="color: #242424;"
                            >

                            <i class="icon compare-icon"></i>
                            <span class="name">
                                {{ __('shop::app.customer.compare.text') }}
                                <span class="count">(<span id="compare-items-count"></span>)<span class="count">
                            </span>
                        </a>
                    </li>
                @endif

                {!! view_render_event('bagisto.shop.layout.header.compare-item.after') !!}

                {!! view_render_event('bagisto.shop.layout.header.currency-item.before') !!}

                @if (core()->getCurrentChannel()->currencies->count() > 1)
                    <li class="currency-switcher">
                        <span class="dropdown-toggle">
                            {{ core()->getCurrentCurrencyCode() }}

                            <i class="icon arrow-down-icon"></i>
                        </span>

                        <ul class="dropdown-list currency">
                            @foreach (core()->getCurrentChannel()->currencies as $currency)
                                <li>
                                    @if (isset($serachQuery))
                                        <a href="?{{ $serachQuery }}&currency={{ $currency->code }}">{{ $currency->code }}</a>
                                    @else
                                        <a href="?currency={{ $currency->code }}">{{ $currency->code }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                {!! view_render_event('bagisto.shop.layout.header.currency-item.after') !!}


                {!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}

                <li>
                    <span class="dropdown-toggle">
                        <i class="fa fa-lg fa-user"></i>

                        <span class="name">{{ __('shop::app.header.account') }}</span>

                        <!--<i class="icon arrow-down-icon"></i>-->
                    </span>

                    @guest('customer')
                        <ul class="dropdown-list account guest">
                            <li>
                                <div>
                                    <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                        {{ __('shop::app.header.title') }}
                                    </label>
                                </div>

                                <div style="margin-top: 5px;">
                                    <span style="font-size: 12px;">{{ __('shop::app.header.dropdown-text') }}</span>
                                </div>

                                <div style="margin-top: 15px;">
                                    <a class="btn btn-primary btn-md" href="{{ route('customer.session.index') }}" style="color: #ffffff">
                                        {{ __('shop::app.header.sign-in') }}
                                    </a>

                                    <a class="btn btn-primary btn-md" href="{{ route('customer.register.index') }}" style="float: right; color: #ffffff">
                                        {{ __('shop::app.header.sign-up') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endguest

                    @auth('customer')
                        @php
                           $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                        @endphp

                        <ul class="dropdown-list account customer">
                            <li>
                                <div>
                                    <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                        {{ auth()->guard('customer')->user()->first_name }}
                                    </label>
                                </div>

                                <ul>
                                    <li>
                                        <a href="{{ route('customer.profile.index') }}">{{ __('shop::app.header.profile') }}</a>
                                    </li>

                                    @if ($showWishlist)
                                        <li>
                                            <a href="{{ route('customer.wishlist.index') }}">{{ __('shop::app.header.wishlist') }}</a>
                                        </li>
                                    @endif

                                    <li>
                                        <a href="{{ route('shop.checkout.cart.index') }}">{{ __('shop::app.header.cart') }}</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('customer.session.destroy') }}">{{ __('shop::app.header.logout') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endauth
                </li>

                {!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}


                {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}

                <li class="cart-dropdown-container">

                    @include('shop::checkout.cart.mini-cart')

                </li>

                {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}

            </ul>

            <!--<span class="menu-box d-none" ><span class="fa fa-lg fa-bars" style="cursor:pointer;" id="hammenu"></span>-->
        </div>
    </div>

    <div class="header-bottom container-fluid" id="header-bottom">
        <div class="container">
        @include('shop::layouts.header.nav-menu.navmenu')
        </div>
    </div>

    <div class="search-responsive mt-10" id="search-responsive">
        <form role="search" action="{{ route('shop.search.index') }}" method="GET" style="display: inherit;">
            <div class="search-content px-2">
                <button style="background: none; border: none; padding: 0px;">
                    <i class="fa fa-lg fa-search"></i>
                </button>

                <image-search-component></image-search-component>

                <input type="search" name="term" class="search">
                <i class="fa fa-lg fa-arrow-left right"></i>
            </div>
        </form>
    </div>
</div>


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet" defer></script>

    <script type="text/x-template" id="image-search-component-template">
        <div v-if="image_search_status">
            <label class="image-search-container" :for="'image-search-container-' + _uid">
                <i class="icon camera-icon"></i>

                <input type="file" :id="'image-search-container-' + _uid" ref="image_search_input" v-on:change="uploadImage()"/>

                <img :id="'uploaded-image-url-' +  + _uid" :src="uploaded_image_url" alt="" width="20" height="20" />
            </label>
        </div>
    </script>

    <script>

        Vue.component('image-search-component', {

            template: '#image-search-component-template',

            data: function() {
                return {
                    uploaded_image_url: '',
                    image_search_status: "{{core()->getConfigData('general.content.shop.image_search') == '1' ? true : false}}"
                }
            },

            methods: {
                uploadImage: function() {
                    var imageInput = this.$refs.image_search_input;

                    if (imageInput.files && imageInput.files[0]) {
                        if (imageInput.files[0].type.includes('image/')) {
                            var self = this;

                            if (imageInput.files[0].size <= 2000000) { 
                                self.$root.showLoader();

                                var formData = new FormData();

                                formData.append('image', imageInput.files[0]);

                                axios.post("{{ route('shop.image.search.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}})
                                    .then(function(response) {
                                        self.uploaded_image_url = response.data;

                                        var net;

                                        async function app() {
                                            var analysedResult = [];

                                            var queryString = '';

                                            net = await mobilenet.load();

                                            const imgElement = document.getElementById('uploaded-image-url-' +  + self._uid);

                                            try {
                                                const result = await net.classify(imgElement);

                                                result.forEach(function(value) {
                                                    queryString = value.className.split(',');

                                                    if (queryString.length > 1) {
                                                        analysedResult = analysedResult.concat(queryString)
                                                    } else {
                                                        analysedResult.push(queryString[0])
                                                    }
                                                });
                                            } catch (error) {
                                                self.$root.hideLoader();

                                                window.flashMessages = [
                                                    {
                                                        'type': 'alert-error',
                                                        'message': "{{ __('shop::app.common.error') }}"
                                                    }
                                                ];

                                                self.$root.addFlashMessages();
                                            };

                                            localStorage.searched_image_url = self.uploaded_image_url;

                                            queryString = localStorage.searched_terms = analysedResult.join('_');

                                            self.$root.hideLoader();

                                            window.location.href = "{{ route('shop.search.index') }}" + '?term=' + queryString + '&image-search=1';
                                        }

                                        app();
                                    })
                                    .catch(function(error) {
                                        self.$root.hideLoader();

                                        window.flashMessages = [
                                            {
                                                'type': 'alert-error',
                                                'message': "{{ __('shop::app.common.error') }}"
                                            }
                                        ];

                                        self.$root.addFlashMessages();
                                    });
                            } else {

                                imageInput.value = '';

                                        window.flashMessages = [
                                            {
                                                'type': 'alert-error',
                                                'message': "{{ __('shop::app.common.image-upload-limit') }}"
                                            }
                                        ];

                                self.$root.addFlashMessages();
                                
                            }        
                        } else {
                            imageInput.value = '';

                            alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                        }
                    }
                }
            }
        });

    </script>

    <script>
        $(document).ready(function() {

            $('body').delegate('#search, .fa-bars, .fa-times, .icon-menu-close, .icon.icon-menu', 'click', function(e) {
                toggleDropdown(e);
            });

            @auth('customer')
                @php
                    $compareCount = app('Webkul\Velocity\Repositories\VelocityCustomerCompareProductRepository')
                        ->count([
                            'customer_id' => auth()->guard('customer')->user()->id,
                        ]);
                @endphp

                let comparedItems = JSON.parse(localStorage.getItem('compared_product'));
                $('#compare-items-count').html({{ $compareCount }});
            @endauth

            @guest('customer')
                let comparedItems = JSON.parse(localStorage.getItem('compared_product'));
                $('#compare-items-count').html(comparedItems ? comparedItems.length : 0);
            @endguest

            function toggleDropdown(e) {
                var currentElement = $(e.currentTarget);

                if (currentElement.hasClass('fa-search')) {
                    currentElement.removeClass('fa-search');
                    currentElement.addClass('fa-times');
                    $('#hammenu').removeClass('fa-times');
                    $('#hammenu').addClass('fa-bars');
                    $("#search-responsive").css("display", "block");
                    $("#header-bottom").css("display", "none");
                } else if (currentElement.hasClass('fa-bars')) {
                    currentElement.removeClass('fa-bars');
                    currentElement.addClass('fa-times');
                    $('#search').removeClass('fa-times');
                    $('#search').addClass('fa-search');
                    $("#search-responsive").css("display", "none");
                    $("#header-bottom").css("display", "block");
                } else {
                    currentElement.removeClass('fa-times');
                    $("#search-responsive").css("display", "none");
                    $("#header-bottom").css("display", "none");
                    if (currentElement.attr("id") == 'search') {
                        currentElement.addClass('fa-search');
                    } else {
                        currentElement.addClass('fa-bars');
                    }
                }
            }
        });
    </script>
@endpush