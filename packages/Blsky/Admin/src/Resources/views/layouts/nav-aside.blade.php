<div class="aside-nav">
    <ul>
        @if (request()->route()->getName() != 'admin.configuration.index' and request()->route()->getName() != 'blsky.configuration.index')
            <?php $keys = explode('.', $menu->currentKey);  ?>

            @if(isset($keys) && strlen($keys[0]))
            @foreach (\Illuminate\Support\Arr::get($menu->items, current($keys) . '.children') as $item)
                <li class="{{ $menu->getActive($item) }}">
                    <a href="{{ $item['url'] }}">
                        {{ trans($item['name']) }}

                        @if ($menu->getActive($item))
                            <i class="angle-right-icon"></i>
                        @endif
                    </a>
                </li>
            @endforeach
            @endif
        @else
            @foreach ($config->items as $key => $item)
                <li class="{{ $item['key'] == request()->route('slug') ? 'active' : '' }}">
                @if (request()->route()->getName() != 'blsky.configuration.index')
                    <a href="{{ route('admin.configuration.index', $item['key']) }}">
                    @else
                    <a href="{{ route('blsky.configuration.index', $item['key']) }}">
                    @endif
                        {{ isset($item['name']) ? trans($item['name']) : '' }}

                        @if ($item['key'] == request()->route('slug'))
                            <i class="angle-right-icon"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        @endif
    </ul>

    <!-- <div class="close-nav-aside">
        <i class="icon angle-left-icon close-icon"></i>
    </div> -->
</div>
