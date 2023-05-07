@extends('master.theme')

@section('content')
    <div class="row mx-3 row-cols-1 row-cols-md-4 justify-content-center gap-2" id="content" style="margin-top: -100px">
        @if(count($musics) == 0)
            <div class="col card forg-color p-3">
                <div class="card-body text-center">
                    <h5 class="card-title my-4">هیچ موزیکی برای نمایش وجود ندارد!</h5>
                </div>
            </div>
        @else
            @foreach($musics as $music)
                <div class="col card forg-color p-3">
                    <img src="{{ $music['cover'] }}" class="card-img-top" alt="{{ $music['title'] }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $music['title'] }}
                            @if($music['presell'])
                                <span class="badge rounded-pill text-bg-warning">پیش فروش </span>
                            @endif
                        </h5>
                        <a class="btn btn-primary w-100 mt-2" href="./{{ $music['slug'] }}">مشاهده</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
