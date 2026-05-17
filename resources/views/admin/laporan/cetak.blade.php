<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Eksekutif JemuranKu - #{{ date('Ymd') }}</title>
    <style>
        /* ======================================================== */
        /* CONFIGURATION & CORE TYPOGRAPHY (SAFE FOR DOMPDF)        */
        /* ======================================================== */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 10px;
            font-size: 11px;
            line-height: 1.5;
        }

        /* Pengaturan Layout Kertas A4 Mendatar (Landscape) */
        @page {
            size: A4 landscape;
            margin: 1.2cm 1cm;
        }

        /* Tombol Pratinjau Browser (Otomatis Hilang Saat Print/PDF) */
        .no-print-bar {
            background-color: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
            text-align: right;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .btn {
            padding: 8px 18px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            border: 1px solid #cbd5e1;
            display: inline-block;
            text-decoration: none;
        }
        .btn-close { background-color: #f8fafc; color: #475569; margin-right: 8px; }
        .btn-print { background-color: #0d5c4a; color: #ffffff; border: none; }

        @media print {
            .no-print-bar { display: none !important; }
            body { padding: 0; }
        }

        /* ======================================================== */
        /* STRUCTURAL LAYOUT TABLES (ANTI-BREAK MECHANISM)          */
        /* ======================================================== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-layout {
            border: none;
            margin-bottom: 15px;
        }
        .table-layout td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        /* ======================================================== */
        /* KOP SURAT / HEADER DESIGN                                */
        /* ======================================================== */
        .brand-title {
            font-size: 26px;
            font-weight: 800;
            color: #0d5c4a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .brand-tagline {
            font-size: 11px;
            color: #64748b;
            margin: 4px 0 0 0;
            font-weight: 500;
        }
        .doc-title {
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .doc-meta {
            font-size: 10px;
            color: #64748b;
            margin: 5px 0 0 0;
        }
        .divider-line {
            height: 3px;
            background: linear-gradient(90deg, #0d5c4a 0%, #10b981 100%);
            margin-bottom: 25px;
            margin-top: 5px;
        }

        /* ======================================================== */
        /* EXECUTIVE SUMMARY CARDS SECTION (3 COLUMNS TABLE)        */
        /* ======================================================== */
        .card-table {
            margin-bottom: 25px;
        }
        .card-table td {
            padding: 0 10px;
            width: 33.33%;
        }
        .card-table td:first-child { padding-left: 0; }
        .card-table td:last-child { padding-right: 0; }

        .metric-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }
        .card-emerald {
            background-color: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-left: 4px solid #0d5c4a;
        }
        .card-blue {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            border-left: 4px solid #2563eb;
        }
        .card-slate {
            border-left: 4px solid #64748b;
        }
        .card-label {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .card-emerald .card-label { color: #0f766e; }
        .card-blue .card-label { color: #1d4ed8; }

        .card-value {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }
        .card-emerald .card-value { color: #115e59; }

        /* ======================================================== */
        /* FILTER BADGES / METADATA                                 */
        /* ======================================================== */
        .filter-title {
            font-size: 10px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .badge-filter {
            display: inline-block;
            background-color: #f1f5f9;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        /* ======================================================== */
        /* MAIN DATA TABLE DESIGN                                   */
        /* ======================================================== */
        .main-table {
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            border-radius: 6px;
            overflow: hidden;
        }
        .main-table th {
            background-color: #0d5c4a;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9.5px;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            border: 1px solid #0d5c4a;
        }
        .main-table td {
            padding: 9px 12px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 10.5px;
        }
        /* Zebra Striping */
        .main-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Helper Alignments */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: Courier, monospace; font-weight: bold; }

        /* Status Badge Pills */
        .status-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            text-align: center;
        }
        .status-aktif { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .status-selesai { background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-menunggu { background-color: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
        .status-batal { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Grand Total Row Footer Table */
        .row-total {
            background-color: #f1f5f9 !important;
            font-weight: bold;
        }
        .row-total td {
            border-top: 2px solid #0d5c4a;
            border-bottom: 2px solid #0d5c4a;
            font-size: 12px;
        }

        /* ======================================================== */
        /* SIGNATURE SECTION (BOTTOM LAYOUT)                        */
        /* ======================================================== */
        .signature-table {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-title {
            font-size: 11px;
            color: #475569;
            margin-bottom: 70px;
        }
        .signature-line {
            width: 200px;
            border-bottom: 1.5px solid #1e293b;
            margin: 0 auto 4px auto;
        }
        .signature-name {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    @if(!request()->routeIs('admin.laporan.pdf'))
    <div class="no-print-bar">
        <button onclick="window.close()" class="btn btn-close">Tutup Halaman</button>
        <button onclick="window.print()" class="btn btn-print">Cetak Dokumen</button>
    </div>
    @endif

    <table class="table-layout">
        <tr>
            <td width="60%">
                <h1 class="brand-title">JemuranKu</h1>
                <p class="brand-tagline">Premium Laundry Rack Facilities & Smart Management System</p>
            </td>
            <td width="40%" class="text-right">
                <h2 class="doc-title">Laporan Finansial</h2>
                <p class="doc-meta">Tanggal Ekstraksi: <strong>{{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</strong></p>
            </td>
        </tr>
    </table>

    <div class="divider-line"></div>

    <table class="table-layout card-table">
        <tr>
            <td>
                <div class="metric-card card-emerald">
                    <div class="card-label">Total Omset Pendapatan (Lunas)</div>
                    <div class="card-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                </div>
            </td>
            <td>
                <div class="metric-card card-blue">
                    <div class="card-label font-bold">Total Transaksi Masuk</div>
                    <div class="card-value">{{ $laporan->count() }} <span style="font-size: 11px; font-weight: normal; color: #475569;">Pesanan</span></div>
                </div>
            </td>
            <td>
                <div class="metric-card card-slate">
                    <div class="card-label">Rincian Ruang Filter Data</div>
                    <div class="text-[11px] font-semibold text-slate-700 mt-1">
                        Waktu: <span class="badge-filter" style="padding: 1px 5px; font-size: 9px;">{{ strtoupper(str_replace('_', ' ', request('filter_waktu', 'Semua Waktu'))) }}</span>
                        &bull; Status: <span class="badge-filter" style="padding: 1px 5px; font-size: 9px;">{{ strtoupper(request('status', 'Semua')) }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">ID Transaksi</th>
                <th width="14%">Tanggal Input</th>
                <th width="20%">Nama Pelanggan</th>
                <th width="8%" class="text-center">No. Rak</th>
                <th width="24%">Durasi Penggunaan Fasilitas</th>
                <th width="10%" class="text-center">Status</th>
                <th width="14%" class="text-right">Kas Masuk (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
                <tr>
                    <td class="text-center text-gray-400">{{ $index + 1 }}</td>
                    <td class="font-mono text-primary">#JMR-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $item->user->name }}</td>
                    <td class="text-center font-bold text-gray-700">{{ $item->spot->kode_jemuran }}</td>
                    <td>
                        <span style="color: #166534; font-weight: bold;">&gt;</span> {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M (H:i)') }}
                        <span style="color: #64748b; font-size: 9px;">s/d</span>
                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M y (H:i)') }}
                    </td>
                    <td class="text-center">
                        @php
                            $statusClass = match(strtolower($item->status_booking)) {
                                'aktif' => 'status-aktif',
                                'selletai', 'selesai' => 'status-selesai',
                                'menunggu' => 'status-menunggu',
                                default => 'status-batal'
                            };
                            $statusLabel = $item->status_booking == 'menunggu' ? 'PENDING' : $item->status_booking;
                        @endphp
                        <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="text-right font-bold">
                        @if(in_array($item->status_booking, ['aktif', 'selesai']))
                            <span style="color: #0f766e;">Rp {{ number_format($item->spot->harga ?? 0, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #94a3b8; text-decoration: line-through; font-weight: normal;">Rp {{ number_format($item->spot->harga ?? 0, 0, ',', '.') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 40px 0; color: #94a3b8; font-style: italic; font-size: 12px;">
                        Tidak ditemukan rekaman data transaksi penyewaan berdasarkan filter aktif saat ini.
                    </td>
                </tr>
            @endforelse

            <tr class="row-total">
                <td colspan="7" class="text-right" style="text-transform: uppercase; letter-spacing: 0.5px; font-size: 10px; padding-right: 20px;">
                    Akumulasi Kas Pendapatan Bersih (Lunas) :
                </td>
                <td class="text-right" style="color: #0d5c4a; font-size: 13px;">
                    Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table-layout signature-table">
        <tr>
            <td width="70%"></td>
            <td width="30%" class="text-center">
                <p class="signature-title">Disahkan di Jakarta,<br><strong>Executive Administrator</strong></p>
                <div class="signature-line"></div>
                <p class="signature-name">Audit System JemuranKu</p>
                <p style="font-size: 8px; color: #94a3b8; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Sistem Utama Terverifikasi</p>
            </td>
        </tr>
    </table>

</body>
</html>
