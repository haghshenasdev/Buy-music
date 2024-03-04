@extends('master.theme')

@section('content')
    <div class="row justify-content-center" style="margin-top: -70px">
        <div class="col mx-3 col-sm-4 card forg-color p-3">
            <h2 class="cart-header text-center">بازیابی رمز عبور</h2>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-auto col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    @include('layouts.recapcha')


                    <div class="row mb-0">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection
