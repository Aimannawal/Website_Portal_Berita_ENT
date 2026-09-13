<nav x-data="{ open: false }" class="border-b border-[#dce6f5] bg-white lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r">
    <div class="flex h-16 items-center justify-between px-5 lg:h-auto lg:px-7 lg:py-7">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#92b4ec] text-sm font-bold text-[#182338]">PB</span>
            <span>
                <span class="block text-base font-bold leading-tight text-[#182338]">Portal Berita</span>
                <span class="block text-[10px] font-semibold uppercase tracking-[.2em] text-[#6d94d3]">ENT GEN 21</span>
            </span>
        </a>
        <button @click="open = !open" class="rounded-lg p-2 text-[#64748b] lg:hidden" aria-label="Buka menu">
            <span class="text-xl">☰</span>
        </button>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden border-t border-[#dce6f5] px-5 py-4 lg:block lg:border-0 lg:px-5 lg:py-0">
        <div class="mb-6 rounded-2xl bg-[#f5f8fd] p-4">
            <p class="text-sm font-semibold text-[#182338]">{{ auth()->user()->name }}</p>
            <p class="mt-1 text-xs text-[#64748b]">{{ auth()->user()->division?->name ?? 'Administrator' }}</p>
        </div>

        <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[.18em] text-[#94a3b8]">Workspace</p>
        <div class="space-y-1 text-sm font-semibold">
            <a href="{{ route('dashboard') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Overview</a>

            @role('webmaster')
                <a href="{{ route('wm.dashboard') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('wm.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Webmaster</a>
            @endrole

            @hasanyrole('webmaster|perencanaan_konten')
                <a href="{{ route('pk.dashboard') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('pk.dashboard') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Dashboard Konten</a>
                <a href="{{ route('pk.berita.index') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('pk.berita.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Berita</a>
                <a href="{{ route('pk.artikel.index') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('pk.artikel.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Artikel</a>
                <a href="{{ route('pk.tasks.index') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('pk.tasks.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Task Assignment</a>
                <a href="{{ route('pk.categories.index') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('pk.categories.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Kategori</a>
            @endhasanyrole

            @hasanyrole('fotographer|videographer|copywriting|illustrator|reporter|desain_grafis')
                <a href="{{ route('divisi.dashboard') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('divisi.dashboard') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Dashboard Divisi</a>
                <a href="{{ route('divisi.tasks.index') }}" class="block rounded-xl px-3 py-2.5 {{ request()->routeIs('divisi.tasks.*') ? 'bg-[#92b4ec] text-[#182338]' : 'text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]' }}">Task Saya</a>
            @endhasanyrole
        </div>

        <div class="mt-8 border-t border-[#dce6f5] pt-5">
            @role('webmaster')
                <a href="{{ route('wm.users.index') }}" class="mb-2 block rounded-xl px-3 py-2.5 text-sm font-semibold text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]">Kelola User</a>
            @endrole
            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2.5 text-sm font-semibold text-[#64748b] hover:bg-[#f5f8fd] hover:text-[#182338]">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-[#c75a5a] hover:bg-[#fff1f1]">Keluar</button>
            </form>
        </div>
    </div>
</nav>
