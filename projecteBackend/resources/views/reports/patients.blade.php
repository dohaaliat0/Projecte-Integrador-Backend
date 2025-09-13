<!DOCTYPE html>
<html>
<head>
    <title>Patients Report</title>
    <style>
        /* Add your styles here */
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

        a{
            /* text-decoration: none; */
            color: #000000;
        }
    </style>
    </style>
</head>
<body>
    <h1>Patients Report</h1>
    <h2>Generated on: {{ \Carbon\Carbon::now()->toFormattedDateString() }}</h2>
    <table>
        <thead>
            <tr>
            <th>Full Name</th>
            <th>Birth Date</th>
            <th>Full Address</th>
            <th>Contact Info</th>
            <th>DNI & Health Card Number</th>
            <th>Zone ID</th>
            <th>Personal Family Situation</th>
            <th>Health Situation</th>
            <th>Language</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
            <td>{{ $patient->fullName }}</td>
            <td>{{ $patient->birthDate }}</td>
            <td>{{ $patient->fullAddress }}</td>
            <td>
                <a href="mailto:{{ $patient->email }}">Email</a>             <br><br> 
                <a href="tel:{{ $patient->phone }}">Call</a>
            </td>

            <td>{{ $patient->dni }}, {{ $patient->healthCardNumber }}</td>
            <td>{{ $patient->zoneId }}</td>
            <td>{{ $patient->personalFamilySituation }}</td>
            <td>{{ $patient->healthSituation }}</td>
            <td>
                @foreach($patient->languages as $language)
                    {{ $language->name }}@if(!$loop->last), @endif
                @endforeach
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>