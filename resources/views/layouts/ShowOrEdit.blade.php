@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')
    <div class="row justify-content-center mt-4 mx-0">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row row-cols-auto justify-content-between">
                        <div class="col">
                            <div class="row">
                                <div class="col-auto">

                                    @yield('title')

                                </div>
                                @isset($data)
                                    <div class="col">
                                        <form method="post" action="@yield('delete-route')">
                                            @method('delete')
                                            @csrf
                                            <input class="btn btn-outline-danger btn-sm" type="submit" value="حذف">
                                        </form>
                                    </div>
                                @endisset
                            </div>
                        </div>

                        @include('layouts.back-btn')
                    </div>

                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="post">
                        @csrf

                        @yield('form-content')

                        <input class="btn btn-success" type="submit"
                               value="@isset($data) بروز رسانی@else افزودن @endisset">

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
