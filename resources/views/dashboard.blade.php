<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-body text-navy antialiased overflow-hidden" x-data="{ sidebarOpen: true, notifOpen: false }">

    <div class="flex h-screen w-full">
        
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            @include('partials.header')

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div x-data="{ show: true }" 
                    x-show="show" 
                    x-transition.duration.500ms
                    x-init="setTimeout(() => show = false, 5000)" 
                    class="mb-6 mx-6 lg:mx-8 mt-4 flex items-center justify-between bg-green-50 text-green-700 border-l-4 border-green-500 p-4 rounded shadow-sm">
                    
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                
                <!-- Greeting & CTA -->
                <div class="mb-8">
                    <h1 class="text-2xl font-heading font-bold text-navy">Halo, {{ $user->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1 mb-6">Selamat datang di sistem pengajuan sidang sarjana. Kelola pengajuan Anda di sini.</p>

                    @if($statusPendaftaran === 'tutup')
                    <!-- Banner Pendaftaran Ditutup -->
                    <div class="bg-orange/10 border border-orange/20 rounded-xl p-5 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-orange text-white rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-navy">Pendaftaran Belum Dibuka</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Periode pendaftaran akan diumumkan oleh operator.</p>
                            </div>
                        </div>
                        <span class="bg-orange/50 text-white px-4 py-2 rounded font-bold text-xs tracking-wider">PENDAFTARAN DITUTUP</span>
                    </div>
                    @else
                    <!-- Tombol Ajukan (Hanya tampil jika buka) -->
                    <div class="flex justify-end">
                        <a href="{{ url('/pengajuan') }}" class="bg-orange text-pure-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange/90 transition shadow-md flex items-center gap-2">
                            <span>+</span> Ajukan Sidang Baru
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Kartu Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Total -->
                    <div class="bg-pure-white border border-gray-200 rounded-xl p-5 relative overflow-hidden shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">TOTAL PENGAJUAN</h3>
                            <svg class="w-5 h-5 text-royal-start" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                        </div>
                        <div class="text-3xl font-heading font-bold text-royal-start mb-1">{{ str_pad($totalPengajuan, 2, '0', STR_PAD_LEFT) }}</div>
                        <p class="text-xs text-gray-400">Semua pengajuan sidang</p>
                        <div class="absolute bottom-0 left-0 w-8 h-1 bg-royal-start rounded-r"></div>
                    </div>
                    
                    <!-- Menunggu -->
                    <div class="bg-pure-white border border-orange/30 rounded-xl p-5 relative overflow-hidden shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xs font-bold text-orange uppercase tracking-wider">MENUNGGU</h3>
                            <svg class="w-5 h-5 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-3xl font-heading font-bold text-orange mb-1">{{ str_pad($menunggu, 2, '0', STR_PAD_LEFT) }}</div>
                        <p class="text-xs text-orange/70">Dalam antrean verifikasi</p>
                        <div class="absolute bottom-0 left-0 w-8 h-1 bg-orange rounded-r"></div>
                    </div>

                    <!-- Perbaikan -->
                    <div class="bg-pure-white border border-red-200 rounded-xl p-5 relative overflow-hidden shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xs font-bold text-red-500 uppercase tracking-wider">PERBAIKAN</h3>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="text-3xl font-heading font-bold text-red-500 mb-1">{{ str_pad($perbaikan, 2, '0', STR_PAD_LEFT) }}</div>
                        <p class="text-xs text-red-400">Membutuhkan tindak lanjut</p>
                        <div class="absolute bottom-0 left-0 w-8 h-1 bg-red-500 rounded-r"></div>
                    </div>

                    <!-- Selesai -->
                    <div class="bg-pure-white border border-gray-200 rounded-xl p-5 relative overflow-hidden shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">SELESAI</h3>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-3xl font-heading font-bold text-navy mb-1">{{ str_pad($selesai, 2, '0', STR_PAD_LEFT) }}</div>
                        <p class="text-xs text-gray-400">Berkas telah diterima</p>
                        <div class="absolute bottom-0 left-0 w-8 h-1 bg-green-500 rounded-r"></div>
                    </div>
                </div>

                <!-- Section Bawah: Tabel & Catatan -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Tabel Pengajuan Terbaru -->
                    <div class="lg:col-span-2 bg-pure-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="flex justify-between items-center p-5 border-b border-gray-100">
                            <h3 class="font-bold text-navy">Pengajuan Terbaru</h3>
                            <a href="{{ url('/statuspengajuan') }}" class="text-xs font-semibold text-royal-start hover:underline">LIHAT SEMUA &gt;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-400 uppercase bg-gray-50/50">
                                    <tr>
                                        <th class="px-5 py-3 font-medium">No. Pengajuan</th>
                                        <th class="px-5 py-3 font-medium">Tanggal</th>
                                        <th class="px-5 py-3 font-medium">Jenis Pengajuan</th>
                                        <th class="px-5 py-3 font-medium">Status</th>
                                        <th class="px-5 py-3 font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($pengajuans as $item)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-navy">{{ $item->nomor_pengajuan }}</div>
                                            <div class="text-xs text-gray-400 capitalize">{{ $item->paket_sidang }} • {{ $item->jalur }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="px-5 py-4 text-gray-500">Pengajuan Sidang</td>
                                        <td class="px-5 py-4">
                                            @php
                                                $statusClass = match($item->status_pengajuan) {
                                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                                    'proses' => 'bg-blue-100 text-blue-700',
                                                    'perbaikan' => 'bg-orange/10 text-orange',
                                                    'disetujui', 'selesai' => 'bg-green-100 text-green-700',
                                                    default => 'bg-gray-100 text-gray-600'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium {{ $statusClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ ucfirst($item->status_pengajuan) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <a href="{{ url('/statuspengajuan/' . $item->id) }}" class="text-royal-start text-xs font-medium hover:underline">Detail &rarr;</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">Belum ada riwayat pengajuan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Panel Catatan Perbaikan -->
                    <div class="bg-pure-white border border-gray-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="bg-royal-start p-4 flex justify-between items-center text-pure-white">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="font-bold text-sm tracking-wide">CATATAN PERBAIKAN</h3>
                            </div>
                            <span class="bg-pure-white/20 text-pure-white text-xs font-bold px-2 py-0.5 rounded">{{ str_pad($dokumenPerbaikan->count(), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="p-5 flex-1 overflow-y-auto bg-soft-bg/10 space-y-5">
                            @forelse($dokumenPerbaikan as $dok)
                            <div class="relative pl-4 border-l-2 border-red-500">
                                <div class="absolute -left-[5px] top-1.5 w-2 h-2 rounded-full bg-red-500"></div>
                                <h4 class="text-xs font-bold text-red-500 uppercase mb-1">BERKAS {{ str_replace('_', ' ', $dok->jenis_dokumen) }}</h4>
                                <p class="text-sm text-gray-600 leading-relaxed mb-2">{{ $dok->catatan_perbaikan ?: 'Dokumen memerlukan perbaikan.' }}</p>
                                <a href="{{ url('/statuspengajuan/' . $dok->pengajuan_id) }}" class="text-xs font-bold text-royal-start hover:underline">PERBAIKI SEKARANG &rarr;</a>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-400 text-sm">
                                <p>Tidak ada catatan perbaikan saat ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

</body>
</html>