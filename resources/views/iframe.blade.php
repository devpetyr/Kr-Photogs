@extends('layout.main')
@section('main')
    <!-- main -->
    <main>
        <section>
            <div class="container">
                <div class="row">
{{--                    <iframe class="ifram-redeem"--}}
{{--                        src="{{session()->get('redeem')['url']}}"--}}
{{--                        title="YouTube video player" frameborder="0"--}}
{{--                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"--}}
{{--                        allowfullscreen></iframe>--}}
{{--                    {!! session()->get('redeem')['iframe'] !!}--}}
                    @if($iframe)
                        {!! $iframe !!}
                    @else
                        <div class="text-center text-danger pt-5">404 Not Found <br> Link has not been set up by admin</div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    <!-- end main -->
@endsection
@include('layout.authchecker')
