<div class="row mb-3 justify-content-center">
    <div class="col-auto">
        {!! NoCaptcha::renderJs() !!}
        {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
    </div>
    @error('g-recaptcha-response')
    <div class="alert alert-danger mt-3">{{ $message }}</div>
    @enderror
</div>
