@extends('layout.users')
@section('bottom_scripts')
    <script src="/userAssets/js/carousel.js"></script>
@endsection

@section('style')

    <link rel="stylesheet" href="/userAssets/css/carousel.css">
    <link rel="stylesheet" href="/userAssets/css/styles.css">

@endsection

@section('content')
    <div id="app">
        <section class="content">


            <div class="well titleCarousel">
                <h3>بهترین ها</h3>
            </div>
            @include('users.sections.carousel',['items'=>$best_reservable_center,'showStar'=>true])


            <div class="well titleCarousel">
                <h3>لیست تمام مراکز</h3>
            </div>
            @include('users.sections.carousel',['items'=>$all_reservable_center,'showStar'=>false])


        </section>
    </div>


@endsection



