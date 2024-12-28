<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="welcome_container container">
        <h1>Welcome!</h1>
        <h2>Certificate Verification Control Panel</h2>
        <h3>Select Login</h3>
        <div class="login_button_div">
        <div class="admin_login">

                <a href="{{ route('login') }}" class="btn btn-success">Back Office</a>

            </div>

            <div class="editor_login">

                <a href="{{ route('editor-login') }}" class="btn btn-success">Front Office</a>

            </div>
        </div>

    </div>

@endsection
