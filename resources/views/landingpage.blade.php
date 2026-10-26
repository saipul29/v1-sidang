<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Sidang Sarjana - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pure-white text-navy font-body antialiased">

    <!-- Hero Section & Navbar Background -->
    <div class="bg-gradient-to-b from-navy to-royal-end pb-32 relative">
        <!-- Navbar -->
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-pure-white rounded-full flex items-center justify-center font-bold text-navy">UG</div>
                <div class="text-pure-white font-heading font-bold leading-tight">
                    SIDANG <br> <span class="text-xs font-normal">UNIVERSITAS GUNADARMA</span>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ url('/daftar') }}" class="px-5 py-2 text-pure-white border border-pure-white/30 rounded-lg hover:bg-pure-white/10 transition">Daftar</a>
                <a href="{{ url('/login') }}" class="px-5 py-2 bg-orange text-pure-white font-semibold rounded-lg hover:bg-orange/90 transition shadow-lg">Masuk</a>
            </div>
        </nav>

        <!-- Hero Content -->
        <header class="container mx-auto px-6 pt-16 pb-24 text-pure-white">
            <p class="text-orange font-semibold tracking-wider text-sm mb-4 uppercase">Layanan Akademik - Sidang Sarjana</p>
            <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6">Pendaftaran <br> <span class="text-orange">Sidang Sarjana.</span></h1>
            <p class="max-w-xl text-pure-white/80 mb-8 font-light text-lg">
                Ajukan berkas sidang, lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum
            </p>
            <button class="bg-orange text-pure-white px-6 py-3 rounded-lg font-semibold hover:bg-orange/90 transition flex items-center gap-2 shadow-lg">
                Masuk dengan Google <span>&rarr;</span>
            </button>
        </header>
    </div>

    <!-- Floating Search Box -->
    <section class="container mx-auto px-6 -mt-24 relative z-10">
        <div class="bg-pure-white rounded-2xl shadow-xl p-8 max-w-2xl mx-auto border border-soft-bg flex flex-col items-center relative">
            <div class="absolute -top-5 bg-orange text-pure-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h2 class="text-xl font-heading font-bold text-navy mt-4 mb-6">Cek Status Pemberkasan</h2>
            
            <!-- UPDATE: Dibungkus form mengarah ke /cek-status -->
            <form action="{{ url('/cek-status') }}" method="GET" class="flex w-full gap-2 border border-gray-300 rounded-lg p-1">
                <input type="text" name="search" placeholder="Masukkan NPM atau nama lengkap" required class="w-full px-4 py-2 outline-none rounded-lg text-navy">
                <button type="submit" class="bg-orange text-pure-white p-3 px-5 rounded-lg hover:bg-orange/90 transition">
                    &rarr;
                </button>
            </form>
            
            <!-- UPDATE: Link mengarah ke /kategori -->
            <a href="{{ url('/kategori') }}" class="text-royal-start text-sm mt-4 hover:underline font-medium">Cek berdasarkan kategori</a>
        </div>
    </section>

    <!-- Alur Pengajuan Section -->
    <section class="container mx-auto px-6 py-20 max-w-4xl">
        <div class="text-center mb-10">
            <p class="text-orange text-sm font-semibold uppercase mb-2">LANGKAH PENDAFTARAN</p>
            <h2 class="text-3xl font-heading font-bold text-navy">Alur Pengajuan</h2>
        </div>

        <div class="space-y-4">
            <!-- Item Alur 1 -->
            <details class="group bg-pure-white border border-soft-bg rounded-xl shadow-sm open:shadow-md transition">
                <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-6 font-heading text-navy">
                    <div class="flex items-center gap-4">
                        <span class="bg-royal-start text-pure-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                        Daftar dan masuk dengan Akun Google & lengkapi profil
                    </div>
                    <span class="transition group-open:rotate-180">&darr;</span>
                </summary>
                <div class="text-gray-600 px-6 pb-6 pt-2 ml-12 text-sm leading-relaxed">
                    Masuk menggunakan akun google yang telah terdaftar, lalu periksa nama, email, dan nomor telepon pada profil Anda.
                </div>
            </details>
            
            <!-- Item Alur 2 -->
            <details class="group bg-pure-white border border-soft-bg rounded-xl shadow-sm open:shadow-md transition">
                <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-6 font-heading text-navy">
                    <div class="flex items-center gap-4">
                        <span class="bg-royal-start text-pure-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                        Isi formulir & unggah PDF
                    </div>
                    <span class="transition group-open:rotate-180">&darr;</span>
                </summary>
                <div class="text-gray-600 px-6 pb-6 pt-2 ml-12 text-sm leading-relaxed">
                    Lengkapi data mahasiswa dan akademik, pilih jalur Reguler atau Transfer, unggah berkas wajib, lalu pilih paket Skripsi atau Komprehensif. Periksa kembali data sebelum mengirim pengajuan.
                </div>
            </details>

            <!-- Item Alur 3 -->
            <details class="group bg-pure-white border border-soft-bg rounded-xl shadow-sm open:shadow-md transition">
                <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-6 font-heading text-navy">
                    <div class="flex items-center gap-4">
                        <span class="bg-royal-start text-pure-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                        Petugas memeriksa berkas
                    </div>
                    <span class="transition group-open:rotate-180">&darr;</span>
                </summary>
                <div class="text-gray-600 px-6 pb-6 pt-2 ml-12 text-sm leading-relaxed">
                    Pengajuan yang berhasil dikirim berstatus Menunggu. Petugas akan memeriksa data dan kelengkapan dokumen Anda.
                </div>
            </details>

            <!-- Item Alur 4 -->
            <details class="group bg-pure-white border border-soft-bg rounded-xl shadow-sm open:shadow-md transition">
                <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-6 font-heading text-navy">
                    <div class="flex items-center gap-4">
                        <span class="bg-royal-start text-pure-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">4</span>
                        Pantau hasil & catatan pemeriksaan
                    </div>
                    <span class="transition group-open:rotate-180">&darr;</span>
                </summary>
                <div class="text-gray-600 px-6 pb-6 pt-2 ml-12 text-sm leading-relaxed">
                    Buka Status Pengajuan untuk melihat informasi, dokumen, dan riwayat. Jika diminta perbaikan, ikuti catatan petugas dan unggah ulang berkas terkait.
                </div>
            </details>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mx-auto px-6 py-10 max-w-4xl">
        <div class="text-center mb-10">
            <p class="text-orange text-sm font-semibold uppercase mb-2">PERTANYAAN UMUM</p>
            <h2 class="text-3xl font-heading font-bold text-navy">FAQ Pendaftaran Sidang</h2>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Apa saja berkas yang perlu diunggah?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Unggah KRS aktif semester berjalan, unggah 1 sertifikat workshop, dan unggah seluruh sertifikat kursus dalam satu PDF.
                </div>
            </details>

            <!-- FAQ 2 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Apa persyaratan mahasiswa transfer?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Khusus mahasiswa transfer mengisi nama dosen pembimbing Penulisan Ilmiah beserta gelar.
                </div>
            </details>

            <!-- FAQ 3 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Apa pilihan paket sidang?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Paket yang tersedia adalah Skripsi dan Komprehensif. Untuk Komprehensif, mahasiswa wajib memilih materi sidang yang disediakan operator.
                </div>
            </details>

            <!-- FAQ 4 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Apa arti status pengajuan?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    <span class="font-medium text-navy">Menunggu:</span> belum diperiksa atau terdapat kendala nilai yang belum terekap.<br>
                    <span class="font-medium text-navy">Proses:</span> berkas sedang diperiksa.<br>
                    <span class="font-medium text-navy">Perbaikan:</span> mahasiswa perlu melengkapi atau memperbaiki berkas.<br>
                    <span class="font-medium text-navy">Selesai:</span> berkas telah diterima.
                </div>
            </details>

            <!-- FAQ 5 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Bagaimana jika ada berkas yang salah?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Buka Status Pengajuan, pilih Dokumen, lalu periksa catatan petugas dan melakukan unggahan ulang berkas yang ditandai Perlu perbaikan.
                </div>
            </details>

            <!-- FAQ 6 -->
            <details class="group border border-soft-bg rounded-xl shadow-sm p-5 open:bg-soft-bg/20 transition">
                <summary class="flex justify-between items-center font-semibold cursor-pointer list-none text-navy">
                    Format dan ukuran berkas apa yang diterima?
                    <span class="transition group-open:rotate-180 text-orange">&darr;</span>
                </summary>
                <div class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Gabungkan sertifikat kursus dan berkas tambahan masing-masing dalam satu PDF.
                </div>
            </details>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-soft-bg bg-pure-white pt-16 pb-8 mt-20">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Kolom 1: Info & Medsos -->
            <div class="col-span-1 md:pr-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-navy rounded-full text-pure-white flex items-center justify-center text-xs font-bold">UG</div>
                    <div class="text-navy font-heading font-bold leading-tight">SIDANG <br> <span class="text-[10px] font-normal">UNIVERSITAS GUNADARMA</span></div>
                </div>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">Sistem Informasi Pendaftaran dan Pengelolaan Sidang Sarjana Universitas Gunadarma yang terintegrasi, transparan, dan terpercaya untuk seluruh sivitas akademika.</p>
                <h5 class="text-xs font-bold text-gray-400 mb-3 tracking-wider">MEDIA SOSIAL RESMI</h5>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:text-orange hover:bg-orange/10 transition">
                        <!-- Ikon Instagram -->
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
            
            <!-- Kolom 2: Layanan -->
            <div>
                <h4 class="font-bold text-navy mb-4 border-l-2 border-orange pl-2 text-sm tracking-wider">LAYANAN</h4>
                <ul class="text-sm text-gray-500 space-y-3">
                    <li><a href="#" class="hover:text-orange transition">Pendaftaran Sidang</a></li>
                    <li><a href="#" class="hover:text-orange transition">Cek Status Berkas</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Tautan -->
            <div>
                <h4 class="font-bold text-navy mb-4 border-l-2 border-royal-start pl-2 text-sm tracking-wider">TAUTAN</h4>
                <ul class="text-sm text-gray-500 space-y-3">
                    <li><a href="#" class="hover:text-orange transition">Studentsite</a></li>
                    <li><a href="#" class="hover:text-orange transition">e-sert.gunadarma</a></li>
                    <li><a href="#" class="hover:text-orange transition">BAAK Online</a></li>
                    <li><a href="#" class="hover:text-orange transition">Perpustakaan Gunadarma</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Kontak Kami -->
            <div>
                <h4 class="font-bold text-navy mb-4 border-l-2 border-orange pl-2 text-sm tracking-wider">KONTAK KAMI</h4>
                <ul class="text-sm text-gray-500 space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-orange flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="leading-relaxed">Kampus D: Jl. Margonda Raya No. 100, Pondok Cina, Depok 16424</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>sidang@gunadarma.ac.id</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>(021) ...</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="container mx-auto px-6 border-t border-soft-bg pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
            <p>&copy; 2026 Universitas Gunadarma.</p>
            <div class="flex flex-wrap justify-center items-center gap-3 mt-4 md:mt-0">
                <a href="#" class="hover:text-navy transition">Kebijakan Privasi</a>
                <span>·</span>
                <a href="#" class="hover:text-navy transition">Syarat & Ketentuan</a>
                <span>·</span>
                <a href="#" class="hover:text-navy transition">Panduan Sidang</a>
                <span>·</span>
                <a href="#" class="hover:text-navy transition">Bantuan Teknis</a>
            </div>
        </div>
    </footer>

</body>
</html>