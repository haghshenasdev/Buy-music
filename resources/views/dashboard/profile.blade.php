@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    پروفایل کاربر
                    @can('super-admin')
                        <span class="badge rounded-pill text-bg-primary">مدیر کل</span>
                    @elsecan('charity-admin')
                        <span class="badge rounded-pill text-bg-primary">مدیر خیریه</span>
                    @elsecan('employee-admin')
                        <span class="badge rounded-pill text-bg-primary">کارمند خیریه</span>
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
                            <label for="name" class="col-form-label">نام :</label>
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

                        <div class="mb-3">
                            <label for="phone" class="col-form-label">تلفن :</label>
                            <input name="phone" type="text" class="form-control" id="phone"
                                   value="@isset($data){{$data['phone']}}@else{{ old('phone') }}@endisset">
                        </div>
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="mb-3">
                            <label for="address" class="col-form-label">آدرس :</label>
                            <textarea name="address" class="form-control" id="address">@isset($data){{$data['address']}}@else{{ old('address') }}@endisset</textarea>
                        </div>
                        @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <input class="btn btn-success" type="submit"
                               value="بروز رسانی">

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
