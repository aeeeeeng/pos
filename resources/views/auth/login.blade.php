@extends('layouts.auth')

@push('css')
@endpush

@section('login')
<div class="auth-content my-auto">
    <div class="text-center">
        <h5 class="mb-0">Halaman Login</h5>
        <p class="text-muted mt-2">Masukkan email dan password untuk masuk ke POS</p>
    </div>
    <form class="mt-4 pt-2" action="{{ route('login') }}" method="post">
        @csrf
        <div class="mb-3 @error('email') has-danger @enderror">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
            @error('email')
                <div class="pristine-error text-help">{{$message}}</div>
            @else
                <span class="help-block with-errors"></span>
            @enderror
        </div>
        <div class="mb-3 @error('password') has-danger @enderror">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <label class="form-label">Password</label>
                </div>
            </div>
            
            <div class="input-group auth-pass-inputgroup">
                <input type="password" name="password" required class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
            </div>
            @error('password')
                <div class="pristine-error text-help">{{$message}}</div>
            @else
                <span class="help-block with-errors"></span>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
        </div>
    </form>
</div>
@endsection

