@extends('master.theme')

@section('content')
    <div class="row mx-3" id="content" style="margin-top: -100px">
        <div class="col forg-color mx-auto p-3 row">
            <img src="{{ $data['cover'] }}" class="col-lg-4 col mb-3 m-auto" alt="{{ $data['title'] }}">

            <h1 class="mb-3">{{ $data['title'] }}</h1>
            <br>
            {!! $data['description'] !!}
        </div>
    </div>

    <div class="row mx-3 mt-3 gap-3">
        <div class="col text-center forg-color mx-auto p-3">
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

                    <div class="m-3">
                        @include('layouts.comment')
                    </div>

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
                            <div class="mt-3 row">
                                @php
                                $min_amount = is_null($data['min_amount']) ? App\Setting\SettingSystem::get('min_amount') : $data['min_amount'];
                                @endphp
                                <label for="exampleInputEmail1" class="form-label">مبلغ دلخواه (حداقل مبلغ برای این موزیک {{ number_format($min_amount) }} تومان) :</label>
                                <div class="col col-lg-4 mx-auto">
                                    <div class="input-group">
                                        <input onkeyup="toPr(this.value)" value="{{ $min_amount }}" name="amount" type="number" class="form-control" id="amount-input"
                                               aria-describedby="emailHelp">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                                <p class="mt-3" id="prOut"></p>

                                <script src="https://cdn.jsdelivr.net/gh/mahmoud-eskandari/NumToPersian/dist/num2persian-min.js"></script>
                                <script>
                                    function toPr(num) {
                                        let el = document.getElementById('prOut');
                                        el.innerText = "معادل : " + Num2persian(num) + " تومان";
                                        let min = {{ $min_amount }};
                                        if(num < min){
                                            el.className = 'mt-3 text-danger';
                                        }else{
                                            el.className = 'mt-3';
                                        }
                                    }
                                </script>
                            </div>
                            @error('amount')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @endif

                        <button type="submit" class="btn btn-primary">خرید و حمایت</button>
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

        <div class="col-12 col-lg forg-color mx-auto p-3 row">
            <h1 class="text-center">حمایت ها</h1>

            <div class="w-100 text-right">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">بیشترین</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">آخرین</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        @foreach($topProtection as $item)
                            <div class="border-bottom mt-3 row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                            </svg>
                                        </div>
                                        <div class="col"><p>{{ $item['name'] }}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                            </svg>
                                        </div>
                                        <div class="col"><p>{{ number_format($item['amount']) }} تومان </p></div>
                                    </div>
                                    @if($item['is_active'] == 1)
                                        <div class="row">
                                            <div class="col-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-quote" viewBox="0 0 16 16">
                                                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                                    <path d="M7.066 6.76A1.665 1.665 0 0 0 4 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                                                </svg>
                                            </div>
                                            <div class="col"><p>{{ $item['comment'] }}</p></div>
                                        </div>
                                    @endif
                                </div>
                                @if($item['is_presell'])
                                    <div class="col-auto pb-2"><img src="{{ asset('assets/image/presell.png') }}" width="60px"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        @foreach($lastProtection as $item)
                            <div class="border-bottom mt-3 row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                            </svg>
                                        </div>
                                        <div class="col"><p>{{ $item['name'] }}</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                            </svg>
                                        </div>
                                        <div class="col"><p>{{ number_format($item['amount']) }} تومان </p></div>
                                    </div>
                                    @if($item['is_active'] == 1)
                                        <div class="row">
                                            <div class="col-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-quote" viewBox="0 0 16 16">
                                                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                                    <path d="M7.066 6.76A1.665 1.665 0 0 0 4 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                                                </svg>
                                            </div>
                                            <div class="col"><p>{{ $item['comment'] }}</p></div>
                                        </div>
                                    @endif
                                </div>
                                @if($item['is_presell'])
                                    <div class="col-auto pb-2"><img src="{{ asset('assets/image/presell.png') }}" width="60px"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
