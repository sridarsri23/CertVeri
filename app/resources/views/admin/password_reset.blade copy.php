@extends('layouts.app')

@section('content')
    <div class="container">
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
                @error('new_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>

    <script>
    document.querySelector('#adminPasswordResetForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var currentPassword = document.getElementById('current_password').value;
        var newPassword = document.getElementById('new_password').value;
        var newPasswordConfirmation = document.getElementById('new_password_confirmation').value;
        const currentUrl = window.location.href;

        // Send an AJAX request to the server to handle the password reset logic
       //fetch("{{ route('change-password') }}", {
        fetch(`{{ env("APP_URL") }}/change-password`, {
          //fetch(`http://localhost/certveri_cgpt/public/change-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: newPasswordConfirmation
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            // Handle the response from the server
            if (data.success) {
                // Password reset successful
                alert('Password reset successful.');
                window.location.href = "{{ route('certificates-index') }}";
            } else {
                // Password reset failed, display error message
                alert('Password reset failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
    });

</script>


<h2>Editor Password Reset</h2>

    <form id="editorPasswordResetForm" method="POST" action="{{ route('admin.editor.reset-password') }}">
        @csrf

        <div class="form-group">
            <label for="editor_id">Editor</label>
            <select id="editor_id" name="editor_id">
                <!-- Populate the dropdown options with editors from the database -->
                @foreach ($editors as $editor)
                    <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="new_editor_password">New Password</label>
            <input id="new_editor_password" type="password" name="new_editor_password" required>
            @error('new_editor_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        
        </div>

        <div class="form-group">
            <label for="new_editor_password_confirmation">Confirm New Password</label>
            <input id="new_editor_password_confirmation" type="password" name="new_editor_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Reset Editor Password</button>
    </form>

    <!-- JavaScript code for handling the editor password reset form -->
    <script>
        document.querySelector('#editorPasswordResetForm').addEventListener('submit', function (event) {
            event.preventDefault();

            var editorId = document.getElementById('editor_id').value;
            var newPassword = document.getElementById('new_editor_password').value;
            var newPasswordConfirmation = document.getElementById('new_editor_password_confirmation').value;
            const currentUrl = window.location.href;

         

            // Send an AJAX request to the server to handle the password reset logic
          //  fetch(`${currentUrl}`, {
            fetch(`{{ env("APP_URL") }}/admin/editor/reset-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    editor_id: editorId,
                    new_password: newPassword,
                    new_password_confirmation: newPasswordConfirmation
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not OK');
                }
                return response.json();
            })
            .then(data => {
                // Handle the response from the server
                if (data.success) {
                    // Password reset successful
                    alert('Editor password reset successful.');
                    // Reload the page or perform any other action
                } else {
                    // Password reset failed, display error message
                    alert('Editor password reset failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('An error occurred:', error);
            });
        });
    </script>

@endsection
