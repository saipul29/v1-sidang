<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased text-navy bg-pure-white min-h-screen flex">

    <!-- SISI KIRI: Branding -->
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

    <!-- SISI KANAN: Form Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md mx-auto">
            <div class="w-8 h-1 bg-orange mb-4"></div>
            <h2 class="text-3xl font-heading font-bold text-navy mb-2">Login</h2>
            <p class="text-gray-500 text-sm mb-8">Silakan masuk dengan akun Anda.</p>

            <!-- Tampilkan Error jika email/password salah -->
            @if($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="email" name="email" required placeholder="Masukkan Email" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" name="password" required placeholder="Masukkan Password" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-royal-start focus:ring-1 focus:ring-royal-start transition">
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="#" class="text-xs text-orange font-semibold hover:underline">Lupa password?</a>
                </div>

                <button type="submit" class="w-full bg-royal-start text-pure-white font-bold py-2.5 rounded-lg hover:bg-royal-end transition shadow-md">
                    Login
                </button>
            </form>

            <div class="mt-6 flex items-center justify-center">
                <div class="border-t border-gray-200 w-full"></div>
                <span class="px-3 text-xs text-gray-400">atau</span>
                <div class="border-t border-gray-200 w-full"></div>
            </div>

            <button class="mt-6 w-full flex items-center justify-center gap-2 border border-gray-300 py-2.5 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Lanjutkan dengan Google
            </button>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">Belum punya akun? <a href="{{ url('/daftar') }}" class="text-orange font-bold hover:underline">Daftar akun</a></p>
                <a href="{{ url('/') }}" class="inline-block mt-4 text-xs text-gray-400 hover:text-navy transition">&larr; Kembali ke halaman utama</a>
            </div>
        </div>
    </div>

</body>
</html>