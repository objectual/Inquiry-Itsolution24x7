@include('web.layouts.header')
<style>
    header {
        background: #5bc9f4 !important;
        position: inherit;
    }
</style>
<section>
</section>

<div class="main-content">
    <section class="overview-block-ptb it-works">
        <div class="container">
            <div class="row">
                @if($name == 1)
                    {{--@include('web.layouts.sidebar')--}}
                    @include('web.email')
                @elseif($name == 10 )
                    @include('web.thanks')
                @elseif($name == 2 )
                    @include('web.layouts.sidebar')
                    @include('web.description')
                @elseif($name == 3 )
                    @include('web.layouts.sidebar')
                    @include('web.detail')
                @elseif($name == 4 )
                    @include('web.layouts.sidebar')
                    @include('web.question')
                @elseif($name == 5 )
                    @include('web.layouts.sidebar')
                    @include('web.expertise')
                @elseif($name == 6 )
                    @include('web.layouts.sidebar')
                    @include('web.budget')
                @elseif($name == 7 )
                    @include('web.layouts.sidebar')
                    @include('web.title')
                @elseif($name == 8)
                    @include('web.confirmation')
                @elseif($name == 9)
                    @include('web.layouts.sidebar')
                    @include('web.review')
                @endif()
            </div>
        </div>

    </section>
</div>

@include('web.layouts.footer')
