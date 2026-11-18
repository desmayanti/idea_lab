@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 space-y-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-horizonte/30 pb-6">
        <div>
            <a href="{{ route('respondents.index') }}" class="text-xs text-horizonte hover:text-sol transition font-semibold">
                &larr; Kembali ke Daftar Responden
            </a>
            <h1 class="font-display text-3xl font-extrabold text-nuvem mt-2">
                Rincian Penilaian: {{ $response->respondent_name }}
            </h1>
            <p class="text-xs text-horizonte mt-1">
                Kelas: <strong class="text-nuvem">{{ $response->respondent_class }}</strong> &bull; Waktu: <strong class="text-sol">{{ $response->submitted_at ? $response->submitted_at->format('d F Y, H:i:s') : $response->created_at->format('d F Y, H:i:s') }}</strong>
            </p>
        </div>

        <form action="{{ route('respondents.destroy', $response->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh penilaian responden ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-xl bg-red-500/20 border border-red-500 text-red-300 font-bold text-xs hover:bg-red-500 hover:text-white transition">
                🗑️ Hapus Responden
            </button>
        </form>
    </div>

    <!-- Tabel Rincian Skor 10 Ide oleh Responden ini -->
    <div class="glass-panel p-6 rounded-3xl border border-horizonte/30 overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="border-b border-horizonte/30 text-horizonte uppercase text-xs">
                    <th class="py-3 px-3">Kode</th>
                    <th class="py-3 px-3">Judul Ide Solusi</th>
                    <th class="py-3 px-3 text-center">Feasibility (1-5)</th>
                    <th class="py-3 px-3 text-center">Impact (1-5)</th>
                    <th class="py-3 px-3">Komentar / Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-horizonte/20">
                @foreach($response->ratings as $rating)
                <tr class="hover:bg-horizonte/10 transition">
                    <td class="py-3 px-3 font-mono font-bold text-sol">{{ $rating->idea->code ?? '-' }}</td>
                    <td class="py-3 px-3 font-semibold text-nuvem">{{ $rating->idea->title ?? '-' }}</td>
                    <td class="py-3 px-3 text-center font-bold text-nuvem">{{ $rating->feasibility }}</td>
                    <td class="py-3 px-3 text-center font-bold text-sol">{{ $rating->impact }}</td>
                    <td class="py-3 px-3 text-xs text-horizonte italic">
                        {{ $rating->comment ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
