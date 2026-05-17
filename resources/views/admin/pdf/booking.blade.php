<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi JemuranKu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0d5c4a; margin-bottom: 20px; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #0d5c4a; }
        .header p { margin: 5px 0 0; color: #666; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #0d5c4a; color: white; padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { border-bottom: 1px solid #ddd; padding: 10px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .bg-aktif { background: #d1fae5; color: #065f46; }
        .bg-menunggu { background: #fef3c7; color: #92400e; }
        .bg-selesai { background: #dbeafe; color: #1e40af; }
        .bg-batal { background: #fee2e2; color: #991b1b; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Transaksi - JemuranKu</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Booking</th>
                <th>Nama Pelanggan</th>
                <th>Nomor Rak</th>
                <th>Tanggal & Waktu Jemur</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->spot->kode_jemuran }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('H:i') }}</small>
                    </td>
                    <td>
                        <span class="badge bg-{{ $booking->status_booking }}">
                            {{ $booking->status_booking }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem JemuranKu
    </div>

</body>
</html>