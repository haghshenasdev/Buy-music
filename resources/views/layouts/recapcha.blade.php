<div class="row mb-3">
    <label for="password" class="col-md-4 col-form-label text-md-end">کپچا</label>

    <div class="col-md-6">
        {!! NoCaptcha::renderJs() !!}
        {!! NoCaptcha::display() !!}
        @error('g-recaptcha-response')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>
