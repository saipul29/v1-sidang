<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased text-navy bg-pure-white min-h-screen flex">

    <!-- SISI KIRI: Branding (Sama persis dengan Login) -->
    <div class="hidden lg:flex lg:w-1/2 bg-navy p-12 flex-col justify-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full border-[40px] border-pure-white"></div>
            <div class="absolute bottom-12 -right-12 w-64 h-64 rounded-full border-[20px] border-pure-white"></div>
        </div>

        <div class="relative z-10 max-w-lg mx-auto">
            <div class="flex items-center gap-3 mb-16">
                <div class="w-10 h-10 bg-pure-white rounded-full flex items-center justify-center font-bold text-navy">UG</div>
                <div class="text-pure-white font-heading font-bold leading-tight">
                    SIDANG SARJANA <br> <span class="text-[10px] font-normal tracking-wider">UNIVERSITAS GUNADARMA</span>
                </div>
            </div>
            <div class="w-12 h-1 bg-orange mb-6"></div>
            <h1 class="text-4xl lg:text-5xl font-heading font-bold text-pure-white mb-6 leading-tight">
                Sistem Informasi Pengajuan Sidang Sarjana
            </h1>
            <p class="text-pure-white/80 text-lg mb-10 leading-relaxed">
                Kelola pengajuan sidang sarjana Anda dengan mudah, cepat, dan transparan.
            </p>
            <ul class="space-y-4 text-pure-white/90">
                <li class="flex items-center gap-3"><svg class="w-5 h-5 text-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Ajukan sidang dan unggah berkas secara online</li>
                <li class="flex items-center gap-3"><svg class="w-5 h-5 text-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Pantau status pemeriksaan kapan saja</li>
                <li class="flex items-center gap-3"><svg class="w-5 h-5 text-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Perbaiki dokumen langsung dari catatan operator</li>
            </ul>
        </div>
    </div>

    <!-- SISI KANAN: Form Daftar -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md mx-auto">
            <div class="w-8 h-1 bg-orange mb-4"></div>
            <h2 class="text-3xl font-heading font-bold text-navy mb-2">Daftar Akun</h2>
            <p class="text-gray-500 text-sm mb-8">Data ini otomatis mengisi profil Anda.</p>

            <form action="{{ url('/daftar') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Nama sesuai KTM" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="no_whatsapp" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <!-- name harus 'password_confirmation' agar cocok dengan validasi Laravel -->
                    <input type="password" name="password_confirmation" required placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                </div>

                <button type="submit" class="w-full bg-royal-start text-pure-white font-bold py-2.5 rounded-lg hover:bg-royal-end transition shadow-md mt-4">
                    Daftar
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ url('/login') }}" class="text-orange font-bold hover:underline">Login</a></p>
                <a href="{{ url('/') }}" class="inline-block mt-4 text-xs text-gray-400 hover:text-navy transition">&larr; Kembali ke halaman utama</a>
            </div>
        </div>
    </div>

</body>
</html>