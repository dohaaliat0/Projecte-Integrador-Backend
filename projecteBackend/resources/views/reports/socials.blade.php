<!-- resources/views/reports/socials.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Social Calls Report</title>
    <style>
        /* Add your styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        
    </style>
</head>
<body>
    <h1>Incoming Calls - Social Calls Report</h1>
    <h2>Generated on: {{ \Carbon\Carbon::now()->toFormattedDateString() }}</h2>
    <h3>Total Calls: {{ $calls->count() }}</h3>
    <h3>{{$startDate}} - {{$endDate}}</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Details</th>
                <th>DateTime</th>
                <th>Operator</th>
                <th>Caller</th>
                <th>Type</th>
                <th>Emergency Level</th>
            </tr>
        </thead>
        <tbody>

            @foreach($calls as $call)

                <tr>
                    <td>{{ $call->id }}</td>
                    <td>{{ $call->details }}</td>
                    <td>{{ $call->dateTime }}</td>
                    @if ($call->operator)
                        <td>{{ $call->operator->name }} ({{$call->operator->id}})</td>
                    
                    @endif

                    @if ($call->patient)
                        <td>{{ $call->patient->fullName }} ({{$call->patient->id}})</td>
                    
                    @endif

                    <td>{{ $call->incomingCall->type }}</td>
                    <td>{{ $call->incomingCall->emergencyLevel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>