<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::where('user_id', Auth::id())->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Template::create([
            'name'      => $request->name,
            'content'   => $request->content,
            'user_id'   => auth()->id(),
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
        ]);

        $template = Template::findOrFail($id);
        $template->update($request->only('name', 'content'));

        return redirect()->route('templates.index')->with('success', 'Template berhasil diedit.');
    }

    public function datatable()
    {
        $templates = Template::where('user_id', Auth::id());

        return DataTables::of($templates)
            ->addColumn('action', function ($template) {
                return view('admin.templates._action', compact('template'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
