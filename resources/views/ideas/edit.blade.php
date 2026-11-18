@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('ideas.index') }}" class="text-xs text-azul/60 hover:text-azul transition font-semibold">
            &larr; Kembali ke Daftar Ide
        </a>
        <h1 class="font-display text-3xl font-extrabold text-azul mt-2">Edit Ide Solusi: {{ $idea->code }}</h1>
        <p class="text-xs text-azul/60 mt-1">Perbarui parameter data dan deskripsi ide.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500 text-red-700 text-xs space-y-1">
        @foreach($errors->all() as $err)
            <div>• {{ $err }}</div>
        @endforeach
    </div>
    @endif

    <form action="{{ route('ideas.update', $idea->id) }}" method="POST" class="white-glass p-6 sm:p-8 rounded-[32px] border border-horizonte/25 space-y-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-black uppercase text-azul mb-2">Kode Ide *</label>
                <input type="text" name="code" value="{{ old('code', $idea->code) }}" required maxlength="10"
                    class="w-full px-4 py-3 rounded-xl bg-white border border-horizonte/40 text-azul focus:border-azul outline-none shadow-sm">
            </div>

            <div>
                <label class="block text-xs font-black uppercase text-azul mb-2">Sasaran Target Pengguna *</label>
                <input type="text" name="target_user" value="{{ old('target_user', $idea->target_user) }}" required
                    class="w-full px-4 py-3 rounded-xl bg-white border border-horizonte/40 text-azul focus:border-azul outline-none shadow-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul mb-2">Judul Ide Solusi *</label>
            <input type="text" name="title" value="{{ old('title', $idea->title) }}" required
                class="w-full px-4 py-3 rounded-xl bg-white border border-horizonte/40 text-azul focus:border-azul outline-none shadow-sm">
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul mb-2">Masalah yang Diatasi *</label>
            <textarea name="problem_solved" rows="2" required
                class="w-full px-4 py-3 rounded-xl bg-white border border-horizonte/40 text-azul focus:border-azul outline-none text-sm shadow-sm">{{ old('problem_solved', $idea->problem_solved) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-azul mb-2">Deskripsi Solusi Digital *</label>
            <textarea name="description" rows="3" required
                class="w-full px-4 py-3 rounded-xl bg-white border border-horizonte/40 text-azul focus:border-azul outline-none text-sm shadow-sm">{{ old('description', $idea->description) }}</textarea>
        </div>

        <div class="pt-4 flex items-center justify-end gap-3 border-t border-horizonte/20">
            <a href="{{ route('ideas.index') }}" class="px-5 py-3 rounded-full bg-white border border-horizonte/40 text-azul/70 hover:text-azul text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 rounded-full bg-azul text-nuvem font-display font-black text-sm hover:bg-azul/90 transition shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
