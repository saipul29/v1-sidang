<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Header Admin Sederhana -->
    <header class="bg-navy text-white px-8 py-4 flex justify-between items-center shadow-md">
        <h1 class="text-xl font-bold">Panel Admin - Sidang Sarjana</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm">Halo, {{ Auth::user()->name }}</span>
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm font-bold transition">Keluar</button>
            </form>
        </div>
    </header>

    <main class="p-8 max-w-7xl mx-auto">
        
        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-700 border-l-4 border-green-500 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Panel Kontrol Buka / Tutup Pendaftaran -->
        @php
            $statusDaftar = \App\Models\PengaturanSistem::where('key', 'status_pendaftaran')->value('value') ?? 'buka';
        @endphp
        <div class="bg-white p-6 rounded-xl shadow-sm border {{ $statusDaftar == 'buka' ? 'border-green-200' : 'border-red-200' }} mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="font-bold text-navy text-lg">Status Pendaftaran Sidang</h3>
                <p class="text-sm text-gray-500 mt-1">Saat ini akses mahasiswa untuk mengajukan form pendaftaran sedang <span class="font-bold uppercase {{ $statusDaftar == 'buka' ? 'text-green-600' : 'text-red-600' }}">{{ $statusDaftar }}</span>.</p>
            </div>
            <form action="{{ url('/admin/pengaturan/toggle-pendaftaran') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 rounded-lg font-bold text-sm text-white shadow-md transition {{ $statusDaftar == 'buka' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                    {{ $statusDaftar == 'buka' ? 'Tutup Pendaftaran Sekarang' : 'Buka Pendaftaran Sekarang' }}
                </button>
            </form>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <p class="text-xs font-bold text-gray-400 mb-1">TOTAL PENGAJUAN</p>
                <h3 class="text-3xl font-bold text-navy">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-orange">
                <p class="text-xs font-bold text-orange mb-1">MENUNGGU VERIFIKASI</p>
                <h3 class="text-3xl font-bold text-orange">{{ str_pad($stats['menunggu'], 2, '0', STR_PAD_LEFT) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-500">
                <p class="text-xs font-bold text-blue-500 mb-1">SEDANG DIPROSES</p>
                <h3 class="text-3xl font-bold text-blue-500">{{ str_pad($stats['proses'], 2, '0', STR_PAD_LEFT) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-green-500">
                <p class="text-xs font-bold text-green-500 mb-1">SELESAI / DISETUJUI</p>
                <h3 class="text-3xl font-bold text-green-500">{{ str_pad($stats['selesai'], 2, '0', STR_PAD_LEFT) }}</h3>
            </div>
        </div>

        <!-- Tabel Antrean -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="font-bold text-lg text-navy">Antrean Pengajuan Mahasiswa</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-4">No. Pengajuan</th>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">Jalur & Paket</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengajuans as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-bold text-navy">{{ $item->nomor_pengajuan }}<br><span class="text-xs text-gray-400 font-normal">{{ $item->created_at->format('d M Y, H:i') }}</span></td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-navy">{{ $item->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $item->user->profil->npm ?? '-' }} • {{ $item->user->profil->program_studi ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 capitalize text-navy font-medium">{{ $item->jalur }}<br><span class="text-gray-500 text-xs">{{ $item->paket_sidang }}</span></td>
                            <td class="px-6 py-4">
                                @php
                                    $bg = match($item->status_pengajuan) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'proses' => 'bg-blue-100 text-blue-700',
                                        'perbaikan' => 'bg-orange/10 text-orange border border-orange/20',
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-md text-xs font-bold uppercase {{ $bg }}">{{ $item->status_pengajuan }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ url('/admin/pengajuan/' . $item->id) }}" class="bg-royal-start text-white px-4 py-2 rounded text-xs font-bold hover:bg-royal-end transition shadow">
                                    Periksa Berkas &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data pengajuan yang masuk ke sistem.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>