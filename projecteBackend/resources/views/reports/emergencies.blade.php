<!-- resources/views/reports/emergencies.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Emergencies Report</title>
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
        .lv1 {
            background-color: #ffe6e6;
        }
        .lv2{
            background-color: #ffcccc;
        }
        .lv3{
            background-color: #ffb3b3;
        }
        .lv4{
            background-color: #ff9999;
        }
        .lv5{
            background-color: #ff8080;
        }
    </style>
</head>
<body>
    <h1>Incoming Calls - Emergencies Report</h1>
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
                <th>Patient</th>
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
                    <td class="lv{{$call->incomingCall->emergencyLevel}}">{{ $call->incomingCall->emergencyLevel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>