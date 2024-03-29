@extends('master.theme')

@section('content')
<div class="row justify-content-center" style="margin-top: -70px">
    <div class="col mx-3 col-sm-4 card forg-color p-3">
        <h2 class="cart-header text-center">{{ __('Register') }}</h2>

        <div class="card-body text-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf


                <div class="mb-3">
                    <label for="name" class="col col-form-label text-md-end">نام و نام خانوادگی </label>

                    <div class="col">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>



                <div class="mb-3">
                    <label for="email" class="col col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="col col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="col col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                @include('layouts.recapcha')

                <div class="row mb-0">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
