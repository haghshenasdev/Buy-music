<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css" integrity="sha384-WJUUqfoMmnfkBLne5uxXj+na/c7sesSJ32gI7GfCk4zO4GthUKhSEGyvQ839BC51" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@isset($title) {{ $title }}@elseدانلود موزیک @endisset </title>

</head>
<body>

@include('master.nav')


<img src="{{ (isset($bg_page)) ? $bg_page : asset('assets/image/header.jpg') }}" class="img-fluid w-100">

<div class="container-fluid">

    @yield('content')

</div>

<footer class="footer mt-5 py-3 bg-dark">
    <div class="container">

        <div class="row g-0">
            <div class="col-lg col-12">
                <h4>پشتیبانی سایت</h4>
                <p>جهت ارتباط با پشتیبانی سایت می توانید به آدرس ایمیل زیر پیام دهید.</p>
                <p>info@haghlabel.com</p>

                <p>                ©2023 haghlabel کلیه ی حقوق نشر این مجموعه متعلق به آرتیست و تیم تولید می باشد و نشر ترک برای عموم رسانه ها ممنوع است.
                </p>
            </div>
            <div class="col-lg-auto col-12">
                <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=331744&amp;Code=qKCvEySH9r19hXFB7Jfw"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=331744&amp;Code=qKCvEySH9r19hXFB7Jfw" alt="" style="cursor:pointer" id="qKCvEySH9r19hXFB7Jfw">
                </a>
            </div>
        </div>

    </div>


</footer>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
-->
</body>
</html>
