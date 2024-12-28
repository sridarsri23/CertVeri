<!DOCTYPE html>
<html>
<head>
    <title>Log Viewer</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">
</head>
<body>
    <h1>Activity Log Viewer</h1>
    <div class="container">
        <table id="logs-table" class="table">
            <thead>
                <tr>
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


            $('#logs-table').dataTable( {
                "searching": true,
                responsive: true,
                "order": [[0, "desc"]],
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]] // Set the available options for entries per page
                } );
        });


    </script>
</body>
</html>
