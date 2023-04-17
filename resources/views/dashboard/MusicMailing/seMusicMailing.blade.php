@extends('layouts.ShowOrEdit')

@section('delete-route')

@endsection

@section('title')
    ارسال ایمیل به خریداران موزیک ({{$data->title}})
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
        <label for="subject" class="col-form-label">موضوع (عنوان) :</label>
        <input name="subject" type="text" class="form-control" id="subject"
               value="@isset($data){{$subject}}@else{{ old('subject') }}@endisset">
    </div>
    @error('subject')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label for="tiny" class="col-form-label">متن ایمیل :</label>
        <textarea name="content" class="form-control" id="tiny">@isset($data)
                {{$content}}
            @endisset</textarea>
    </div>
    @error('content')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

@endsection
