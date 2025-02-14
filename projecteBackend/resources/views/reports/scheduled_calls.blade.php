<!DOCTYPE html>
<html>
<head>
    <title>Scheduled Calls Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            max-width: 90px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        a {
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Scheduled Calls from {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</h2>


        @if($alertsWithoutCalls->isNotEmpty())
            <h3>Alerts with pending Calls</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alert ID</th>
                        <th>Patient</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alertsWithoutCalls as $alert)
                        <tr>
                            <td>{{ $alert->id }}</td>
                            <td>{{ $alert->patient->fullName ?? 'N/A' }}</td>
                            <td>{{ $alert->title ?? 'N/A' }}</td>
                            <td>{{ $alert->description ?? 'N/A' }}</td>
                            <td>{{ $alert->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No alerts without scheduled calls available for this date range.</p>
        @endif

        @if($alertsWithCalls->isNotEmpty())
        <h3>Alerts with Scheduled Calls</h3>
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Alert ID</th>
            <th>Patient</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Call ID</th>
            <th>Operator</th>
            <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alertsWithCalls as $alert)
            <tr>
                <td>{{ $alert->id }}</td>
                <td>{{ $alert->patient->fullName ?? 'N/A' }}</td>
                <td>{{ $alert->title ?? 'N/A' }}</td>
                <td>{{ $alert->description ?? 'N/A' }}</td>
                <td>{{ $alert->date }}</td>
                <td>{{ $alert->outgoingCall->callId ?? 'N/A' }}</td>
                <td>{{ $alert->outgoingCall->call->operator->name ?? 'N/A' }}</td>
                <td>{{ $alert->outgoingCall->call->details ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        @else
            <p>No alerts with scheduled calls available for this date range.</p>
        @endif
    </div>
</body>
</html>