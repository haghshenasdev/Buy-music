@extends('layouts.ShowOrEdit')

@section('delete-route')

@endsection

@section('title')
        تنظیمات
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

        <label for="amount" class="col-form-label">تصویر پس زمینه صفحه :</label>

        <div class="input-group">
   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
       <i class="fa fa-picture-o">انتخاب</i>
     </a>
   </span>
            <input id="thumbnail" class="form-control" type="text" name="bg_page"
                   value="@isset($data){{$data['bg_page']}}@else{{ old('bg_page') }}@endisset">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">

        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#lfm').filemanager('image');
        </script>
    </div>
    @error('bg_page')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="home_title" class="col-form-label">عنوان صفحه اصلی:</label>
        <input name="home_title" type="text" class="form-control" id="home_title"
               value="@isset($data){{$data['home_title']}}@else{{ old('home_title') }}@endisset">
    </div>
    @error('home_title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="mid" class="col-form-label">کلید درگاه پرداخت :</label>
        <input name="mid" type="text" class="form-control" id="mid"
               value="@isset($data){{$data['mid']}}@else{{ old('mid') }}@endisset">
    </div>
    @error('mid')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="min_amount" class="col-form-label">حداقل مبلغ دلخواه :</label>
        <input name="min_amount" type="number" class="form-control" id="min_amount"
               value="@isset($data){{$data['min_amount']}}@else{{ old('min_amount') }}@endisset">
        <p>این مورد تایین می کند حداقل مبلغ اعتبار سنجی مبلغ دلخواه برای خرید چقدر باشد (در صورت تعریف نشدن حداقل در موزیک).</p>
    </div>
    @error('min_amount')
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
