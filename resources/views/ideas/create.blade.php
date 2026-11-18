@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('ideas.index') }}" class="text-xs text-azul/60 dark:text-slate-400 hover:text-azul dark:hover:text-sol transition font-semibold">
            &larr; Kembali ke Daftar Ide
        </a>
        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-azul/10 dark:bg-horizonte/20 text-azul dark:text-nuvem text-xs font-bold uppercase tracking-wider">
            SENARAI KIK &bull; AJUKAN VALIDASI IDE
        </div>
        <h1 class="font-display text-3xl font-extrabold text-azul dark:text-nuvem mt-2">Buat Sesi Validasi / Ajukan Ide Baru</h1>
        <p class="text-xs md:text-sm text-azul/70 dark:text-slate-400 mt-1">
            Daftarkan topik inovasi Anda (UMKM, startup, atau proyek mahasiswa) agar dapat dinilai oleh responden komunitas dan dianalisis dalam Matriks Kuadran.
        </p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500 text-red-700 dark:text-red-300 text-xs space-y-1">
        @foreach($errors->all() as $err)
            <div>• {{ $err }}</div>
        @endforeach
    </div>
    @endif

    <form action="{{ route('ideas.store') }}" method="POST" class="white-glass p-6 sm:p-8 rounded-[32px] border border-horizonte/25 dark:border-slate-800 space-y-6 shadow-sm">
        @csrf

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Kode Ide (Unik) *</label>
                <input type="text" name="code" value="{{ old('code', $defaultCode) }}" required maxlength="10"
                    placeholder="Contoh: IDE-11"
                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul dark:focus:border-sol outline-none shadow-sm">
                <p class="text-[10px] text-slate-400 mt-1">Format kode ide otomatis (bisa disesuaikan).</p>
            </div>

            <div>
                <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Sasaran Target Pengguna *</label>
                <input type="text" name="target_user" value="{{ old('target_user', 'UMKM / Publik') }}" required
                    placeholder="Contoh: Pelaku UMKM / Konsumen E-Commerce / Mahasiswa"
                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul dark:focus:border-sol outline-none shadow-sm">
                <p class="text-[10px] text-slate-400 mt-1">Siapa audiens utama yang merasakan manfaat ide ini.</p>
            </div>
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Judul Ide Solusi *</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                placeholder="Contoh: Otomasi Rekonsiliasi Penjualan Multi-Channel Toko Online"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul dark:focus:border-sol outline-none shadow-sm">
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Permasalahan yang Diatasi *</label>
            <textarea name="problem_solved" rows="3" required
                placeholder="Jelaskan masalah riil pengguna atau hambatan operasional yang mendasari ide ini..."
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul dark:focus:border-sol outline-none text-sm shadow-sm">{{ old('problem_solved') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul dark:text-nuvem mb-2">Deskripsi Solusi Digital *</label>
            <textarea name="description" rows="3" required
                placeholder="Jelaskan mekanisme kerja, fitur utama, dan inovasi yang ditawarkan solusi ini..."
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-900 border border-horizonte/40 dark:border-slate-700 text-azul dark:text-nuvem placeholder-slate-400 focus:border-azul dark:focus:border-sol outline-none text-sm shadow-sm">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-horizonte/20 dark:border-slate-800">
            <a href="{{ route('ideas.index') }}" class="px-5 py-3 rounded-xl bg-white dark:bg-slate-800 border border-horizonte/40 dark:border-slate-700 text-azul/70 dark:text-slate-300 hover:text-azul text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-azul dark:bg-sol text-nuvem dark:text-azul font-display font-extrabold text-sm hover:opacity-90 transition shadow-md">
                Simpan &amp; Buka Validasi
            </button>
        </div>
    </form>
</div>
@endsection
