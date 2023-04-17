@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">پویش ها</div>

                <div class="card-body">
                    <a href="{{route('newPooyeshes')}}" class="btn btn-outline-success">
                        افزودن پویش جدید
                    </a>

                    @livewire('tables.pooyeshes-table-view')

                </div>
            </div>

        </div>
    </div>
@endsection
