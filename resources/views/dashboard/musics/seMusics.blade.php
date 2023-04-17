@extends('layouts.ShowOrEdit')

@section('delete-route')
    @isset($data)
        {{route('deleteMusic',['id' => $data['id']])}}
    @endisset
@endsection

@section('title')
    @isset($data)
        {{$data['title']}}
    @else
        افزودن پویش جدید
    @endisset
@endsection

@section('header')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>

        var editor_config = {

            selector: 'textarea#tiny',
            language: 'fa',
            path_absolute : "/",

            relative_urls: false,

            plugins: [

                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',

                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',

                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'

            ],

            toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify |' +

                'bullist numlist checklist outdent indent | removeformat | code table help',
            file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }

        };
        tinymce.init(editor_config);

    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script>
            var route_prefix = "/filemanager";
        </script>

        <label for="cover" class="col-form-label">تصویر موزیک :</label>

        <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-picture-o">انتخاب</i>
     </a>
   </span>
            <input id="thumbnail" class="form-control" type="text" name="cover"
                   value="@isset($data){{$data['cover']}}@else{{ old('cover') }}@endisset">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">

        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#lfm').filemanager('image');
        </script>
    </div>
    @error('cover')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="mfile" class="col-form-label">فایل موزیک :</label>
        <div class="input-group">
            <input type="text" id="image_label" class="form-control" name="mfile"
                   aria-label="Image" aria-describedby="button-image" value="@isset($data){{$data['mfile']}}@else{{ old('mfile') }}@endisset">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            // set file link
            function fmSetLink($url) {
                document.getElementById('image_label').value = $url.replace('storage/','');
            }
        </script>
        <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    </div>
    @error('mfile')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script>
            var route_prefix = "/filemanager";
        </script>

        <label for="amount" class="col-form-label">تصویر پس زمینه صفحه :</label>

        <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm2" data-input="thumbnail2" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-picture-o">انتخاب</i>
     </a>
   </span>
            <input id="thumbnail2" class="form-control" type="text" name="bg_page"
                   value="@isset($data){{$data['bg_page']}}@else{{ old('bg_page') }}@endisset">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">

        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#lfm2').filemanager('image');
        </script>
    </div>
    @error('bg_page')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="title" class="col-form-label">عنوان :</label>
        <input name="title" type="text" class="form-control" id="title"
               value="@isset($data){{$data['title']}}@else{{ old('title') }}@endisset">
    </div>
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="presell" class="col-form-label">پیش فروش آهنگ :</label>
        <input type="checkbox" name="presell" id="presell" value="1" @isset($data)@if($data['presell'] != null) checked="checked" @endif @endisset>
        <label for="presell" class="col-form-label">در این حالت آهنگ پیش فروش می شود و کاربر فایلی دانلود نخواهد کرد.</label>
    </div>
    @error('presell')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="slug" class="col-form-label">آدرس صفحه :</label>
        <input name="slug" type="text" class="form-control" id="slug"
               value="@isset($data){{$data['slug']}}@else{{ old('slug') }}@endisset">
    </div>
    @error('slug')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="amount" class="col-form-label">مبلغ :</label>
        <input name="amount" type="number" class="form-control" id="amount"
               value="@isset($data){{$data['amount']}}@else{{ old('amount') }}@endisset">
        <p>در صورت وارد نکردن مبلغ ، مبلغ دلخواه توسط کاربر در نظر گرفته می شود.</p>
    </div>
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="tiny" class="col-form-label">توضیحات :</label>
        <textarea name="description" class="form-control" id="tiny">@isset($data)
                {{$data['description']}}
            @endisset</textarea>
    </div>
    @error('description')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="tiny" class="col-form-label">توضیحات صفحه دانلود :</label>
        <textarea name="description_download" class="form-control" id="tiny">@isset($data)
                {{$data['description_download']}}
            @endisset</textarea>
    </div>
    @error('description_download')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

@endsection
