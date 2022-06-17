@extends('layout.main')
@section('main')
    <!-- main -->
    <main>
        <!-- BEGIN Banner -->
        <section class="BannerBg">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <!--<div class="playbtn wow zoomIn" data-wow-duration="2.s">-->
                        <!--    <a href="https://www.youtube.com/watch?v=D4sYONqdjCk" target="_blank"><i-->
                        <!--            class="fa-solid fa-circle-play"></i></a>-->
                        <!--</div>-->
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="bannerText wow fadeInRight" data-wow-duration="2.s">
                            <span>KrPhotogs <br />
                                Photography <br />
                                Live Streaming
                                </span>

                            <!--<a href="#"><i class="fa-solid fa-play"></i> Watch Now</a>-->

                                    <div class="afterBannerSec">
            <div class="redline">
                <div class="">
                    <div class="FormMain wow fadeInLeft" data-wow-duration="2.s">
                        <form class="row" action="{{ route('competition') }}" method="post">
                            @csrf
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <select class="form-select" aria-label="Default select example" id="comp_name" name="comp">
                                    <option selected hidden value="">Pick a competition</option>
                                    @foreach ($competition as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <span style="color: red; font-size: 20px;">
                                    @error('comp')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="date"  disabled class="form-control" id="comp_date" value="" />
                                <span style="color: red; font-size: 20px;">
                                    @error('dates')
                                        {{ $message }}
                                    @enderror
                                </span><br>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="btn btn-primary ">
                                    <!--<i class="fa-solid fa-magnifying-glass"></i>-->
                                    Buy Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END Banner -->
        <!-- BEGIN After Banner -->
        <!--<section class="afterBannerSec">-->
        <!--    <div class="redline">-->
        <!--        <div class="container">-->
        <!--            <div class="FormMain wow fadeInLeft" data-wow-duration="2.s">-->
        <!--                <form class="row" action="{{ route('competition') }}" method="post">-->
        <!--                    @csrf-->
        <!--                    <div class="col-md-5 col-sm-5 col-xs-12">-->
        <!--                        <select class="form-select" aria-label="Default select example" id="comp_name" name="comp">-->
        <!--                            <option selected hidden value="">pick a competition</option>-->
        <!--                            @foreach ($competition as $item)-->
        <!--                                <option value="{{ $item->id }}">{{ $item->title }}</option>-->
        <!--                            @endforeach-->
        <!--                        </select>-->
        <!--                        <span style="color: red; font-size: 20px;">-->
        <!--                            @error('comp')-->
        <!--                                {{ $message }}-->
        <!--                            @enderror-->
        <!--                        </span>-->
        <!--                    </div>-->
        <!--                    <div class="col-md-5 col-sm-5 col-xs-12">-->
        <!--                            <input type="date"  disabled class="form-control" id="comp_date" value="" />-->
        <!--                        <span style="color: red; font-size: 20px;">-->
        <!--                            @error('dates')-->
        <!--                                {{ $message }}-->
        <!--                            @enderror-->
        <!--                        </span><br>-->
        <!--                    </div>-->
        <!--                    <div class="col-md-2 col-sm-2 col-xs-12">-->
        <!--                        <button type="submit" class="btn btn-primary ">-->
                                    <!--<i class="fa-solid fa-magnifying-glass"></i>-->
        <!--                            Buy Now-->
        <!--                        </button>-->
        <!--                    </div>-->
        <!--                </form>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->
        <!-- END After Banner -->
        <!-- Banner Qasim Start  -->



        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="contact_1 wow fadeInRight" data-wow-delay="0.2s">
                            <h1>Get in touch with us</h1>
                        </div>
                    </div>
                </div>
                <form action="{{route('contactForm')}}" method="post">@csrf
                    <div class="contact_2 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="name" placeholder="Enter your name" required/>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="contact_4 wow fadeInLeft" data-wow-delay="0.2s">
                                <textarea class="form-control" name="message" placeholder="Leave a comment here" id=""></textarea>
                                <button>Send to us</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- Banner Qasim  End -->

    </main>
    <!-- end main -->
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script>
        $(document).ready(function(){
            $("#comp_name").change(function(){
                // e.preventDefault();
                var name = $( "#comp_name" ).val();

                //   var formData = new FormData(this);
                $.ajax({
                    url:"{{url('comp_ajax')}}",
                    type: 'POST',
                    data: {
                        name:name,
                        '_token': '{{csrf_token()}}',
                    },
                    cache: false,
                    success: function(data) {
                        if(data !== "")
                        {
                            $('#comp_date').val(data.data);
                            // alert(data.data);
                        }
                        else
                        {
                            alert("Error");
                        }
                        // $("#name")[0].reset();
                    }
                });

            });

        });


    </script>

@endpush
