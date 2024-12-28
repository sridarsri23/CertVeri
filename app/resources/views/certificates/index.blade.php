@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="text-right">
        @if (auth()->user()->isAdmin())
                
            <a href="{{ route('admin.password.reset') }}" class="btn btn-link">Reset Admin Password</a>
            <a href="{{ route('admin.editor.password.reset') }}" class="btn btn-link">Reset Editor Password</a>
            <a href="{{url('export-excel-csv-file/xlsx')}}" class="btn btn-link">Export</a>
            <a href="{{url('/logs')}}" class="btn btn-link"  target="_blank" >View Logs</a>
            @endif
       
        </div>
        <h2>Certificates</h2>

        <div class="mb-3">
            <div class="search_bar">
    <form action="{{ route('certificates-searchb') }}" method="POST" class="form-inline">
    @csrf
        <label for="query">Certificate #</label>
    <input type="text" name="query" id="search-input" class="form-control mr-sm-2" required pattern="\d{4}/\d{8}" title="Certificate number must be in the format '0000/00000000'" autocomplete="off" placeholder="Search Certificate No">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
            </div>
            <div class="add_cert">

                <a href="{{ route('certificates-create') }}" class="btn btn-success">Add Certificate</a>

            </div>
    </div>
<style> 

.search-results {
    position: absolute;
    z-index: 100;
    background-color: gray;
    border: 1px solid #cccccc;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    width: 200px;
    margin-left: 80px;
    color:white;
}

.search-results a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: white;
}

.search-results a:hover {
    background-color: skyblue;
}



</style>
<div id="search-results" class="search-results"></div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


        @if ($certificates->isEmpty())
            <div class="alert alert-info">
                No certificates found.
            </div>
        @else
            <table class="table" id="certificates-table">
                <thead>
                    <tr>
                        <th>Certificate Number</th>
                        <th>Student Name</th>
                        <th>Issue Date</th>
                        <th>Expire Date</th>
                        <th>Qualification</th>
                        <th>Company</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->certificate_no }}</td>
                            <td>{{ $certificate->student_name }}</td>
                            <td>{{ $certificate->issue_date }}</td>
                            <td>{{ $certificate->expire_date }}</td>
                            <td>{{ $certificate->qualification }}</td>
                            <td>{{ $certificate->accredited_by }}</td>
                            <td>
                                <div class="actions">
                                    <div> 
                                <a href="{{ route('certificates.show', $certificate->id) }}" class="btn btn-primary">View</a>
                                    </div>

                                @if (Auth::user()->isAdmin())
                                    <div>
                                    <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-secondary">Edit</a>
                                    </div>
                                    <div>
                                    <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this certificate?')">Delete</button>
                                    </form>
                                    </div>
                                @endif
                                
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
    const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
let timerId = null;
const currentUrl = window.location.href;
searchInput.addEventListener('input', function() {
    clearTimeout(timerId);

    const query = this.value.trim();

    if (query.length > 0) {
        timerId = setTimeout(() => {
            searchCertificates(query);
        }, 500);
    } else {
        searchResults.innerHTML = '';
    }
});

function searchCertificates(query) {
    fetch(`${currentUrl}/../certificates-search`, {
        
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ query: query })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            let html = '';

            data.forEach(certificate => {
                html += `<a href="${currentUrl}/${certificate.id}" class="dropdown-item">${certificate.certificate_no}</a>`;
            });

            searchResults.innerHTML = html;
        })
        .catch(error => console.error(error));
}

// Add click event listener to search results
searchResults.addEventListener('click', function(event) {
    const target = event.target;
    if (target.tagName === 'A') {
        event.preventDefault();
        const certificateId = target.getAttribute('href').split('/').pop();
        fetch(`/certificates/${certificateId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not OK');
                }
                return response.text();
            })
            .then(data => {
                const certificatesTable = document.getElementById('certificates-table');
    const responseHtml = new DOMParser().parseFromString(data, 'text/html');

    // Exclude specific elements from the response HTML
    const excludedElements = responseHtml.querySelectorAll('nav'); // Select the elements you want to exclude
    excludedElements.forEach(element => {
        element.remove(); // Remove the element from the response HTML
    });

    certificatesTable.innerHTML = responseHtml.body.innerHTML;

    // Hide the search results
    searchResults.innerHTML = '';
    document.getElementById('search-input').value = '';
            })
            .catch(error => console.error(error));
    }
});





const certificateNoInput = document.getElementById('search-input');

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
