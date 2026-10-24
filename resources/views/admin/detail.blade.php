<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Verifikasi - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased pb-20">

    <!-- Header -->
    <header class="bg-navy text-white px-8 py-4 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Verifikasi Berkas Mahasiswa</h1>
            <a href="{{ url('/admin/dashboard') }}" class="text-sm hover:underline font-medium">&larr; Kembali ke Dasbor</a>
        </div>
    </header>

    <main class="p-6 md:p-8 max-w-6xl mx-auto space-y-6">
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 border-l-4 border-green-500 p-4 rounded shadow-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-4 rounded shadow-sm font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Header Info Mahasiswa -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-navy">{{ $pengajuan->nomor_pengajuan }}</h2>
                <p class="text-gray-500 text-sm mt-1">
                    <span class="font-bold text-gray-700">{{ $pengajuan->user->name }}</span> ({{ $pengajuan->user->profil->npm }}) • {{ $pengajuan->user->profil->program_studi }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Jalur: <span class="uppercase font-semibold text-gray-600">{{ $pengajuan->jalur }}</span> | Paket: <span class="capitalize font-semibold text-gray-600">{{ $pengajuan->paket_sidang }}</span></p>
            </div>
            
            @php
                $bgStatus = match($pengajuan->status_pengajuan) {
                    'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'proses' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'perlu_perbaikan', 'perbaikan' => 'bg-orange/10 text-orange border-orange/20',
                    'disetujui', 'selesai' => 'bg-green-100 text-green-700 border-green-200',
                    default => 'bg-gray-100 text-gray-600 border-gray-200'
                };
            @endphp
            <div class="text-right">
                <span class="text-xs text-gray-400 block mb-1">Status Pengajuan</span>
                <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase border {{ $bgStatus }}">
                    {{ str_replace('_', ' ', $pengajuan->status_pengajuan) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Daftar Dokumen & Verifikasi -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-bold text-lg text-navy mb-2 flex items-center gap-2">
                    <span class="bg-navy text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span> 
                    Pemeriksaan Dokumen
                </h3>
                
                @foreach($pengajuan->dokumen as $dok)
                <div class="bg-white p-5 rounded-xl shadow-sm border {{ $dok->status_dokumen == 'perlu_perbaikan' ? 'border-red-300' : ($dok->status_dokumen == 'lengkap' ? 'border-green-300' : 'border-gray-200') }}">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                        <div>
                            <h4 class="font-bold text-navy uppercase">{{ str_replace('_', ' ', $dok->jenis_dokumen) }}</h4>
                            <span class="text-xs px-2 py-1 rounded font-bold capitalize mt-1 inline-block {{ $dok->status_dokumen == 'lengkap' ? 'bg-green-100 text-green-700' : ($dok->status_dokumen == 'perlu_perbaikan' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600') }}">
                                Status: {{ str_replace('_', ' ', $dok->status_dokumen) }}
                            </span>
                        </div>
                        <!-- Tombol Buka Pop-up PDF -->
                        <button type="button" onclick="bukaModalPdf('{{ url('/admin/dokumen/'.$dok->id.'/lihat') }}')" class="bg-blue-50 text-blue-600 text-sm font-bold hover:bg-blue-100 border border-blue-200 px-4 py-2 rounded flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Buka Pratinjau
                        </button>
                    </div>

                    <!-- Form Update Status Dokumen -->
                    <form action="{{ url('/admin/dokumen/'.$dok->id.'/update') }}" method="POST" class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-1/3">
                                <label class="text-xs font-bold text-gray-500 mb-2 block">Keputusan Dokumen</label>
                                <select name="status_dokumen" class="w-full p-2.5 text-sm border border-gray-300 rounded-md outline-none focus:border-blue-500 bg-white" onchange="document.getElementById('catatan-{{ $dok->id }}').style.display = this.value === 'perlu_perbaikan' ? 'block' : 'none'">
                                    <option value="menunggu" {{ $dok->status_dokumen == 'menunggu' ? 'selected' : '' }} disabled>Pilih Status...</option>
                                    <option value="lengkap" {{ $dok->status_dokumen == 'lengkap' ? 'selected' : '' }}>✅ Sesuai / Lengkap</option>
                                    <!-- VALUE DIUBAH MENJADI perlu_perbaikan -->
                                    <option value="perlu_perbaikan" {{ $dok->status_dokumen == 'perlu_perbaikan' ? 'selected' : '' }}>❌ Tolak / Revisi</option>
                                </select>
                            </div>
                            <!-- ID STYLE DIUBAH MENJADI perlu_perbaikan -->
                            <div class="w-full md:w-2/3" id="catatan-{{ $dok->id }}" style="display: {{ $dok->status_dokumen == 'perlu_perbaikan' ? 'block' : 'none' }};">
                                <label class="text-xs font-bold text-gray-500 mb-2 block">Catatan Revisi (Wajib jika ditolak)</label>
                                <input type="text" name="catatan_perbaikan" value="{{ $dok->catatan_perbaikan }}" placeholder="Contoh: Scan dokumen buram, mohon upload ulang..." class="w-full p-2.5 text-sm border border-gray-300 rounded-md outline-none focus:border-red-500">
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-gray-800 text-white px-5 py-2 rounded-md text-xs font-bold hover:bg-black transition shadow-sm">Simpan Keputusan Dokumen</button>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- Kolom Kanan: Keputusan Akhir Pengajuan -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg text-navy mb-2 flex items-center gap-2">
                    <span class="bg-navy text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span> 
                    Keputusan Akhir
                </h3>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-t-blue-600 border border-gray-200 sticky top-6">
                    <p class="text-sm text-gray-500 mb-5 leading-relaxed">Pastikan Anda telah memeriksa dan menyimpan status <b>semua dokumen</b> di samping sebelum mengirimkan keputusan akhir kepada mahasiswa.</p>
                    
                    <form action="{{ url('/admin/pengajuan/'.$pengajuan->id.'/update') }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Keputusan Akhir</label>
                            
                            <label class="flex items-start gap-3 mb-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 transition peer-checked:border-green-500">
                                <input type="radio" name="status_pengajuan" value="disetujui" required class="w-4 h-4 text-green-600 mt-0.5">
                                <div>
                                    <span class="font-bold text-green-700 text-sm block">Setujui Pengajuan</span>
                                    <span class="text-xs text-gray-500">Semua berkas lengkap dan sesuai.</span>
                                </div>
                            </label>
                            
                            <!-- VALUE DIUBAH MENJADI perlu_perbaikan -->
                            <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 transition">
                                <input type="radio" name="status_pengajuan" value="perlu_perbaikan" required class="w-4 h-4 text-red-600 mt-0.5">
                                <div>
                                    <span class="font-bold text-red-600 text-sm block">Kembalikan ke Mahasiswa</span>
                                    <span class="text-xs text-gray-500">Ada dokumen yang harus diperbaiki.</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pesan Riwayat untuk Mahasiswa</label>
                            <textarea name="deskripsi_riwayat" required rows="3" placeholder="Contoh: Berkas Anda telah disetujui, silakan tunggu jadwal sidang..." class="w-full p-3 text-sm border border-gray-300 rounded-lg outline-none focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold shadow-md hover:bg-blue-700 transition flex items-center justify-center gap-2">
                            Kirim Keputusan Akhir
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Pop-up PDF -->
    <div id="pdfModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
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
            document.body.style.overflow = 'hidden'; // Kunci scroll halaman utama
        }

        function tutupModalPdf() {
            document.getElementById('pdfModal').classList.add('hidden');
            document.getElementById('pdfFrame').src = ''; // Kosongkan iframe agar ringan
            document.body.style.overflow = 'auto'; // Buka kembali scroll
        }
    </script>
</body>
</html>