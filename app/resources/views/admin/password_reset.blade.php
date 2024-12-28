@extends('layouts.app')

@section('content')
    <div class="container password_reset_container">
        <h2>Admin Password Reset</h2>

        <form id="adminPasswordResetForm" method="POST" action="{{ route('change-password') }}">
            @csrf

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input id="current_password" type="password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input id="new_password" type="password" name="new_password" required>

            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" required>
            </div>


            <div>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @elseif (session('success'))
                <!-- Display confirmation message -->
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            </div>

            <div class="button-form-group">
            <button type="submit" class="btn btn-primary" onclick="confirmPasswordReset(event)">Reset Password</button>
            <a href="{{ route('certificates-index') }}" class="btn btn-secondary show_button">Back</a>

            </div>
       
        </form>

        <script>
            function confirmPasswordReset(event) {
                event.preventDefault();

                if (confirm('Are you sure you want to reset the admin password?')) {
                    document.getElementById('adminPasswordResetForm').submit();
                }
            }
        </script>
    </div>
@endsection
