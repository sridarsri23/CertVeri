<!-- resources/views/certificates/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Certificate</h2>
        <form method="POST" action="{{ route('certificates.update', $certificate->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="certificate_no">Certificate Number</label>
                <input id="certificate_no" type="text" name="certificate_no" required pattern="\d{4}/\d{8}" value="{{ $certificate->certificate_no }}" required title="Certificate number must be in the format '0000/00000000'">
                @error('certificate_no')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input id="student_name" type="text" name="student_name" value="{{ $certificate->student_name }}" required>
                @error('student_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="issue_date">Issue Date</label>
                <input id="issue_date" type="date" name="issue_date" value="{{ $certificate->issue_date }}" required>
                @error('issue_date')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="expire_date">Expiry Date</label>
                <input id="expire_date" type="date" name="expire_date" value="{{ $certificate->expire_date }}" required>
                @error('expire_date')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input id="qualification" type="text" name="qualification" value="{{ $certificate->qualification }}" required>
                @error('qualification')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="accredited_by">Company</label>
                <input id="accredited_by" type="text" name="accredited_by" value="{{ $certificate->accredited_by }}" required>
                @error('accredited_by')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-form-group">
            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this certificate?')">Update</button>
            <a href="{{ route('certificates-index') }}" class="btn btn-secondary">Back to Index</a>
    
        </div>
        </form>
    </div>
    <script>

const certificateNoInput = document.getElementById('certificate_no');

certificateNoInput.addEventListener('input', function () {
            const startPosition = this.selectionStart; // Store the current cursor position
            const endPosition = this.selectionEnd;

            let value = this.value;
            value = value.replace(/\D/g, ''); // Remove non-digit characters
            value = value.replace(/(\d{4})(\d{1,8}).*/, '$1/$2'); // Insert slash after four numbers and limit to eight numbers after slash

            this.value = value;

            // Restore the cursor position
            this.setSelectionRange(startPosition, endPosition);
        });

    </script>
@endsection
