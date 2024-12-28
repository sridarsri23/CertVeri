<!-- resources/views/certificates/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Certificate Details</h2>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <table class="table">
            <tr>
                <th>Certificate Number</th>
                <td>{{ $certificate->certificate_no }}</td>
            </tr>
            <tr>
                <th>Student Name</th>
                <td>{{ $certificate->student_name }}</td>
            </tr>
            <tr>
                <th>Issue Date</th>
                <td>{{ $certificate->issue_date }}</td>
            </tr>
            <tr>
                <th>Expire Date</th>
                <td>{{ $certificate->expire_date }}</td>
            </tr>
            <tr>
                <th>Qualification</th>
                <td>{{ $certificate->qualification }}</td>
            </tr>
            <tr>
                <th>Company</th>
                <td>{{ $certificate->accredited_by }}</td>
            </tr>
        </table>

        <div class="btn-group">
        @if (auth()->user()->isAdmin())
            <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this certificate?')">Delete</button>
            </form>
            @endif
            <a href="{{ route('certificates-index') }}" class="btn btn-secondary show_button">Back to Index</a>
        </div>
    </div>

    <div>
    <h2>QR Code</h2>
    <img src="{{ asset($qrCodeUrl)  }}" alt="QR Code" width=500 height=500></div>



@endsection
