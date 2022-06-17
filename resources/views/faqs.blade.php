@extends('layout.main')
@section('main')

    <section  class="RegisterSec">
        <div class="container">
{{--            <div class="Faqsmain">--}}
{{--                <span>FREQUENTLY ASKED QUESTIONS (FAQ’s)</span>--}}
{{--                <small><i class="fa-solid fa-circle-check"></i> If I run out of time and fail to complete the CEUs before my state license renewal, can you backdate my certificate?</small>--}}
{{--                <p>NO! Absolutely not! The date on your certificate will be the date you successfully completed the course.</p>--}}
{{--            </div>--}}
            <div class="Faqsmain">
                <span>FREQUENTLY ASKED QUESTIONS (FAQ’s)</span>
                @foreach($faqs as $values)
                    <small><i class="fa-solid fa-circle-check"></i> {{$values->question}}</small>
                    <p>{{$values->answer}}</p>
                @endforeach
            </div>
        </div>
    </section>




@endsection
