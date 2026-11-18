<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::with('ratings');

        if ($request->filled('target')) {
            $query->where('target_user', 'like', '%' . $request->target . '%');
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $ideas = $query->orderBy('code')->get()->map(function ($idea) {
            $idea->analysis_data = $idea->analysis;
            return $idea;
        });

        return view('ideas.index', compact('ideas'));
    }

    public function create()
    {
        // Hitung kode berikutnya secara otomatis
        $nextNumber = Idea::count() + 1;
        $defaultCode = sprintf("IDE-%02d", $nextNumber);
        return view('ideas.create', compact('defaultCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'           => 'required|string|max:10|unique:ideas,code',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'target_user'    => 'required|string|max:100',
            'problem_solved' => 'required|string',
            'status'         => 'nullable|string|in:active,inactive',
        ]);

        $idea = Idea::create([
            'code'           => strtoupper(trim($request->code)),
            'title'          => $request->title,
            'description'    => $request->description,
            'target_user'    => $request->target_user,
            'problem_solved' => $request->problem_solved,
            'status'         => $request->status ?? 'active',
        ]);

        ActivityLog::create([
            'user_name'   => 'Admin / Tim KIK',
            'action'      => 'Tambah Ide',
            'description' => "Menambahkan ide baru: {$idea->code} ({$idea->title}).",
        ]);

        return redirect()->route('ideas.index')->with('success', "Ide {$idea->code} berhasil ditambahkan!");
    }

    public function show($id)
    {
        $idea = Idea::with(['ratings' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        $analysis = $idea->analysis;

        return view('ideas.show', compact('idea', 'analysis'));
    }

    public function edit($id)
    {
        $idea = Idea::findOrFail($id);
        return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, $id)
    {
        $idea = Idea::findOrFail($id);

        $request->validate([
            'code'           => "required|string|max:10|unique:ideas,code,{$idea->id}",
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'target_user'    => 'required|string|max:100',
            'problem_solved' => 'required|string',
            'status'         => 'nullable|string|in:active,inactive',
        ]);

        $idea->update([
            'code'           => strtoupper(trim($request->code)),
            'title'          => $request->title,
            'description'    => $request->description,
            'target_user'    => $request->target_user,
            'problem_solved' => $request->problem_solved,
            'status'         => $request->status ?? 'active',
        ]);

        ActivityLog::create([
            'user_name'   => 'Admin / Tim KIK',
            'action'      => 'Update Ide',
            'description' => "Memperbarui data ide: {$idea->code} ({$idea->title}).",
        ]);

        return redirect()->route('ideas.index')->with('success', "Ide {$idea->code} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $idea = Idea::findOrFail($id);
        $code = $idea->code;
        $idea->delete();

        ActivityLog::create([
            'user_name'   => 'Admin / Tim KIK',
            'action'      => 'Hapus Ide',
            'description' => "Menghapus ide: {$code}.",
        ]);

        return redirect()->route('ideas.index')->with('success', "Ide {$code} beserta riwayat penilaiannya berhasil dihapus!");
    }
}
