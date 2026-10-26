<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-body text-navy antialiased overflow-hidden" x-data="{ sidebarOpen: true, notifOpen: false }">

    <div class="flex h-screen w-full">
        
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            @include('partials.header')

            <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-white">
                
                <div class="max-w-6xl mx-auto">
                    
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 border border-green-200 p-4 rounded-lg shadow-sm mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- ========================================== -->
                    <!-- TAMPILAN 1: DAFTAR PENGAJUAN (LIST VIEW) -->
                    <!-- ========================================== -->
                    @if(!request()->route('id'))
                        <div class="mb-8">
                            <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">PENGAJUAN ANDA</p>
                            <h1 class="text-3xl font-bold text-navy mb-2">Status Pengajuan</h1>
                            <p class="text-gray-500 text-sm">Ikuti perkembangan verifikasi berkas sidang Anda.</p>
                        </div>
                        
                        <!-- Form Filter & Pencarian -->
                        <form method="GET" action="{{ url('/statuspengajuan') }}" class="flex flex-col sm:flex-row gap-4 mb-6">
                            <div class="relative flex-1">
                                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <!-- Pertahankan nilai input pencarian sebelumnya -->
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pengajuan..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 transition text-gray-700">
                            </div>
                            
                            <div class="relative min-w-[180px] flex gap-2">
                                <!-- Pertahankan pilihan dropdown filter sebelumnya -->
                                <select name="status" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-lg outline-none text-sm focus:border-blue-500 cursor-pointer">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-14 flex items-center px-3 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition">
                                    Cari
                                </button>
                            </div>
                        </form>
                        
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-blue-100 text-blue-900 text-xs font-bold uppercase tracking-wider">
                                        <th class="p-4 py-5 whitespace-nowrap w-1/5">NO. PENGAJUAN</th>
                                        <th class="p-4 py-5 whitespace-nowrap w-1/5">TANGGAL</th>
                                        <th class="p-4 py-5 whitespace-nowrap w-1/4">PAKET SIDANG</th>
                                        <th class="p-4 py-5 whitespace-nowrap w-1/6">STATUS</th>
                                        <th class="p-4 py-5 whitespace-nowrap w-1/6 text-right">AKSI</th>
                                    </tr>
                                </thead>
                                
                                @if($pengajuans->isEmpty())
                                <tbody class="bg-gray-50/50">
                                    <tr>
                                        <td colspan="5" class="py-24 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-blue-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <h3 class="text-lg font-bold text-navy mb-1">Tidak ada pengajuan</h3>
                                                <p class="text-sm text-gray-500">Belum ada pengajuan yang sesuai dengan pencarian Anda.</p>
                                                
                                                <!-- Tombol Reset akan muncul jika sedang melakukan pencarian -->
                                                @if(request('search') || request('status'))
                                                    <a href="{{ url('/statuspengajuan') }}" class="mt-4 inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Hapus Filter
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                @else
                                <tbody class="divide-y divide-gray-100 text-sm bg-white border-b border-gray-100">
                                    @foreach($pengajuans as $item)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="p-4 py-5">
                                            <a href="{{ url('/statuspengajuan/'.$item->id) }}" class="text-blue-600 font-bold hover:underline">{{ $item->nomor_pengajuan }}</a>
                                        </td>
                                        <td class="p-4 py-5 text-gray-700">{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="p-4 py-5">
                                            <div class="font-bold text-navy capitalize">{{ $item->paket_sidang }}</div>
                                            <div class="text-gray-400 text-xs mt-0.5 capitalize">{{ $item->jalur }}</div>
                                        </td>
                                        <td class="p-4 py-5">
                                            @php
                                                $status = $item->status_pengajuan === 'disetujui' ? 'selesai' : $item->status_pengajuan;
                                                $pillClass = match($status) {
                                                    'menunggu', 'proses' => 'bg-blue-50 text-blue-600',
                                                    'perbaikan' => 'bg-orange-50 text-orange-600',
                                                    'selesai' => 'bg-green-50 text-green-600',
                                                    default => 'bg-gray-50 text-gray-600'
                                                };
                                                $dotClass = match($status) {
                                                    'menunggu', 'proses' => 'bg-blue-600',
                                                    'perbaikan' => 'bg-orange-500',
                                                    'selesai' => 'bg-green-500',
                                                    default => 'bg-gray-400'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold capitalize {{ $pillClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="p-4 py-5 text-right">
                                            <a href="{{ url('/statuspengajuan/'.$item->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm inline-flex items-center gap-1">
                                                Lihat <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>


                    <!-- ========================================== -->
                    <!-- TAMPILAN 2: DETAIL PENGAJUAN -->
                    <!-- ========================================== -->
                    @else
                        @php 
                            $p = $pengajuanAktif; 
                            $status = $p->status_pengajuan === 'disetujui' ? 'selesai' : $p->status_pengajuan;
                            
                            $kategori = match($p->kategori_hasil) {
                                '1' => 'Bisa Daftar Sidang',
                                '2a' => 'Kendala Berkas',
                                '2b' => 'Kendala Nilai',
                                '3' => 'Kendala Pembayaran',
                                default => 'Belum ditentukan'
                            };
                        @endphp
                        
                        <div class="mb-6">
                            <a href="{{ url('/statuspengajuan') }}" class="text-blue-600 hover:underline text-sm font-semibold inline-flex items-center gap-2">
                                &larr; Kembali ke daftar
                            </a>
                        </div>

                        <!-- Header Detail -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                            <div>
                                <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">DETAIL PENGAJUAN</p>
                                <h1 class="text-3xl font-bold text-navy mb-1">{{ $p->nomor_pengajuan }}</h1>
                                <p class="text-gray-500 text-sm">Diajukan pada {{ $p->created_at->format('d M Y') }}</p>
                            </div>
                            
                            @php
                                $pillClass = match($status) {
                                    'menunggu', 'proses' => 'bg-blue-50 text-blue-600',
                                    'perbaikan' => 'bg-orange-50 text-orange-600',
                                    'selesai' => 'bg-green-50 text-green-600',
                                    default => 'bg-gray-50 text-gray-600'
                                };
                                $dotClass = match($status) {
                                    'menunggu', 'proses' => 'bg-blue-600',
                                    'perbaikan' => 'bg-orange-500',
                                    'selesai' => 'bg-green-500',
                                    default => 'bg-gray-400'
                                };
                            @endphp
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold capitalize {{ $pillClass }}">
                                <span class="w-2 h-2 rounded-full {{ $dotClass }}"></span>
                                {{ $status }}
                            </div>
                        </div>

                        <div x-data="{ tab: 'informasi' }">
                            
                            <!-- Tab Navigations -->
                            <div class="flex border-b border-gray-200 overflow-x-auto mb-6">
                                <button @click="tab = 'informasi'" :class="tab === 'informasi' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" class="px-6 py-3 text-sm border-b-2 whitespace-nowrap transition">
                                    Informasi
                                </button>
                                <button @click="tab = 'dokumen'" :class="tab === 'dokumen' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" class="px-6 py-3 text-sm border-b-2 whitespace-nowrap transition flex items-center gap-2">
                                    Dokumen
                                </button>
                                <button @click="tab = 'riwayat'" :class="tab === 'riwayat' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-800 font-medium'" class="px-6 py-3 text-sm border-b-2 whitespace-nowrap transition">
                                    Riwayat
                                </button>
                            </div>

                            <!-- Alert Banners Dinamis -->
                            @if($kategori == 'Kendala Berkas')
                            <div class="bg-red-50/50 border-l-4 border-red-600 p-5 px-6 mb-8 flex items-start gap-4 rounded-r-lg">
                                <svg class="w-6 h-6 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-base font-bold text-red-700">Berkas perlu diperbaiki</h4>
                                    <p class="text-sm text-gray-700 mt-1">Mohon perbaiki dokumen yang ditandai agar verifikasi dapat dilanjutkan.</p>
                                </div>
                            </div>
                            @elseif($kategori == 'Kendala Pembayaran')
                            <div class="bg-yellow-50/50 border-l-4 border-yellow-500 p-5 px-6 mb-8 flex items-start gap-4 rounded-r-lg">
                                <svg class="w-6 h-6 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-base font-bold text-yellow-700">Terdapat Kendala Pembayaran</h4>
                                    <p class="text-sm text-gray-700 mt-1">Silakan menyelesaikan kendala lainnya, lalu hubungi Ibu Lilis untuk kendala pembayaran (kontak ada di Web Fikti).</p>
                                </div>
                            </div>
                            @elseif($kategori == 'Kendala Nilai')
                            <div class="bg-purple-50/50 border-l-4 border-purple-500 p-5 px-6 mb-8 flex items-start gap-4 rounded-r-lg">
                                <svg class="w-6 h-6 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-base font-bold text-purple-700">Terdapat Kendala Nilai</h4>
                                    <p class="text-sm text-gray-700 mt-1">Silakan melengkapi kekurangan berkas dan menghubungi Pak Edy / Pak Restu untuk kendala nilai.</p>
                                </div>
                            </div>
                            @elseif($kategori == 'Bisa Daftar Sidang')
                            <div class="bg-green-50/50 border-l-4 border-green-500 p-5 px-6 mb-8 flex items-start gap-4 rounded-r-lg">
                                <div class="w-6 h-6 shrink-0 rounded-full bg-green-500 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-green-700">Pendaftaran Berhasil</h4>
                                    <p class="text-sm text-gray-700 mt-1">Berkas Anda telah diterima. Anda dapat melanjutkan ke pendaftaran sidang.</p>
                                </div>
                            </div>
                            @else
                            <div class="bg-orange-50 border-l-4 border-orange-500 p-5 px-6 mb-8 flex items-start gap-4 rounded-r-lg">
                                <svg class="w-6 h-6 text-orange-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-base font-bold text-navy">Catatan pemeriksaan</h4>
                                    <p class="text-sm text-gray-600 mt-1">Pengajuan Anda berada dalam antrean verifikasi.</p>
                                </div>
                            </div>
                            @endif

                            <!-- TAB 1: INFORMASI -->
                            <div x-show="tab === 'informasi'" x-transition.opacity>
                                <div class="bg-white border border-gray-100 rounded-xl mb-10">
                                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 text-sm">
                                        <div class="p-6 md:border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Nama Mahasiswa</p>
                                            <p class="text-blue-600">{{ $p->user->name }}</p>
                                        </div>
                                        <div class="p-6 border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">NPM</p>
                                            <p class="text-blue-600">{{ $p->user->profil->npm }}</p>
                                        </div>
                                        <div class="p-6 md:border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Email</p>
                                            <p class="text-blue-600">{{ $p->user->email }}</p>
                                        </div>
                                        <div class="p-6 border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">WhatsApp</p>
                                            <p class="text-blue-600">{{ $p->user->profil->no_whatsapp }}</p>
                                        </div>
                                        <div class="p-6 md:border-b border-gray-100 bg-blue-50/20">
                                            <p class="text-navy text-xs mb-1">Fakultas</p>
                                            <p class="text-blue-600 font-medium">{{ $p->user->profil->fakultas }}</p>
                                        </div>
                                        <div class="p-6 border-b border-gray-100 bg-blue-50/20">
                                            <p class="text-navy text-xs mb-1">Program Studi</p>
                                            <p class="text-blue-600 font-medium">{{ $p->user->profil->program_studi }}</p>
                                        </div>
                                        <div class="p-6 md:border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Angkatan</p>
                                            <p class="text-blue-600">{{ $p->user->profil->angkatan }}</p>
                                        </div>
                                        <div class="p-6 border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Jalur</p>
                                            <p class="text-blue-600 capitalize">{{ $p->jalur }}</p>
                                        </div>
                                        <div class="p-6 md:border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Paket Sidang</p>
                                            <p class="text-blue-600 capitalize">{{ $p->paket_sidang }}</p>
                                        </div>
                                        <div class="p-6 border-b border-gray-100">
                                            @if($p->paket_sidang === 'skripsi')
                                                <p class="text-navy font-bold mb-1">Judul Skripsi</p>
                                                <p class="text-blue-600">{{ $p->judul_skripsi ?? '-' }}</p>
                                            @else
                                                <p class="text-navy font-bold mb-1">Dosen Pembimbing PI</p>
                                                <p class="text-blue-600">{{ $p->dosen_pembimbing_pi ?? '-' }}</p>
                                            @endif
                                        </div>
                                        <div class="p-6 md:border-b border-gray-100">
                                            <p class="text-navy font-bold mb-1">Tanggal Pengajuan</p>
                                            <p class="text-navy">{{ $p->created_at->format('d F Y') }} pukul {{ $p->created_at->format('H.i') }} WIB</p>
                                        </div>
                                        <div class="p-6">
                                            <p class="text-navy font-bold mb-1">Kategori Hasil</p>
                                            <p class="text-navy font-medium flex items-center gap-1">
                                                @if($kategori != 'Belum ditentukan' && $kategori != 'Bisa Daftar Sidang')
                                                    <span class="text-red-500">●</span> 
                                                @elseif($kategori == 'Bisa Daftar Sidang')
                                                    <span class="text-green-500">●</span>
                                                @endif
                                                {{ $kategori }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabel Status Pemeriksaan Dinamis -->
                                <h2 class="text-2xl font-bold text-navy mb-4">Status Pemeriksaan</h2>
                                <div class="border border-gray-200 rounded-lg overflow-hidden bg-white mb-10">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="bg-blue-100/50 text-blue-700 text-xs font-bold tracking-wider uppercase">
                                                <th class="p-4 w-2/3">BAGIAN PEMERIKSAAN</th>
                                                <th class="p-4 text-right">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 text-sm font-semibold">
                                            
                                            <tr>
                                                <td class="p-5 text-orange-500">Data Mahasiswa</td>
                                                <td class="p-5 text-right"><span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs">● Lengkap</span></td>
                                            </tr>
                                            <tr>
                                                <td class="p-5 text-orange-500">Data Akademik</td>
                                                <td class="p-5 text-right">
                                                    @if($kategori == 'Kendala Nilai')
                                                        <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs">● Kendala nilai</span>
                                                    @else
                                                        <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs">● Lengkap</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-5 text-orange-500">Dokumen Persyaratan</td>
                                                <td class="p-5 text-right">
                                                    @if($kategori == 'Kendala Berkas')
                                                        <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs">● Perlu perbaikan</span>
                                                    @elseif($kategori == 'Kendala Nilai')
                                                        <span class="bg-orange-50 text-orange-600 px-3 py-1 rounded-full text-xs">● Perlu dilengkapi</span>
                                                    @elseif($kategori == 'Bisa Daftar Sidang' || $kategori == 'Kendala Pembayaran')
                                                        <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs">● Lengkap</span>
                                                    @else
                                                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs">● Menunggu</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-5 text-orange-500">Verifikasi Operator</td>
                                                <td class="p-5 text-right">
                                                    @if($kategori == 'Kendala Pembayaran')
                                                        <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs">● Kendala pembayaran</span>
                                                    @elseif(in_array($kategori, ['Kendala Berkas', 'Kendala Nilai']))
                                                        <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs">● Perbaikan</span>
                                                    @elseif($kategori == 'Bisa Daftar Sidang')
                                                        <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs">● Lengkap</span>
                                                    @else
                                                        <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">● Belum diproses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="bg-white hover:bg-gray-50 cursor-pointer" @click="tab = 'dokumen'">
                                                <td colspan="2" class="p-5">
                                                    <span class="text-blue-600 font-bold inline-flex items-center gap-1">Lihat Detail Dokumen ↗</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 2: DOKUMEN -->
                            <div x-show="tab === 'dokumen'" x-cloak x-transition.opacity>
                                <div class="space-y-4 mb-10">
                                    @foreach($p->dokumen as $dok)
                                    <div x-data="{ formUpload: false, isDragging: false, fileNameRevisi: '' }" class="border border-gray-200 rounded-xl bg-white p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-blue-200 transition">
                                        
                                        <!-- Info Dokumen (Kiri) -->
                                        <div class="flex items-start gap-4 w-full">
                                            <div class="mt-1 text-blue-600 bg-blue-50/50 p-2.5 rounded-lg border border-blue-100 shrink-0">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="flex-1 w-full">
                                                <h4 class="font-bold text-navy text-base capitalize">{{ str_replace('_', ' ', $dok->jenis_dokumen) }}</h4>
                                                <p class="text-sm text-gray-500 mb-3">{{ $dok->jenis_dokumen }}.pdf</p>
                                                
                                                @php
                                                    $dokStatusColor = match($dok->status_dokumen) {
                                                        'lengkap' => 'bg-green-50 text-green-600',
                                                        'perbaikan', 'perlu_perbaikan' => 'bg-red-50 text-red-600',
                                                        default => 'bg-gray-100 text-gray-500'
                                                    };
                                                    $dokStatusLabel = match($dok->status_dokumen) {
                                                        'lengkap' => 'Lengkap',
                                                        'perbaikan', 'perlu_perbaikan' => 'Perlu perbaikan',
                                                        default => 'Menunggu'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $dokStatusColor }}">
                                                    ● {{ $dokStatusLabel }}
                                                </span>

                                                @if(in_array($dok->status_dokumen, ['perbaikan', 'perlu_perbaikan']))
                                                    <p class="text-sm text-gray-600 mt-4">{{ $dok->catatan_perbaikan }}</p>
                                                    
                                                    <!-- UI Baru Form Upload (Drag and Drop) -->
                                                    <div x-show="formUpload" x-transition class="mt-4 pt-5 border-t border-gray-100 w-full">
                                                        <form action="{{ url('/dokumen/'.$dok->id.'/revisi') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 w-full">
                                                            @csrf
                                                            
                                                            <!-- Drag and Drop Area -->
                                                            <div 
                                                                @dragover.prevent="isDragging = true" 
                                                                @dragleave.prevent="isDragging = false" 
                                                                @drop.prevent="isDragging = false; $refs.fileRevisi.files = $event.dataTransfer.files; fileNameRevisi = $event.dataTransfer.files[0].name"
                                                                :class="isDragging ? 'bg-blue-50 border-blue-400' : 'bg-gray-50 border-gray-300'"
                                                                class="relative border-2 border-dashed rounded-xl p-8 flex flex-col items-center justify-center transition cursor-pointer hover:bg-gray-100 group"
                                                            >
                                                                <input type="file" name="file_revisi" x-ref="fileRevisi" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="fileNameRevisi = $event.target.files[0].name">
                                                                
                                                                <svg class="w-10 h-10 text-gray-400 mb-3 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                                
                                                                <p class="text-sm font-bold text-navy text-center" x-text="fileNameRevisi || 'Tarik file PDF ke sini, atau klik untuk memilih file'"></p>
                                                                <p class="text-xs text-gray-500 mt-2" x-show="!fileNameRevisi">Format PDF (Maksimal 2MB)</p>
                                                            </div>

                                                            <div class="flex justify-end gap-2">
                                                                <button type="button" @click="formUpload = false" class="px-5 py-2.5 rounded-lg text-sm font-bold text-gray-500 hover:bg-gray-100 transition">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow hover:bg-blue-700 transition flex items-center gap-2">
                                                                    Kirim Revisi
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Tombol Aksi (Kanan) -->
                                        <div class="flex flex-col items-end gap-3 shrink-0">
                                            <button type="button" onclick="bukaModalPdf('{{ url('/dokumen/'.$dok->id.'/lihat') }}')" class="border border-gray-200 text-gray-700 hover:text-black bg-white hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-bold transition inline-flex items-center gap-2 shadow-sm">
                                                Lihat ↗
                                            </button>
                                            
                                            @if(in_array($dok->status_dokumen, ['perbaikan', 'perlu_perbaikan']))
                                                <!-- TOMBOL UNGGAH ULANG -->
                                                <button @click="formUpload = true" x-show="!formUpload" type="button" class="text-blue-600 font-bold text-sm inline-flex items-center gap-1 hover:underline mt-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    Unggah ulang
                                                </button>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- TAB 3: RIWAYAT -->
                            <div x-show="tab === 'riwayat'" x-cloak x-transition.opacity>
                                <div class="bg-white p-8 rounded-xl border border-gray-100 mb-10">
                                    <div class="relative border-l-2 border-gray-200 ml-3 py-2 space-y-8">
                                        @forelse($p->riwayat()->orderBy('created_at', 'desc')->get() as $log)
                                        <div class="relative pl-8">
                                            <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white bg-blue-500 shadow-sm"></div>
                                            <div>
                                                <span class="text-xs font-bold text-gray-400">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                                <h4 class="text-sm font-bold text-navy mt-1">{{ $log->aksi }}</h4>
                                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $log->deskripsi }}</p>
                                                <p class="text-xs text-gray-400 mt-2 italic">Oleh: {{ $log->user->name }}</p>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="text-center py-6 text-gray-500 text-sm">
                                            Belum ada riwayat perubahan.
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

    <!-- Modal Pop-up PDF -->
    <div id="pdfModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity" style="z-index: 9999;">
        <div class="bg-white w-full max-w-5xl h-[90vh] rounded-xl shadow-2xl flex flex-col overflow-hidden">
            <!-- Header Modal -->
            <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                <h3 class="font-bold text-navy flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pratinjau Dokumen
                </h3>
                <button onclick="tutupModalPdf()" class="text-gray-500 hover:text-white bg-gray-200 hover:bg-red-500 p-2 rounded-lg transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Area Iframe PDF -->
            <div class="flex-grow bg-gray-200 relative">
                <iframe id="pdfFrame" src="" class="w-full h-full border-none"></iframe>
            </div>
        </div>
    </div>

    <!-- Script Pengendali Modal -->
    <script>
        function bukaModalPdf(url) {
            document.getElementById('pdfFrame').src = url;
            document.getElementById('pdfModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function tutupModalPdf() {
            document.getElementById('pdfModal').classList.add('hidden');
            document.getElementById('pdfFrame').src = ''; 
            document.body.style.overflow = 'auto'; 
        }
    </script>
</body>
</html>