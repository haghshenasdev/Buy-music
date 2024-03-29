@extends('master.theme')

@section('header')
    @laravelViewsStyles
@endsection

    @section('content')

            <script !src="">
                // جهت بازگشت به صفحه قبل از لاگین
                function getCookie(cname) {
                    let name = cname + "=";
                    let decodedCookie = decodeURIComponent(document.cookie);
                    let ca = decodedCookie.split(';');
                    for(let i = 0; i <ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }
                $bk_url = getCookie('bk_url');
                document.cookie = 'bk_url=;';
                if ($bk_url != null && $bk_url !== ''){
                    document.location = $bk_url;
                }
            </script>

        @can('admin')
            <div style="margin-top: -70px">
                @include('layouts.toolbar-nav')
                <div class="row justify-content-center mt-4">
                    <div class="col-md-8">
                        <div class="card forg-color">
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
            </div>
        @else
            <div class="row justify-content-center" style="margin-top: -70px">
                <div class="col-md-8">
                    <div class="card forg-color">
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
    @laravelViewsScripts
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>--}}

@endsection
