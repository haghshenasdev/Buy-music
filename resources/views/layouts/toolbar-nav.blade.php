<div class="row justify-content-center my-3 mx-0">
    <div class="col-md-7">
        <div class="card p-0 forg-color">
            <div class="card-body">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('dashboard')}}">داشبورد</a>
                    </li>

                    @can('admin')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('settingShow')}}">تنظیمات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('comments')}}">نظرات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('users')}}">کاربران</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('buys')}}">خرید ها</a>
                        </li>
                    @endcan

                </ul>
            </div>
        </div>
    </div>
</div>
