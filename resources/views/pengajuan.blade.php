<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Sidang - Universitas Gunadarma</title>
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

            <!-- KONTEN UTAMA: Form Wizard dengan Alpine.js -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8" x-data="{ 
                step: 1, 
                jalur: '{{ old('jalur', 'transfer') }}', 
                paket: '{{ old('paket_sidang', 'komprehensif') }}',
                judul: '{{ old('judul_skripsi') }}',
                dosen1: '{{ old('dosen_pembimbing_1') }}',
                dosen2: '{{ old('dosen_pembimbing_2') }}',
                dosen_pi: '{{ old('dosen_pembimbing_pi') }}',
                materi: '{{ old('materi_komprehensif') }}',
                fileNameKrs: '', fileNameWorkshop: '', fileNameKursus: '', fileNameTambahan: '',
                
                // FUNGSI VALIDASI SEBELUM PINDAH STEP
                cekValidasi() {
                    if (this.step === 1) return true;
                    
                    if (this.step === 2) {
                        if (this.jalur === 'transfer' && this.dosen_pi.trim() === '') {
                            alert('Harap isi Nama Dosen Pembimbing PI (Khusus Jalur Transfer) sebelum melanjutkan.');
                            return false;
                        }
                        if (this.paket === 'skripsi') {
                            if (this.judul.trim() === '' || this.dosen1.trim() === '') {
                                alert('Harap lengkapi Judul Skripsi dan Dosen Pembimbing 1.');
                                return false;
                            }
                        }
                        if (this.paket === 'komprehensif') {
                            if (this.dosen_pi.trim() === '' || this.materi === '') {
                                alert('Harap lengkapi Nama Dosen Pembimbing PI dan pilih Materi Komprehensif.');
                                return false;
                            }
                        }
                        return true;
                    }

                    if (this.step === 3) {
                        if (this.fileNameKrs === '' || this.fileNameWorkshop === '' || this.fileNameKursus === '' || this.fileNameTambahan === '') {
                            // Pesan alert disesuaikan agar mencakup Manual Book
                            alert('Harap unggah seluruh dokumen PDF (KRS, Workshop, Kursus, dan Tambahan/Manual Book) sebelum melanjutkan.');
                            return false;
                        }
                        return true;
                    }
                    return true;
                }
            }">
                
                <div class="max-w-4xl mx-auto">
                    
                    @if($errors->any())
                        <div class="bg-red-50 text-red-600 border-l-4 border-red-500 p-4 rounded-lg shadow-sm mb-6">
                            <p class="font-bold text-sm mb-1">Gagal mengirim pengajuan!</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="bg-pure-white rounded-xl overflow-hidden mb-10 shadow-sm border border-gray-100">
                        <!-- Header Form -->
                        <div class="p-6 pb-2">
                            <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">PENDAFTARAN SIDANG SARJANA</p>
                            <h1 class="text-3xl font-heading font-bold text-navy mb-2">Pengajuan Sidang Sarjana</h1>
                            <p class="text-gray-500 text-sm mb-8">Lengkapi data berikut untuk mengajukan sidang sarjana.</p>
                            
                            <!-- Stepper Baru -->
                            <div class="flex items-center justify-between relative mb-4">
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-[3px] bg-gray-200 -z-10"></div>
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-[3px] bg-blue-700 -z-10 transition-all duration-300" :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>
                                
                                <!-- Step 1 -->
                                <div class="flex items-center gap-3 bg-pure-white px-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                                         :class="step > 1 ? 'bg-blue-700 text-white' : (step === 1 ? 'bg-blue-700 text-white' : 'bg-white border-2 border-gray-300 text-gray-400')">
                                        <template x-if="step > 1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                        <template x-if="step <= 1"><span>01</span></template>
                                    </div>
                                    <span class="text-sm font-bold hidden sm:block" :class="step >= 1 ? 'text-navy' : 'text-gray-400'">Data Mahasiswa</span>
                                </div>
                                <!-- Step 2 -->
                                <div class="flex items-center gap-3 bg-pure-white px-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                                         :class="step > 2 ? 'bg-blue-700 text-white' : (step === 2 ? 'bg-blue-700 text-white' : 'bg-white border-2 border-gray-300 text-gray-400')">
                                        <template x-if="step > 2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                        <template x-if="step <= 2"><span>02</span></template>
                                    </div>
                                    <span class="text-sm font-bold hidden sm:block" :class="step >= 2 ? 'text-navy' : 'text-gray-400'">Data Akademik</span>
                                </div>
                                <!-- Step 3 -->
                                <div class="flex items-center gap-3 bg-pure-white px-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                                         :class="step > 3 ? 'bg-blue-700 text-white' : (step === 3 ? 'bg-blue-700 text-white' : 'bg-white border-2 border-gray-300 text-gray-400')">
                                        <template x-if="step > 3"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                        <template x-if="step <= 3"><span>03</span></template>
                                    </div>
                                    <span class="text-sm font-bold hidden sm:block" :class="step >= 3 ? 'text-navy' : 'text-gray-400'">Upload Dokumen</span>
                                </div>
                                <!-- Step 4 -->
                                <div class="flex items-center gap-3 bg-pure-white px-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs transition-colors"
                                         :class="step > 4 ? 'bg-blue-700 text-white' : (step === 4 ? 'bg-blue-700 text-white' : 'bg-white border-2 border-gray-300 text-gray-400')">
                                        <template x-if="step > 4"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                        <template x-if="step <= 4"><span>04</span></template>
                                    </div>
                                    <span class="text-sm font-bold hidden sm:block" :class="step >= 4 ? 'text-navy' : 'text-gray-400'">Konfirmasi</span>
                                </div>
                            </div>
                        </div>

                        <div class="h-[1px] w-full bg-gray-100 mb-8"></div>

                        <form action="{{ url('/pengajuan/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="px-6 md:px-8 pb-8">
                                
                                @if(isset($statusPendaftaran) && $statusPendaftaran === 'tutup')
                                <div class="bg-orange/10 border border-orange/20 rounded-lg p-4 mb-8 flex items-center gap-3">
                                    <svg class="text-orange w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <span class="text-sm text-orange font-medium">Periode pendaftaran sedang ditutup.</span>
                                </div>
                                @endif
                                
                                <!-- LANGKAH 1 -->
                                <div x-show="step === 1" x-transition.opacity>
                                    <h2 class="text-xl font-bold text-navy mb-1">01 / Data Mahasiswa</h2>
                                    <p class="text-sm text-gray-500 mb-6">Pastikan informasi yang Anda isi sudah benar.</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none text-gray-700 bg-gray-50" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">NPM <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none text-gray-700 bg-gray-50" value="{{ Auth::user()->profil->npm }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">Email <span class="text-red-500">*</span></label>
                                            <input type="email" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none text-gray-700 bg-gray-50" value="{{ Auth::user()->email }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">WhatsApp <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none text-gray-700 bg-gray-50" value="{{ Auth::user()->profil->no_whatsapp }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- LANGKAH 2 -->
                                <div x-show="step === 2" x-cloak x-transition.opacity>
                                    <h2 class="text-xl font-bold text-navy mb-1">02 / Data Akademik</h2>
                                    <p class="text-sm text-gray-500 mb-6">Pastikan informasi yang Anda isi sudah benar.</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">Program Studi <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none bg-gray-50 text-gray-700" value="{{ Auth::user()->profil->program_studi }}" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">Fakultas <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none bg-gray-50 text-gray-700" value="{{ Auth::user()->profil->fakultas }}" readonly>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-bold text-navy mb-2">Angkatan <span class="text-red-500">*</span></label>
                                            <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none bg-gray-50 text-gray-700" value="{{ Auth::user()->profil->angkatan ?? '2023' }}" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-sm font-bold text-navy mb-3">Jalur Mahasiswa <span class="text-red-500">*</span></label>
                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <label class="flex items-center gap-3 border rounded-lg px-4 py-3.5 cursor-pointer hover:bg-blue-50 transition w-full" :class="jalur === 'reguler' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 bg-white'">
                                                <input type="radio" name="jalur" value="reguler" x-model="jalur" class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                                                <span class="text-sm text-navy font-medium">Reguler</span>
                                            </label>
                                            <label class="flex items-center gap-3 border rounded-lg px-4 py-3.5 cursor-pointer hover:bg-blue-50 transition w-full" :class="jalur === 'transfer' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 bg-white'">
                                                <input type="radio" name="jalur" value="transfer" x-model="jalur" class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                                                <span class="text-sm text-navy font-medium">Transfer</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div x-show="jalur === 'transfer'" x-transition class="mb-6">
                                        <label class="block text-sm font-bold text-navy mb-2">Nama Dosen Pembimbing Penulisan Ilmiah (beserta gelar) <span class="text-red-500">*</span></label>
                                        <input type="text" name="dosen_pembimbing_pi" x-model="dosen_pi" placeholder="Contoh: Dr. Naeli Umniati, ST., MMSI." class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-sm font-bold text-navy mb-3">Paket Sidang <span class="text-red-500">*</span></label>
                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <label class="flex items-center gap-3 border rounded-lg px-4 py-3.5 cursor-pointer hover:bg-blue-50 transition w-full" :class="paket === 'skripsi' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 bg-white'">
                                                <input type="radio" name="paket_sidang" value="skripsi" x-model="paket" class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                                                <span class="text-sm text-navy font-medium">Skripsi</span>
                                            </label>
                                            <label class="flex items-center gap-3 border rounded-lg px-4 py-3.5 cursor-pointer hover:bg-blue-50 transition w-full" :class="paket === 'komprehensif' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 bg-white'">
                                                <input type="radio" name="paket_sidang" value="komprehensif" x-model="paket" class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                                                <span class="text-sm text-navy font-medium">Komprehensif</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- AREA SKRIPSI -->
                                    <div x-show="paket === 'skripsi'" x-cloak x-transition class="space-y-6 mt-2">
                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-2">Judul Skripsi <span class="text-red-500">*</span></label>
                                            <textarea name="judul_skripsi" x-model="judul" rows="2" placeholder="Masukkan judul skripsi lengkap" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition"></textarea>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-sm font-bold text-navy mb-2">Dosen Pembimbing 1 <span class="text-red-500">*</span></label>
                                                <input type="text" name="dosen_pembimbing_1" x-model="dosen1" placeholder="Nama & gelar" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold text-navy mb-2">Dosen Pembimbing 2 <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                                <input type="text" name="dosen_pembimbing_2" x-model="dosen2" placeholder="Nama & gelar (jika ada)" class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- AREA KOMPREHENSIF -->
                                    <div x-show="paket === 'komprehensif'" x-cloak x-transition class="space-y-6 mt-2">
                                        <!-- Dosen PI dipindah ke atas khusus untuk komprehensif jika jalur reguler -->
                                        <div x-show="jalur !== 'transfer'">
                                            <label class="block text-sm font-bold text-navy mb-2">Nama Dosen Pembimbing Penulisan Ilmiah (beserta gelar) <span class="text-red-500">*</span></label>
                                            <input type="text" name="dosen_pembimbing_pi" x-model="dosen_pi" placeholder="Contoh: Dr. Naeli Umniati, ST., MMSI." class="w-full border border-gray-200 rounded-lg px-4 py-3 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-navy mb-3">Materi Sidang Komprehensif <span class="text-red-500">*</span></label>
                                            <div class="space-y-3">
                                                @foreach($opsiMateri ?? ['Disain dan Manajemen Jaringan Komputer, Sistem Keamanan Teknologi Informasi, Sistem Operasi', 'Analisis dan Perancangan Sistem Informasi, Interaksi Manusia dan Komputer, Sistem Basis Data 2', 'Pemrograman Berorientasi Objek, Struktur dan Organisasi Data, Testing dan Implementasi Sistem'] as $opsi)
                                                <label class="flex items-center gap-4 p-4 border rounded-xl cursor-pointer transition" :class="materi === '{{ $opsi }}' ? 'border-blue-600 bg-blue-50/30' : 'border-gray-200 bg-white hover:border-gray-300'">
                                                    <input type="radio" name="materi_komprehensif" value="{{ $opsi }}" x-model="materi" class="w-5 h-5 text-blue-600 focus:ring-blue-600 mt-0.5">
                                                    <span class="text-sm text-gray-700">{{ $opsi }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- LANGKAH 3: Upload Dokumen -->
                                <div x-show="step === 3" x-cloak x-transition.opacity>
                                    <h2 class="text-xl font-bold text-navy mb-1">03 / Upload Dokumen</h2>
                                    <p class="text-sm text-gray-500 mb-6">Format dalam bentuk PDF.</p>
                                    
                                    <div class="space-y-4">
                                        
                                        <!-- 1. KRS -->
                                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-white hover:border-gray-300 transition shadow-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0 border border-blue-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-navy">KRS <span class="text-red-500">*</span></h4>
                                                    <p class="text-xs" :class="fileNameKrs ? 'text-blue-600 font-bold' : 'text-gray-500'" x-text="fileNameKrs || 'Unggah KRS aktif PTA 2026/2027 semester berjalan.'"></p>
                                                </div>
                                            </div>
                                            <div class="relative overflow-hidden shrink-0">
                                                <button type="button" class="border border-blue-200 text-blue-600 bg-white hover:bg-blue-50 px-6 py-2 rounded-lg text-xs font-bold transition shadow-sm">Pilih PDF</button>
                                                <input type="file" name="file_krs" accept="application/pdf" @change="fileNameKrs = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <!-- 2. Workshop -->
                                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-white hover:border-gray-300 transition shadow-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0 border border-blue-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-navy">Workshop <span class="text-red-500">*</span></h4>
                                                    <p class="text-xs" :class="fileNameWorkshop ? 'text-blue-600 font-bold' : 'text-gray-500'" x-text="fileNameWorkshop || 'Unggah 1 sertifikat workshop.'"></p>
                                                </div>
                                            </div>
                                            <div class="relative overflow-hidden shrink-0">
                                                <button type="button" class="border border-blue-200 text-blue-600 bg-white hover:bg-blue-50 px-6 py-2 rounded-lg text-xs font-bold transition shadow-sm">Pilih PDF</button>
                                                <input type="file" name="file_workshop" accept="application/pdf" @change="fileNameWorkshop = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <!-- 3. Kursus -->
                                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-white hover:border-gray-300 transition shadow-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0 border border-blue-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-navy">Kursus <span class="text-red-500">*</span></h4>
                                                    <p class="text-xs" :class="fileNameKursus ? 'text-blue-600 font-bold' : 'text-gray-500'" x-text="fileNameKursus || 'Unggah seluruh sertifikat kursus dalam satu PDF.'"></p>
                                                </div>
                                            </div>
                                            <div class="relative overflow-hidden shrink-0">
                                                <button type="button" class="border border-blue-200 text-blue-600 bg-white hover:bg-blue-50 px-6 py-2 rounded-lg text-xs font-bold transition shadow-sm">Pilih PDF</button>
                                                <input type="file" name="file_kursus" accept="application/pdf" @change="fileNameKursus = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <!-- 4. Berkas Tambahan / Manual Book (Diubah secara dinamis) -->
                                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col sm:flex-row justify-between sm:items-center gap-4 bg-white hover:border-gray-300 transition shadow-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0 border border-blue-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-navy">
                                                        <span x-text="(jalur === 'reguler' && paket === 'skripsi') ? 'Manual Book' : 'Berkas Tambahan'"></span> 
                                                        <span class="text-red-500">*</span>
                                                    </h4>
                                                    <p class="text-xs max-w-lg" :class="fileNameTambahan ? 'text-blue-600 font-bold' : 'text-gray-500'" x-text="fileNameTambahan || ((jalur === 'reguler' && paket === 'skripsi') ? 'Unggah Manual Book dari aplikasi skripsi Anda dalam bentuk PDF.' : 'Khusus mahasiswa transfer, Gabungkan pengesahan penyetaraan PI yang sudah ditandatangani, ijazah, konversi nilai, dan transkrip D3 dalam satu PDF.')"></p>
                                                </div>
                                            </div>
                                            <div class="relative overflow-hidden shrink-0">
                                                <button type="button" class="border border-blue-200 text-blue-600 bg-white hover:bg-blue-50 px-6 py-2 rounded-lg text-xs font-bold transition shadow-sm">Pilih PDF</button>
                                                <input type="file" name="file_tambahan" accept="application/pdf" @change="fileNameTambahan = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- LANGKAH 4: Konfirmasi -->
                                <div x-show="step === 4" x-cloak x-transition.opacity>
                                    <h2 class="text-xl font-bold text-navy mb-1">04 / Konfirmasi</h2>
                                    <p class="text-sm text-gray-500 mb-6">Pastikan informasi yang Anda isi sudah benar.</p>
                                    
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-4 text-sm">
                                            
                                            <!-- Data Statis -->
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Nama</p>
                                                <p class="font-medium text-navy">{{ Auth::user()->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">NPM</p>
                                                <p class="font-medium text-navy">{{ Auth::user()->profil->npm }}</p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Email</p>
                                                <p class="font-medium text-navy">{{ Auth::user()->email }}</p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">WhatsApp</p>
                                                <p class="font-medium text-navy">{{ Auth::user()->profil->no_whatsapp }}</p>
                                            </div>
                                            
                                            <div class="col-span-1 sm:col-span-2 my-2 border-b border-gray-200"></div>

                                            <!-- Data Dinamis -->
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Program Studi</p>
                                                <p class="font-medium text-navy">{{ Auth::user()->profil->program_studi }}</p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Jalur</p>
                                                <p class="font-medium text-navy capitalize" x-text="jalur"></p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Paket Sidang</p>
                                                <p class="font-medium text-navy capitalize" x-text="paket"></p>
                                            </div>
                                            <div>
                                                <p class="text-orange text-xs font-bold uppercase mb-1">Angkatan</p>
                                                <p class="font-medium text-navy capitalize">{{ Auth::user()->profil->angkatan ?? '2023' }}</p>
                                            </div>

                                            <!-- Preview Dinamis Skripsi -->
                                            <template x-if="paket === 'skripsi'">
                                                <div class="col-span-1 sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-y-5 mt-1">
                                                    <div class="col-span-1 sm:col-span-2">
                                                        <p class="text-orange text-xs font-bold uppercase mb-1">Judul Skripsi</p>
                                                        <p class="font-medium text-navy italic" x-text="judul ? judul : '-'"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-orange text-xs font-bold uppercase mb-1">Dosen Pembimbing 1</p>
                                                        <p class="font-medium text-navy" x-text="dosen1 ? dosen1 : '-'"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-orange text-xs font-bold uppercase mb-1">Dosen Pembimbing 2</p>
                                                        <p class="font-medium text-navy" x-text="dosen2 ? dosen2 : '-'"></p>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Preview Dinamis Komprehensif -->
                                            <template x-if="paket === 'komprehensif'">
                                                <div class="col-span-1 sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-y-5 mt-1">
                                                    <div>
                                                        <p class="text-orange text-xs font-bold uppercase mb-1">Dosen Pembimbing PI</p>
                                                        <p class="font-medium text-navy" x-text="dosen_pi ? dosen_pi : '-'"></p>
                                                    </div>
                                                    <div class="col-span-1 sm:col-span-2">
                                                        <p class="text-orange text-xs font-bold uppercase mb-1">Materi</p>
                                                        <p class="font-medium text-navy leading-relaxed" x-text="materi ? materi : '-'"></p>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </div>

                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" required class="mt-1 text-blue-600 focus:ring-blue-600 rounded w-4 h-4 border-gray-300">
                                        <span class="text-sm font-medium text-gray-700 leading-relaxed">
                                            Saya menyatakan data dan dokumen yang diajukan benar.
                                        </span>
                                    </label>
                                </div>

                            </div>

                            <!-- Footer Tombol -->
                            <div class="border-t border-gray-100 p-6 pt-8 flex justify-between items-center bg-white">
                                <button type="button" x-show="step > 1" x-cloak @click="step--" class="px-6 py-2.5 text-sm font-bold text-gray-600 border border-gray-200 bg-white hover:bg-gray-50 rounded-lg transition flex items-center gap-2">
                                    &larr; Sebelumnya
                                </button>
                                <div x-show="step === 1"></div>
                                
                                <span class="text-sm text-gray-400 font-medium hidden sm:block">Langkah <span x-text="step"></span> dari 4</span>

                                <!-- DI SINI FUNGSI CEK VALIDASI DIPANGGIL -->
                                <button type="button" x-show="step < 4" @click="if(cekValidasi()) step++" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg shadow-sm hover:bg-blue-700 transition flex items-center gap-2">
                                    Selanjutnya &rarr;
                                </button>
                                
                                <button type="submit" 
                                        x-show="step === 4" x-cloak
                                        {{ isset($statusPendaftaran) && $statusPendaftaran === 'tutup' ? 'disabled' : '' }}
                                        class="px-6 py-2.5 {{ isset($statusPendaftaran) && $statusPendaftaran === 'tutup' ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }} text-white text-sm font-bold rounded-lg shadow-md transition flex items-center gap-2">
                                    Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>