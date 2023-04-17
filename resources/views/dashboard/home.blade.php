@extends('layouts.app')

@section('content')
    @include('layouts.toolbar-nav')

    <div class="container">

        @can('admin')
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">آهنگ ها</div>
                        <div class="card-body">
                            <a href="{{route('newMusic')}}" class="btn btn-outline-success">
                                افزودن موزیک جدید
                            </a>
                            <div>
                                @livewire('musics-table-view')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">موزیک های خریداری شده</div>

                        <div class="card-body">
                            <div>
                                @livewire('sales-table-view')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endcan
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

@endsection
