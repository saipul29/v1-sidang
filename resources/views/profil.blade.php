<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - Universitas Gunadarma</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-body text-navy antialiased overflow-hidden" x-data="{ sidebarOpen: true, notifOpen: false }">

    <div class="flex h-screen w-full">
        
        <!-- Panggil Partials Sidebar -->
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <!-- Panggil Partials Header -->
            @include('partials.header')

            <!-- KONTEN UTAMA: Mode View & Edit dengan Alpine.js -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8" x-data="{ isEditing: false }">
                
                <!-- Notifikasi Berhasil -->
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition.duration.500ms
                         x-init="setTimeout(() => show = false, 5000)" 
                         class="mb-6 max-w-4xl flex items-center justify-between bg-green-50 text-green-700 border-l-4 border-green-500 p-4 rounded shadow-sm">
                        
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-500 hover:text-green-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                <div class="max-w-4xl bg-pure-white border border-gray-200 rounded-xl shadow-sm overflow-hidden p-6 md:p-8">
                    
                    <!-- Header -->
                    <div class="mb-8">
                        <p class="text-royal-start text-xs font-bold uppercase tracking-wider mb-1">AKUN MAHASISWA</p>
                        <h1 class="text-2xl font-heading font-bold text-navy mb-2">Profil Mahasiswa</h1>
                        <p class="text-sm text-gray-500">Data pribadi dan akademik Anda.</p>
                    </div>

                    <hr class="border-gray-100 mb-8">

                    <!-- Info Profil & Avatar -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-soft-bg text-royal-start rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold uppercase">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-navy">{{ $user->name }}</h2>
                                <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Tombol Edit (Hanya tampil saat mode view) -->
                        <button type="button" x-show="!isEditing" @click="isEditing = true" class="px-5 py-2 text-sm font-semibold text-royal-start border border-royal-start rounded-lg hover:bg-royal-start hover:text-pure-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profil
                        </button>
                    </div>

                    <!-- Bungkus dengan tag Form -->
                    <form action="{{ url('/profil/update') }}" method="POST">
                        @csrf
                        
                        <!-- Form Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- NPM -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">NPM</label>
                                <input type="text" name="npm" value="{{ $user->profil->npm == '-' ? '' : $user->profil->npm }}" required placeholder="Masukkan NPM Anda"
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="no_whatsapp" value="{{ $user->profil->no_whatsapp }}" required
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- Program Studi -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">Program Studi</label>
                                <input type="text" name="program_studi" value="{{ $user->profil->program_studi == '-' ? '' : $user->profil->program_studi }}" required placeholder="Contoh: Sistem Informasi"
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- Fakultas -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">Fakultas</label>
                                <input type="text" name="fakultas" value="{{ $user->profil->fakultas == '-' ? '' : $user->profil->fakultas }}" required placeholder="Contoh: Ilmu Komputer dan Teknologi Informasi"
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- Angkatan -->
                            <div>
                                <label class="block text-sm font-semibold text-orange mb-2">Angkatan</label>
                                <input type="number" name="angkatan" value="{{ $user->profil->angkatan }}" required
                                       :readonly="!isEditing" 
                                       :class="isEditing ? 'bg-white border-gray-300 focus:border-royal-start focus:ring-1 focus:ring-royal-start' : 'bg-gray-100 border-transparent text-gray-600'" 
                                       class="w-full border rounded-lg px-4 py-2.5 outline-none transition-colors">
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-orange mb-2">Email (Tidak dapat diubah)</label>
                                <input type="email" value="{{ $user->email }}" readonly
                                       class="w-full bg-gray-100 border-transparent text-gray-500 border rounded-lg px-4 py-2.5 outline-none cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Tombol Aksi (Hanya tampil saat mode edit) -->
                        <div x-show="isEditing" style="display: none;" x-transition class="mt-8 flex gap-3 pt-6 border-t border-gray-100">
                            <!-- Ubah menjadi type="submit" untuk mengirim form -->
                            <button type="submit" class="px-6 py-2.5 bg-royal-start text-pure-white text-sm font-bold rounded-lg shadow-md hover:bg-royal-end transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Profil
                            </button>
                            <button type="button" @click="isEditing = false" class="px-6 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-200 transition border border-gray-200">
                                Batal
                            </button>
                        </div>

                    </form> <!-- Penutup Form -->

                    <div class="mt-12 text-xs text-gray-400">
                        SIDANG SARJANA • UNIVERSITAS GUNADARMA
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html>