@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    پروفایل کاربر
                    @can('admin')
                        <span class="badge rounded-pill text-bg-primary">مدیر </span>
                    @endcan
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                    <form method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="col-form-label">نام و نام خانوادگی :</label>
                            <input name="name" type="text" class="form-control" id="name"
                                   value="@isset($data){{$data['name']}}@else{{ old('name') }}@endisset">
                        </div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="mb-3">
                            <label for="email" class="col-form-label">آدرس ایمیل :</label>
                            <input name="email" type="text" class="form-control" id="email"
                                   value="@isset($data){{$data['email']}}@else{{ old('email') }}@endisset">
                        </div>
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <input class="btn btn-success" type="submit"
                               value="بروز رسانی">

                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    تغییر رمز عبور
                </div>

                <div class="card-body">
                    @if (session('success1'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success1') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <form method="post" action="{{ route('changePass') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <label for="old_pas" class="col-md-4 col-form-label text-md-end">رمز عبور قدیمی :</label>

                            <div class="col-md-6">
                                <input id="old_pas" type="password" class="form-control @error('old_pas') is-invalid @enderror" name="old_pas" required autocomplete="new-password">

                                @error('old_pas')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <input class="btn btn-success" type="submit"
                               value="بروز رسانی">

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
