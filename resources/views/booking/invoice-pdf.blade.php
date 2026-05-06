<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $booking->booking_code }}</title>
    <style>
        @page { margin: 20mm 15mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #ffffff;
        }
        .header {
            background: #1a1208;
            color: #c9a96e;
            padding: 24px 28px;
            border-radius: 12px 12px 0 0;
        }
        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #c9a96e;
            letter-spacing: 1px;
        }
        .invoice-number {
            font-size: 11px;
            color: #a08040;
            margin-top: 4px;
        }
        .code {
            font-family: monospace;
            font-size: 14px;
            color: #c9a96e;
            font-weight: bold;
        }
        .body { padding: 24px 28px; background: #f9f7f4; }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #888;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0d8cc;
            padding-bottom: 4px;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .detail-table td {
            padding: 7px 0;
            border-bottom: 1px solid #ede8de;
            font-size: 12px;
        }
        .detail-table td:first-child {
            color: #888;
            width: 40%;
        }
        .detail-table td:last-child {
            font-weight: bold;
            color: #1a1a1a;
            text-align: right;
        }
        .total-box {
            background: #fdf7ea;
            border: 1.5px solid #c9a96e;
            border-radius: 10px;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .total-label { font-weight: bold; color: #555; font-size: 13px; }
        .total-amount { font-size: 18px; font-weight: bold; color: #c9a96e; }
        .status-box {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-pending   { background: #fdf3d0; color: #a07010; }
        .status-confirmed { background: #ddeeff; color: #1a5cb0; }
        .status-done      { background: #d8f5e3; color: #1a7040; }
        .status-cancelled { background: #eeeeee; color: #555555; }
        .footer {
            background: #f0ebe0;
            padding: 14px 28px;
            border-radius: 0 0 12px 12px;
            text-align: center;
            border-top: 1px solid #e0d5c0;
        }
        .footer-text { font-size: 11px; color: #888; line-height: 1.6; }
        .qr-section { text-align: center; padding: 16px 0; }
        .divider { border: none; border-top: 1px solid #ede8de; margin: 16px 0; }
        .two-col { width: 100%; }
        .two-col td { vertical-align: top; }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <table style="width:100%;">
            <tr>
                <td>
                    <div class="brand">GlowSalon</div>
                    <div class="invoice-number">Platform Reservasi Kecantikan Profesional</div>
                    <div style="font-size:10px; color:#8a7050; margin-top:6px;">
                        Jakarta, Indonesia | hello@glowsalon.id
                    </div>
                </td>
                <td style="text-align:right;">
                    <div style="font-size:10px; color:#8a7050; text-transform:uppercase; letter-spacing:1px;">Invoice</div>
                    <div class="code">{{ $booking->booking_code }}</div>
                    <div style="font-size:10px; color:#8a7050; margin-top:4px;">
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                    </div>
                    <div style="margin-top:6px;">
                        <span class="status-box status-{{ $booking->status }}">
                            @php
                                $labels = ['pending'=>'Pending','confirmed'=>'Confirmed','done'=>'Selesai','cancelled'=>'Dibatalkan'];
                                echo $labels[$booking->status] ?? ucfirst($booking->status);
                            @endphp
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- BODY -->
    <div class="body">

        <!-- Data Pemesan & Reservasi -->
        <div class="section-title">Data Pemesan</div>
        <table class="detail-table">
            <tr>
                <td>Nama Pemesan</td>
                <td>{{ $booking->name }}</td>
            </tr>
            <tr>
                <td>No. HP / WA</td>
                <td>{{ $booking->phone }}</td>
            </tr>
        </table>

        <div class="section-title">Detail Reservasi</div>
        <table class="detail-table">
            <tr>
                <td>Layanan</td>
                <td>{{ $booking->service->name }}</td>
            </tr>
            <tr>
                <td>Durasi</td>
                <td>{{ $booking->service->duration }} Menit</td>
            </tr>
            <tr>
                <td>Stylist</td>
                <td>{{ $booking->employee->name }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ \Carbon\Carbon::parse($booking->date)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>{{ $booking->time }} WIB</td>
            </tr>
            <tr>
                <td>Kode Booking</td>
                <td><strong style="color:#c9a96e;">{{ $booking->booking_code }}</strong></td>
            </tr>
        </table>

        <!-- Booking Code Visual (tanpa ext-gd) -->
        <div class="qr-section">
            <div style="border: 2px solid #c9a96e; border-radius: 10px; padding: 14px 24px; display: inline-block; text-align: center;">
                <div style="font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Kode Booking</div>
                <div style="font-family: monospace; font-size: 18px; font-weight: bold; color: #c9a96e; letter-spacing: 3px;">{{ $booking->booking_code }}</div>
                <div style="font-size: 10px; color: #999; margin-top: 6px;">Tunjukkan kode ini saat datang</div>
            </div>
        </div>

        <hr class="divider">

        <!-- Total -->
        <table class="two-col">
            <tr>
                <td style="padding-right:10px;">
                    <div class="total-label">Total Pembayaran</div>
                </td>
                <td style="text-align:right;">
                    <div class="total-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p class="footer-text">
            Terima kasih telah mempercayakan kecantikan Anda kepada <strong>GlowSalon</strong>.<br>
            Harap tiba 10 menit sebelum jadwal yang ditentukan. Dilarang membatalkan kurang dari 24 jam sebelum jadwal.
        </p>
    </div>
</body>
</html>
