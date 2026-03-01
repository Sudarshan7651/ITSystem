<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::withCount('departments')->latest()->paginate(15);
        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        return view('admin.colleges.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255|unique:colleges,name',
            'short_name' => 'nullable|string|max:50',
            'location'   => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
        ]);

        College::create($data);

        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College created successfully.');
    }

    public function edit(College $college)
    {
        return view('admin.colleges.edit', compact('college'));
    }

    public function update(Request $request, College $college)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'short_name' => 'nullable|string|max:50',
            'location'   => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
        ]);

        $college->update($data);

        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College updated successfully.');
    }

    public function destroy(College $college)
    {
        $college->delete();
        return redirect()->route('admin.colleges.index')
                         ->with('success', 'College deleted successfully.');
    }
}
