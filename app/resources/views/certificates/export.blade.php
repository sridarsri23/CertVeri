<!-- resources/views/certificates/export.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Export Certificates</h2>
        
        <form action="{{ route('certificates.export') }}" method="GET">
            <button type="submit" class="btn btn-primary">Export to Excel</button>
        </form>
    </div>
@endsection
