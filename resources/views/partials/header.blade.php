<header class="h-16 bg-pure-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-navy focus:outline-none hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </button>
    </div>
    
    <div class="flex items-center gap-4">
        <!-- Notification -->
        <div class="relative">
            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" class="text-gray-400 hover:text-navy relative mt-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-orange rounded-full border-2 border-pure-white"></span>
            </button>
            
            <!-- Dropdown Notifikasi -->
            <div x-show="notifOpen" style="display: none;" class="absolute right-0 mt-2 w-80 bg-pure-white rounded-lg shadow-xl border border-gray-100 z-50">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-sm">Notifikasi</h3>
                    <button class="text-gray-400 hover:text-navy">&times;</button>
                </div>
                <div class="p-4 text-sm space-y-3">
                    <div class="flex gap-3">
                        <div class="w-2 h-2 mt-1.5 bg-orange rounded-full flex-shrink-0"></div>
                        <div>
                            <p class="font-semibold text-navy text-xs">Berkas perlu diperbaiki</p>
                            <p class="text-gray-500 text-xs mt-1">SPU-2026-0002 • Mohon perbaiki dokumen yang ditandai agar verifikasi dapat dilanjutkan.</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="block text-center text-xs text-royal-start font-medium py-3 border-t border-gray-100 hover:bg-gray-50">Lihat semua pengajuan</a>
            </div>
        </div>

        <div class="w-px h-6 bg-gray-200"></div>

        <!-- Profil User -->
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <!-- Mengambil nama user yang sedang login -->
                <p class="text-sm font-bold text-navy">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">Mahasiswa</p>
            </div>
            
            <!-- Mengambil huruf pertama dari nama untuk Avatar -->
            <div class="w-10 h-10 rounded-full bg-soft-bg text-royal-start flex items-center justify-center font-bold border border-gray-200 cursor-pointer">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </div>
</header>