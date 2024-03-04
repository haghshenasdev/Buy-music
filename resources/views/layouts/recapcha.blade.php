<div class="mb-3">
    <label for="password" class="col col-form-label text-md-end">کپچا</label>

    <div class="col">
        {!! NoCaptcha::renderJs() !!}
        {!! NoCaptcha::display() !!}
        @error('g-recaptcha-response')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>
