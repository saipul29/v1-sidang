<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-navy font-body antialiased min-h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center font-bold text-white">UG</div>
            <div class="text-navy font-heading font-bold leading-tight">
                SIDANG <br> <span class="text-[10px] font-normal tracking-wide">UNIVERSITAS GUNADARMA</span>
            </div>
        </a>
        <a href="{{ url('/login') }}" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded hover:bg-blue-700 transition">Masuk</a>
    </nav>

    <main class="flex-1 container mx-auto px-6 py-12 max-w-5xl">
        
        <a href="{{ isset($tipe) ? url('/kategori') : url('/') }}" class="text-blue-600 hover:underline text-sm font-semibold inline-flex items-center gap-2 mb-8">
            &larr; {{ isset($tipe) ? 'Semua kategori' : 'Kembali ke halaman utama' }}
        </a>

        <!-- Header Dinamis: Apakah ini kategori spesifik atau pencarian global? -->
        @if(isset($kategoriTitle))
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">KATEGORI {{ $tipe }}</p>
            <h1 class="text-4xl font-extrabold text-navy mb-2">{{ $kategoriTitle }}</h1>
            <p class="text-gray-500 text-base mb-8">{{ $kategoriDesc }}</p>
            
            <form action="{{ url('/kategori/'.$tipe) }}" method="GET" class="flex w-full md:w-2/3 gap-2 mb-10">
                <input type="text" name="search" value="{{ $search }}" placeholder="Masukkan NPM atau nama lengkap" class="w-full px-4 py-3 border border-gray-300 outline-none rounded-lg text-navy focus:border-blue-500">
                <button type="submit" class="bg-orange text-white px-6 rounded-lg hover:bg-orange/90 transition shadow-sm font-bold">
                    &rarr;
                </button>
            </form>
        @else
            <h1 class="text-4xl font-extrabold text-navy mb-8">Cek Status Pemberkasan</h1>
            
            <form action="{{ url('/cek-status') }}" method="GET" class="flex w-full md:w-2/3 mx-auto gap-2 mb-10">
                <input type="text" name="search" value="{{ $search }}" placeholder="Masukkan NPM atau nama lengkap" class="w-full px-4 py-3 border border-gray-300 outline-none rounded-lg text-navy focus:border-blue-500">
                <button type="submit" class="bg-orange text-white px-6 rounded-lg hover:bg-orange/90 transition shadow-sm font-bold">
                    &rarr;
                </button>
            </form>
        @endif

        <div class="mt-4">
            <h3 class="font-extrabold text-navy text-lg mb-4">{{ $pengajuans->count() }} mahasiswa</h3>
            
            <div class="overflow-x-auto rounded-t-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-50/50 text-navy text-xs font-bold uppercase tracking-wider border-y border-gray-100">
                            <th class="p-4 py-5 whitespace-nowrap w-1/4 text-center">NPM</th>
                            <th class="p-4 py-5 whitespace-nowrap w-1/2">Nama Mahasiswa</th>
                            <th class="p-4 py-5 whitespace-nowrap w-1/4">Jenis Pengajuan</th>
                        </tr>
                    </thead>
                    
                    @if($pengajuans->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="3" class="py-20 text-center">
                                <h3 class="text-2xl font-bold text-navy mb-2">Belum ada hasil</h3>
                                <p class="text-gray-500">Belum ada mahasiswa dalam {{ isset($tipe) ? 'kategori' : 'pencarian' }} ini.</p>
                            </td>
                        </tr>
                    </tbody>
                    @else
                    <tbody class="divide-y divide-gray-100 text-sm bg-white">
                        @foreach($pengajuans as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 py-5 text-center font-bold text-orange-500">{{ $item->user->profil->npm ?? '-' }}</td>
                            <td class="p-4 py-5 font-bold text-orange-500">{{ $item->user->name }}</td>
                            <td class="p-4 py-5 font-bold text-blue-600">Pengajuan {{ $item->paket_sidang == 'skripsi' ? 'Sidang' : 'Kompre' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>

    </main>

</body>
</html>