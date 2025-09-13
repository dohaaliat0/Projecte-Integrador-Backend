<!DOCTYPE html>
<html>
<head>
    <title>Patient Call History</title>
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
        <h2>Call History for {{ $patient->fullName }}</h2>

        @if($calls->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Call ID</th>
                        <th>Operator</th>
                        <th>Details</th>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Emergency Level / Alert ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calls as $call)
                        <tr>
                            <td>{{ $call->id }}</td>
                            <td>{{ $call->operator->name }}</td>
                            <td>{{ $call->details }}</td>
                            <td>{{ $call->dateTime }}</td>
                            <td>
                                @if($call->incomingCall)
                                    Incoming
                                @elseif($call->outgoingCall)
                                    Outgoing
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if($call->incomingCall)
                                    {{ $call->incomingCall->emergencyLevel }}
                                @elseif($call->outgoingCall)
                                    {{ $call->outgoingCall->alertId }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No call history available.</p>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4>Patient Information</h4>
            </div>
            <div class="card-body">
                <p><strong>Full Name:</strong> {{ $patient->fullName }}</p>
                <p><strong>Birth Date:</strong> {{ $patient->birthDate }}</p>
                <p><strong>Address:</strong> {{ $patient->fullAddress }}</p>
                <p><strong>DNI:</strong> {{ $patient->dni }}</p>
                <p><strong>Health Card Number:</strong> {{ $patient->healthCardNumber }}</p>
                <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Zone:</strong> {{ $patient->zone->name }}</p>
                <p><strong>Personal Family Situation:</strong> {{ $patient->personalFamilySituation }}</p>
                <p><strong>Health Situation:</strong> {{ $patient->healthSituation }}</p>
                <p><strong>Housing Situation:</strong> {{ $patient->housingSituation }}</p>
                <p><strong>Personal Autonomy:</strong> {{ $patient->personalAutonomy }}</p>
                <p><strong>Economic Situation:</strong> {{ $patient->economicSituation }}</p>
                <p><strong>Operator:</strong> {{ $patient->operator->name }}</p>
                <p><strong>Status:</strong> {{ $patient->status }}</p>
            </div>
        </div>
    </div>
</body>
</html>