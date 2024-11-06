<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    {{--        <link rel="stylesheet" href="{{ asset('public/css/tailwind-pdf.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('public/css/w3.css') }}">--}}
    <style>
        {{--        {!! file_get_contents(public_path('css/tailwind-pdf.css')) !!}--}}
        {{--        {!! file_get_contents(public_path('css/bootstrap.min.css')) !!}--}}
        {{--        {!! file_get_contents(public_path('css/w3.css')) !!}--}}
        .main-table, .main-th, .main-td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .th-2 {
            border-bottom: 1px solid black;
            border-collapse: collapse;
            margin-left: -3px;
        }
    </style>
</head>
<body class="dark">
<div class="w3-container">
    <h2>Border Around Table</h2>
    <p>The w3-border class adds a border around the table.</p>

    <table class="main-table" style="width: 100%">
        <thead>
        <tr class="">
            <th class="main-th">Month</th>
            <th class="">
                <table class="" style="width: 100%" >
                    <thead class="">
                    <tr class="" >
                        <th colspan="4" class="" style="border-bottom: 1px solid black">
                            Number of Transactions
                        </th>
                    </tr>
                    </thead>
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Avail Basic Services
                                    </th>
                                </tr>
                                </thead>
                                <tr class="">
                                    <td class="">
                                        Internal
                                    </td>
                                    <td>
                                        External
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Inquiry / Follow up Transactions
                                    </th>
                                </tr>
                                </thead>
                                <tr class="">
                                    <td class="">
                                        Internal
                                    </td>
                                    <td>
                                        External
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Pick up or Drop Off Documents
                                    </th>
                                </tr>
                                </thead>
                                <tr class="">
                                    <td class="">
                                        Internal
                                    </td>
                                    <td>
                                        External
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Meeting or Appointment
                                    </th>
                                </tr>
                                </thead>
                                <tr class="">
                                    <td class="">
                                        Internal
                                    </td>
                                    <td>
                                        External
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        </thead>
        <tr style="border-top: 1px black solid">
            <td class="main-td">November</td>
            <td class="main-td">November</td>
        </tr>
    </table>
</div>
</body>
</html>
