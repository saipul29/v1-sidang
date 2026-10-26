<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Berdasarkan Kategori - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-navy font-body antialiased min-h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center font-bold text-white">UG</div>
            <div class="text-navy font-heading font-bold leading-tight">
                SIDANG <br> <span class="text-[10px] font-normal tracking-wide">UNIVERSITAS GUNADARMA</span>
            </div>
        </a>
        <a href="{{ url('/login') }}" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded hover:bg-blue-700 transition">Masuk</a>
    </nav>

    <main class="flex-1 container mx-auto px-6 py-12 max-w-6xl">
        <a href="{{ url('/') }}" class="text-blue-600 hover:underline text-sm font-semibold inline-flex items-center gap-2 mb-6">
            &larr; Kembali ke halaman utama
        </a>

        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">STATUS PEMBERKASAN</p>
        <h1 class="text-4xl font-extrabold text-navy mb-10">Cek berdasarkan kategori.</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kartu 1 -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-full border-2 border-green-500 text-green-500 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">KATEGORI 1</p>
                <h3 class="text-xl font-bold text-navy mb-3">Berkas lengkap</h3>
                <p class="text-gray-500 text-sm mb-8 flex-1">Mahasiswa sudah berhasil melengkapi berkas.</p>
                <a href="{{ url('/kategori/1') }}" class="inline-flex items-center gap-2 border border-gray-200 text-navy hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition self-start">
                    Lihat kategori &rarr;
                </a>
            </div>

            <!-- Kartu 2 -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-full text-red-500 flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path></svg>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">KATEGORI 2</p>
                <h3 class="text-xl font-bold text-navy mb-3">Kendala Pembayaran / Kendala Berkas</h3>
                <p class="text-gray-500 text-sm mb-8 flex-1">Berkas atau pembayaran perlu dilengkapi.</p>
                <a href="{{ url('/kategori/2') }}" class="inline-flex items-center gap-2 border border-gray-200 text-navy hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition self-start">
                    Lihat kategori &rarr;
                </a>
            </div>

            <!-- Kartu 3 -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-full border-2 border-blue-500 text-blue-500 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">KATEGORI 3</p>
                <h3 class="text-xl font-bold text-navy mb-3">Kendala Nilai</h3>
                <p class="text-gray-500 text-sm mb-8 flex-1">Nilai belum tersedia atau perlu diperbaiki.</p>
                <a href="{{ url('/kategori/3') }}" class="inline-flex items-center gap-2 border border-gray-200 text-navy hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition self-start">
                    Lihat kategori &rarr;
                </a>
            </div>
        </div>
    </main>

</body>
</html>