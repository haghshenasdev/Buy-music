@extends('master.theme')

@section('content')
    <div class="row mx-3 row-cols-1 row-cols-md-3 g-4" id="content" style="margin-top: -100px">
        @foreach($musics as $music)
        <div class="col card forg-color mx-auto p-3">
            <img src="{{ $music['cover'] }}" class="card-img-top" alt="{{ $music['title'] }}">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $music['title'] }}</h5>
                <a class="btn btn-primary w-100 mt-2" href="./{{ $music['slug'] }}">مشاهده</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection