@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">کاربران</div>

                    <div class="card-body">
                        <a href="{{route('newUser')}}" class="btn btn-outline-success">
                            افزودن کاربر جدید
                        </a>

                        @livewire('tables.users-table-view')
                    </div>
                </div>

            </div>
        </div>
@endsection
