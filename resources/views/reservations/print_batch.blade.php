<!DOCTYPE html>
<html>

<head>
    <title>Print Reservations</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
            }

            body {
                font-family: "Century Gothic", sans-serif;
                margin: 0;
                padding: 20px;
                position: relative;
            }

            .eoms-rev {
                position: absolute;
                top: 20px;
                right: 20px;
                text-align: right;
                font-size: 8px;
                line-height: 1.4;
            }

            .border-box {
                border: 5px solid #000;
                margin-top: 40px;
                min-height: 80vh;
            }

            .section-padding {
                padding: 20px;
            }

            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                border-bottom: 5px solid #000;
            }

            .logo {
                flex: 0 0 auto;
                border-right: 5px solid #000;
                padding: 10px;
            }

            .heading {
                position: absolute;
                left: 55%;
                transform: translateX(-50%);
                text-align: center;
            }

            .heading h1 {
                margin: 0;
                font-size: 24px;
            }

            .heading h2 {
                margin: 10px 0 0;
                font-size: 18px;
            }

            .heading h3 {
                margin: 5px 0 0;
                font-size: 16px;
                font-weight: lighter;
            }

            .details-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 16px;
            }

            .details-table th,
            .details-table td {
                border: 1px solid #000;
                padding: 10px;
                text-align: left;
            }

            .details-table th {
                background-color: #f0f0f0;
                font-weight: bold;
            }

            .signature-row {
                width: 100%;
                margin-top: 40px;
                display: flex;
                justify-content: space-between;
                font-size: 16px;
                text-align: center;
            }

            .signature-box {
                width: 30%;
            }

            .signature-line {
                margin-top: 5px;
                border-top: 1px solid #000;
                height: 2em;
            }

            .date-printed {
                text-align: right;
                margin-top: 10px;
                font-size: 8px;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- Document Info -->
    <div class="eoms-rev">
        UdD-RM-LM-02-01<br>
        Effectivity Date: July 1, 2024<br>
        Revision No.: 0
    </div>

    <!-- Main bordered content -->
    <div class="border-box">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="https://udd.edu.ph/images/logo.png" width="80px" alt="Universidad de Dagupan">
            </div>
            <div class="heading">
                <h1>REQUEST FOR THE USE OF FACILITY</h1>
                <h2>UNIVERSIDAD DE DAGUPAN</h2>
                <h3>Arellano St., Dagupan City, Pangasinan</h3>
            </div>
        </div>

        <!-- Details Section with multiple reservations -->
        <div class="section-padding">
            <table class="details-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Room</th>
                        <th>Purpose</th>
                        <th>Datetime</th>
                        <th>Requested by</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $index => $reservation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reservation->room }}</td>
                            <td>{{ $reservation->purpose }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($reservation->start_at)->format('M j, Y g:ia') }}
                                -
                                {{ \Carbon\Carbon::parse($reservation->end_at)->format('M j, Y g:ia') }}
                            </td>
                            <td>{{ $reservation->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signatures Section (once for the whole batch) -->
        <div class="section-padding">
            <div class="signature-row">
                <div class="signature-box">
                    Requested by:<br><br>
                    <strong>{{ $reservation->user->name }}</strong>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-box">
                    Recommending Approval:<br><br><br>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-box">
                    Approved by:<br><br><br>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Printed -->
    <div class="date-printed">
        Date Printed: {{ \Carbon\Carbon::now()->format('F j, Y g:i A') }}
    </div>

</body>

</html>
