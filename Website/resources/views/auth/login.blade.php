@extends('layouts.guest')

@section('title', 'Login - ' . config('app.name'))

@push('styles')
<style>
    .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .login-card { background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); width: 100%; max-width: 24rem; }
    .login-title { font-size: 1.5rem; font-weight: 600; color: #1a202c; margin-bottom: 1.5rem; text-align: center; }
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #4a5568; margin-bottom: 0.5rem; }
    .form-input { width: 100%; padding: 0.625rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; font-size: 0.875rem; }
    .btn-login { width: 100%; background: #4299e1; color: white; padding: 0.625rem; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; }
    .error-message { color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem; }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <h1 class="login-title">Sign in</h1>
            
            @if ($errors->any())
                <div class="error-message mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-input" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" 
                           class="form-input" required>
                </div>
                
                <div class="form-group">
                    <input type="checkbox" name="remember" id="remember" 
                           class="mr-2" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember me</label>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn-login">Sign in</button>
                </div>
            </form>
    </div>
</div>
@endsection
