@extends('layouts.ShowOrEdit')

@section('delete-route')
    @isset($data)
        {{route('deleteUser',['id' => $data['id']])}}
    @endisset
@endsection

@section('title')
    @isset($data)
        {{$data['name']}}
    @else
        افزودن کاربر جدید
    @endisset
@endsection

@section('form-content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="name" class="col-form-label">نام و نام خانوادگی :</label>
        <input name="name" type="text" class="form-control" id="name"
               value="@isset($data){{$data['name']}}@else{{ old('name') }}@endisset">
    </div>
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="access_level" class="col-form-label">نقش کاربر :</label>
        <select class="form-select" name="access_level" id="access_level">
            @can('super-admin')
                <option value="0" @if(isset($data) and $data['access_level'] == 0) selected @endif>مدیر کل</option>
                <option value="1" @if(isset($data) and $data['access_level'] == 1) selected @endif>مدیر خیریه</option>
            @endcan
            @can('charity-admin')
                <option value="1" @if(isset($data) and $data['access_level'] == 1) selected @endif>مدیر خیریه</option>
            @endcan
            <option value="2" @if(isset($data) and $data['access_level'] == 2) selected @endif>کارمند خیریه</option>
            <option value="3" @if(!isset($data) or is_null($data['access_level'])) selected @endif>کاربر</option>
        </select>
    </div>
    @error('access_level')
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

    @can('see-all-users')
        <div class="mb-3">
            <label for="charity" class="col-form-label">خیریه:</label>

            <div class="row">
                <div class="col">
                    <input name="charity" type="number" class="form-control" id="charity"
                           value="@isset($data){{$data['charity']}}@else{{ old('charity')}}@endisset">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary">دریافت نام و برسی</button>
                </div>
            </div>
            <label for="charity" class="col-form-label">نام</label>
        </div>
        @error('charity')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    @endcan

    <div class="mb-3">
        <label for="password" class="col-form-label">رمز عبور :</label>
        <input name="password" type="password" class="form-control" id="password">
    </div>
    @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="password_confirmation" class="col-form-label">تکرار رمز عبور :</label>
        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation">
    </div>

@endsection
