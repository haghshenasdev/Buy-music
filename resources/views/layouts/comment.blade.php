<form method="post" action="{{ route('comment') }}">
    @csrf
    @method('post')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-3">
        <label for="textComment" class="col-form-label">نظر شما :</label>
        <textarea name="textComment" type="text" class="form-control" id="textComment">{{ old('textComment') }}</textarea>
    </div>
    @error('textComment')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror


    <input name="musicId" type="hidden" class="form-control" id="musicId"
               value="{{$data['id']}}">
    @error('musicId')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input class="btn btn-primary" type="submit"
           value="ارسال نظر">
</form>
