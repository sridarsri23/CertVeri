<!-- resources/views/certificates/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Certificate</h2>

        <form action="{{ route('certificates-store') }}" method="POST">
            @csrf

            <div class="form-group">
                 <label for="certificate_no">Certificate Number</label>
                 <input type="text" name="certificate_no" id="certificate_no" class="form-control" value="{{ old('certificate_no') }}" required pattern="\d{4}/\d{8}" title="Certificate number must be in the format '0000/00000000'">
                 @error('certificate_no')
                    <div class="error">{{ $message }}</div>
                @enderror
                </div>


            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" name="student_name" id="student_name" class="form-control" value="{{ old('student_name') }}" required>
            
                @error('student_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="issue_date">Issue Date</label>
                <input type="date" name="issue_date" id="issue_date" class="form-control" value="{{ old('issue_date') }}" required>
                @error('issue_date')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="expire_date">Expiry Date</label>
                <input type="date" name="expire_date" id="expire_date" class="form-control" value="{{ old('expire_date') }}" required>
                @error('expire_date')
                    <span class="error">{{ $message }}</span>
                @enderror
            
            </div>

            <div class="form-group">  
                <label for="qualification">Qualification</label>
                <input type="text" name="qualification" id="qualification" class="form-control" value="{{ old('qualification') }}" required>
                @error('qualification')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="accredited_by">Company</label>
                <input type="text" name="accredited_by" id="accredited_by" class="form-control" value="{{ old('accredited_by') }}" required>
                @error('accredited_by')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>


            <div class="button-form-group">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('certificates-index') }}" class="btn btn-secondary mb-3">Back</a>
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

    // Calculate the new cursor position after the slash is inserted
    let newPosition = startPosition;
    if (startPosition >= 4 && startPosition <= 5) {
        // If the cursor was at the end of the first four digits, move it after the slash
        newPosition = startPosition + 1;
    } else if (startPosition > 5) {
        // If the cursor was in the second part, move it after the first four digits and the slash
        newPosition = startPosition + 2;
    }

    // Restore the cursor position
    this.setSelectionRange(newPosition, newPosition);
});
    </script>
@endsection
