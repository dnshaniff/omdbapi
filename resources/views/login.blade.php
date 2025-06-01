@extends('layouts.front')

@section('title', 'Login')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
