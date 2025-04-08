@extends(backpack_view('blank'))

@php
    // Configure widgets based on theme settings
    if (backpack_theme_config('show_getting_started')) {
        $widgets['before_content'][] = [
            'type' => 'view',
            'view' => backpack_view('inc.getting_started'),
        ];
    }
@endphp

@section('content')
   <div class="flex items-center justify-center h-screen w-full bg-gray-800 text-white">
    <h1 class="text-center font-extrabold uppercase tracking-widest w-full" style="font-size: 4.5em; font-weight: bold; color: rgb(248, 171, 184); text-align: center; padding: 10px;">
        ADMIN
    </h1>
</div>


    <div class="container mt-4">
        @if (!empty($widgets['before_content']))
            @foreach ($widgets['before_content'] as $widget)
                @include($widget['view'])
            @endforeach
        @endif
    </div>
@endsection

@section('after_scripts')
    <script>
        window.onload = function() {
            if (typeof history.pushState === "function") {
                history.pushState("jibberish", null, null);
                window.onpopstate = function() {
                    history.pushState("newjibberish", null, null);
                };
            }
        }
    </script>
@endsection
