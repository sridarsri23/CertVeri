@extends('layouts.app')

@section('content')
    <div class="container">
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

            </div>

            <div class="form-group">
                <label for="new_editor_password_confirmation">Confirm New Password</label>
                <input id="new_editor_password_confirmation" type="password" name="new_editor_password_confirmation" required>
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
            <button type="submit" class="btn btn-primary" onclick="confirmPasswordReset(event)">Reset Editor Password</button>
            <a href="{{ route('certificates-index') }}" class="btn btn-secondary show_button">Back</a>

            </div>
        </form>

        <script>
            function confirmPasswordReset(event) {
                event.preventDefault();

                if (confirm('Are you sure you want to reset the editor password?')) {
                    document.getElementById('editorPasswordResetForm').submit();
                }
            }
        </script>
    </div>
@endsection
