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
        <label for="email" class="col-form-label">آدرس ایمیل :</label>
        <input name="email" type="text" class="form-control" id="email"
               value="@isset($data){{$data['email']}}@else{{ old('email') }}@endisset">
    </div>
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror


    <div class="card p-3 mb-3">
        <div class="card-title">
            تغییر رمز عبور کاربر (در صورت نیاز به تغییر ، فیلد های زیر پر شود .)
        </div>
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
    </div>

@endsection
