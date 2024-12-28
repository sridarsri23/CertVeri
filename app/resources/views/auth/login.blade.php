<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container login_container">
        <h2>Back Office Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required autofocus class"float_right">
  
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required class"float_right">
          
            </div>
            <div> 
            @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
                @error('password')

                <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="button-form-group">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{ url('/') }}"><button type="button" class="btn btn-primary">Cancel</button> </a>

            </div>
        </form>
    </div>

@endsection
