<!DOCTYPE html>
<html>
<head>
    <title>Done Calls Report</title>
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
        <h1>Done Calls Report</h1>
        <p>From: {{ $startDate }} To: {{ $endDate }}</p>
    <h2>Incoming Calls</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date Time</th>
            <th>Caller</th>
            <th>Receiver</th>
            <th>Type</th>
            <th>Emergency Level</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($incomingCalls as $call)
            <tr>
            <td>{{ $call->id }}</td>
            <td>{{ $call->dateTime }}</td>
            <td>{{ $call->operator->name }}</td>
            <td>{{ $call->patient->fullName }}</td>
            <td>{{ $call->incomingCall->type ?? 'N/A' }}</td>
            <td>{{ $call->incomingCall->emergencyLevel ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
        </table>

        <h2>Outgoing Calls</h2>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date Time</th>
            <th>Caller</th>
            <th>Receiver</th>
            <th>Type</th>
            <th>Alert ID</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($outgoingCalls as $call)
            <tr>
            <td>{{ $call->id }}</td>
            <td>{{ $call->dateTime }}</td>
            <td>{{ $call->operator->name }}</td>
            <td>{{ $call->patient->fullName }}</td>
            <td>{{ $call->outgoingCall->type ?? 'N/A' }}</td>
            <td>{{ $call->outgoingCall->alertId ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>