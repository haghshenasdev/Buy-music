@extends('master.theme')

@section('content')
    <div class="row mx-3" id="content" style="margin-top: -100px">
        <div class="col-10 forg-color mx-auto p-3 row">
            <img src="{{ $data['cover'] }}" class="col-lg-4 col mb-3 m-auto" alt="{{ $data['title'] }}">

            <h1 class="mb-3">{{ $data['title'] }}</h1>
            <br>
            {!! $data['description'] !!}
        </div>

        <div class="col-10 mt-3 text-center forg-color mx-auto p-3">
            @auth()
                @if($payed)
                    @if($data['presell'] == 1)
                        <h1>شما موزیک را پیش خرید کرده اید</h1>
                        <p> {!! $data['description_download'] !!}</p>
                    @else
                        <h1>شما موزیک را خریده اید</h1>
                        <p> {!! $data['description_download'] !!}</p>
                        <a class="btn btn-success mt-3" href="{{ $routeDl }}">دریافت موزیک</a>
                    @endif
                @else
                    @if($data['presell'])
                        <h1>پیش خرید</h1>
                    @else
                        <h1>خرید و دانلود</h1>
                    @endif

                    <form method="post">
                        @csrf
                        @if($data['amount'])
                            <div class="mb-3 mt-3">
                                <label for="exampleInputEmail1" class="form-label">مبلغ
                                    : {{ number_format($data['amount']) }} تومان</label>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">مبلغ دلخواه(به تومان) :</label>
                                <input name="amount" type="number" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            @error('amount')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @endif

                        <button type="submit" class="btn btn-primary">خرید و دانلود</button>
                    </form>

                @endif
            @else
                @if($data['presell'])
                    <h1>پیش خرید</h1>
                @else
                    <h1>خرید و دانلود</h1>
                @endif

                <p>لطفا ابتدا وراد حساب کاربری خود شوید . اگر حساب کاربری ندارید ثبت نام کنید.</p>
                <div class="d-grid gap-2 d-md-block">
                    <a onclick="set_back_url()" href="{{ route('login') }}" class="btn btn-primary">ورود</a>
                    <a onclick="set_back_url()" href="{{ route('register') }}" class="btn btn-primary">ثبت نام</a>
                    <script !src="">
                        function set_back_url(){
                            document.cookie = 'bk_url={{url()->current()}}';
                        }
                    </script>
                </div>
            @endif

        </div>
    </div>
@endsection
