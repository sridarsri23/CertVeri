<!DOCTYPE html>
<html>
<head>
    <title>Log Viewer</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">
</head>
<body>
    <h1>Log Viewer</h1>
    <div class="container">
    <table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr>
                <td>{{ $log }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#logs-table').DataTable();
        });
    </script>
</body>
</html>
