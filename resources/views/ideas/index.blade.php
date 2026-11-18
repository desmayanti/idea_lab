@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-horizonte/30 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-azul/10 text-azul text-xs font-bold uppercase tracking-wider">
                MANAJEMEN DATA SOLUSI
            </div>
            <h1 class="font-display text-3xl font-extrabold text-azul mt-2">Daftar 10 Ide E-Commerce</h1>
            <p class="text-sm text-azul/70 mt-1">Kelola data ide, target pengguna KYOTO STORE, serta status validasi.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('ideas.create') }}" class="px-5 py-3 rounded-full bg-azul text-nuvem font-display font-extrabold text-xs md:text-sm hover:bg-azul/90 transition shadow-md flex items-center gap-2">
                <span>+</span> Tambah Ide Baru
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <form method="GET" action="{{ route('ideas.index') }}" class="white-glass p-4 rounded-2xl flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="w-full sm:w-1/2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode (IDE-..), judul, atau deskripsi..."
                class="w-full px-4 py-2.5 rounded-xl bg-white border border-horizonte/30 text-xs text-azul focus:border-azul outline-none shadow-sm">
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <select name="target" class="px-4 py-2.5 rounded-xl bg-white border border-horizonte/30 text-xs text-azul focus:border-azul outline-none shadow-sm">
                <option value="">Semua Target Pengguna</option>
                <option value="KYOTO STORE" {{ request('target') == 'KYOTO STORE' ? 'selected' : '' }}>KYOTO STORE</option>
            </select>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-azul text-nuvem font-bold text-xs hover:bg-azul/90 transition shadow-sm">
                Filter
            </button>
            @if(request('search') || request('target'))
            <a href="{{ route('ideas.index') }}" class="px-3 py-2.5 rounded-xl bg-white border border-horizonte/30 text-azul/70 hover:text-azul text-xs font-bold transition">
                Reset
            </a>
            @endif
        </div>
    </form>

    <!-- Tabel Manajemen Ide -->
    <div class="white-glass p-6 rounded-[28px] border border-horizonte/25 overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="border-b border-horizonte/30 text-horizonte uppercase text-xs">
                    <th class="py-3 px-4">Kode</th>
                    <th class="py-3 px-4">Judul Solusi</th>
                    <th class="py-3 px-4">Sasaran Target</th>
                    <th class="py-3 px-4 text-center">Responden</th>
                    <th class="py-3 px-4 text-center">Feasibility</th>
                    <th class="py-3 px-4 text-center">Impact</th>
                    <th class="py-3 px-4 text-center">Total Skor</th>
                    <th class="py-3 px-4 text-center">Kuadran</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-horizonte/15">
                @forelse($ideas as $idea)
                <tr class="hover:bg-horizonte/10 transition">
                    <td class="py-4 px-4 font-mono font-bold text-azul">{{ $idea->code }}</td>
                    <td class="py-4 px-4 font-bold text-azul">
                        <a href="{{ route('ideas.show', $idea->id) }}" class="hover:text-horizonte transition">
                            {{ $idea->title }}
                        </a>
                    </td>
                    <td class="py-4 px-4 text-xs text-azul/60 font-semibold">{{ $idea->target_user }}</td>
                    <td class="py-4 px-4 text-center font-bold text-azul">{{ $idea->analysis_data['respondents_count'] }}</td>
                    <td class="py-4 px-4 text-center font-semibold text-azul">{{ $idea->analysis_data['avg_feasibility'] }}</td>
                    <td class="py-4 px-4 text-center font-semibold text-azul">{{ $idea->analysis_data['avg_impact'] }}</td>
                    <td class="py-4 px-4 text-center font-display font-black text-base text-azul">{{ $idea->analysis_data['total_score'] }}</td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $idea->analysis_data['quadrant'] === 'Prioritas Utama' ? 'bg-sol text-azul' : ($idea->analysis_data['quadrant'] === 'Potensi' ? 'bg-horizonte text-white' : ($idea->analysis_data['quadrant'] === 'Pertimbangkan' ? 'bg-azul text-white' : 'bg-red-500 text-white')) }}">
                            {{ $idea->analysis_data['quadrant'] }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('ideas.show', $idea->id) }}" class="p-2 rounded-xl bg-white border border-horizonte/30 text-azul hover:bg-azul hover:text-white text-xs shadow-sm" title="Lihat Detail">
                                👁️
                            </a>
                            <a href="{{ route('ideas.edit', $idea->id) }}" class="p-2 rounded-xl bg-white border border-horizonte/30 text-azul hover:bg-azul hover:text-white text-xs shadow-sm" title="Edit">
                                ✏️
                            </a>
                            <form action="{{ route('ideas.destroy', $idea->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ide {{ $idea->code }}?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-white border border-red-500/30 text-red-500 hover:bg-red-500 hover:text-white text-xs shadow-sm" title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-8 text-center text-azul/60">Tidak ada ide yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
