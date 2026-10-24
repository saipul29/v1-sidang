<aside class="bg-navy text-pure-white flex flex-col transition-all duration-300" :class="sidebarOpen ? 'w-64' : 'w-20'">
    <!-- Logo Area -->
    <div class="h-16 flex items-center justify-center border-b border-white/10 px-4 relative">
        <div class="flex items-center gap-3 w-full" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
            <div class="w-8 h-8 bg-pure-white rounded-full flex items-center justify-center font-bold text-navy text-xs flex-shrink-0">UG</div>
            <div x-show="sidebarOpen" class="font-heading font-bold text-sm leading-tight whitespace-nowrap">
                Sidang Sarjana <br> <span class="text-[10px] font-normal opacity-80">UNIVERSITAS GUNADARMA</span>
            </div>
        </div>
        <!-- Tombol Collapse/Expand -->
        <button @click="sidebarOpen = !sidebarOpen" class="absolute -right-3 top-5 bg-pure-white text-navy rounded-full p-1 shadow-md hover:bg-gray-200">
            <svg class="w-4 h-4 transition-transform duration-300" :class="sidebarOpen ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>

    <!-- Menu Utama -->
    <div class="flex-1 overflow-y-auto py-4 flex flex-col gap-1">
        <p x-show="sidebarOpen" class="px-6 text-xs text-pure-white/50 font-semibold mb-2 transition-opacity">PORTAL MAHASISWA</p>
        
        <!-- Link Dashboard -->
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('dashboard') ? 'bg-royal-start border-l-4 border-orange text-pure-white' : 'text-pure-white/70 hover:bg-pure-white/10 hover:text-pure-white border-l-4 border-transparent' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarOpen" class="text-sm font-medium whitespace-nowrap">Dashboard</span>
        </a>

        <!-- Link Pengajuan Sidang -->
        <a href="{{ url('/pengajuan') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('pengajuan') ? 'bg-royal-start border-l-4 border-orange text-pure-white' : 'text-pure-white/70 hover:bg-pure-white/10 hover:text-pure-white border-l-4 border-transparent' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span x-show="sidebarOpen" class="text-sm font-medium whitespace-nowrap">Pengajuan Sidang</span>
        </a>

        <!-- Link Status Pengajuan -->
        <a href="{{ url('/statuspengajuan') }}" class="flex items-center gap-3 px-6 py-3 transition {{ request()->is('statuspengajuan') ? 'bg-royal-start border-l-4 border-orange text-pure-white' : 'text-pure-white/70 hover:bg-pure-white/10 hover:text-pure-white border-l-4 border-transparent' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span x-show="sidebarOpen" class="text-sm font-medium whitespace-nowrap">Status Pengajuan</span>
        </a>
    </div>

    <!-- Menu Bawah -->
    <div class="border-t border-white/10 py-4 flex flex-col gap-1">
        <!-- Link Profil -->
        <a href="{{ url('/profil') }}" class="flex items-center gap-3 px-6 py-2 transition {{ request()->is('profil') ? 'text-orange font-bold' : 'text-pure-white/70 hover:bg-pure-white/10 hover:text-pure-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span x-show="sidebarOpen" class="text-sm font-medium whitespace-nowrap">Profil</span>
        </a>
        
        <!-- Link Keluar -->
        <form action="{{ url('/logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-6 py-2 text-pure-white/70 hover:bg-red-500/20 hover:text-red-400 transition cursor-pointer text-left">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span x-show="sidebarOpen" class="text-sm font-medium whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>