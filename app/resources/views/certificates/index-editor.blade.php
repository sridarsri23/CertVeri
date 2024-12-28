@extends('layouts.app-editor')

@section('content')
    <div class="container">
        <h2>Certificates Editor</h2>

        <div class="mb-3">
            <div class="search_bar">
    <form action="{{ route('certificates.search') }}" method="POST" class="form-inline">
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
                        <th>Accredited By</th>
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
    fetch(`${currentUrl}/search`, {
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
        fetch(`/certveri_cgpt/public/certificates/${certificateId}`)
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
    let value = this.value;
    value = value.replace(/\D/g, ''); // Remove non-digit characters
    value = value.replace(/(\d{4})(\d{1,})/, '$1/$2'); // Insert slash after four numbers

    this.value = value;
});
</script>

@endsection
