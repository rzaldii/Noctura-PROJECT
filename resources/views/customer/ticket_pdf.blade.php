<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket</title>

    <style>
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .border-box {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 0;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 20px;
        }

        .image-col {
            width: 40%;
            border-right: 2px dashed #999;
        }

        .image-col img {
            width: 100%;
            height: auto;
            display: block;
        }

        .title {
            font-size: 26px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .ticket-type {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .label {
            font-size: 11px;
            color: #777;
            text-transform: uppercase;
            font-weight: bold;
        }

        .value {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .divider {
            border-top: 2px dashed #aaa;
            margin: 20px 0;
        }

        .ticket-code {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1.5px;
        }
    </style>
</head>

<body>

<h1 style="text-align: center; font-size: 32px; font-weight: bold; margin-bottom: 30px;">E-TICKET</h1>
<div class="border-box">
    <table>
        <tr>
            {{-- LEFT IMAGE --}}
            <td class="image-col">
                <img src="{{ public_path($orderDetail->tickets->event->image_path ?? 'images/event.jpeg') }}">
            </td>

            {{-- RIGHT TEXT --}}
            <td>

                <div class="title">
                    {{ strtoupper($orderDetail->tickets->event->title) }}
                </div>

                <div class="ticket-type">
                    {{ $orderDetail->tickets->name }}
                </div>

                <div>
                    <div class="label">Lokasi Event</div>
                    <div class="value">{{ $orderDetail->tickets->event->city ?? 'Online Event' }}</div>
                </div>

                <div>
                    <div class="label">Tanggal Event</div>
                    <div class="value">
                        {{ \Carbon\Carbon::parse($orderDetail->tickets->event->start_time)->format('d M Y') }}
                    </div>
                </div>

                <div class="divider"></div>

                <div>
                    <div class="label">Kode Tiket</div>
                    <div class="ticket-code">
                        {{ $issuedTicket->ticket_code }}
                    </div>
                </div>

            </td>
        </tr>
    </table>
</div>

</body>
</html>
