<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $maxData = 8;

        if (request('search')) {
            // menampilkan pencarian data
            $categories = Category::select('id', 'name')
                ->where('name', 'like', '%' . request('search') . '%')
                ->paginate($maxData)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $categories = Category::select('id', 'name')
                ->latest()
                ->paginate($maxData);
        }

        // tampilkan data ke view
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // tampilkan form add data
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'code_prefix' => 'required|alpha|min:2|max:5|unique:categories',
            'description' => 'nullable|string|max:500'
        ]);

        Category::create([
            'name' => $request->name,
            'code_prefix' => strtolower($request->code_prefix),
            'description' => $request->description,
        ]);


        return redirect()->route('categories.index')->with(['success' => 'The new category has been saved.']);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // tampilkan form detail data
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // tampilkan form edit data
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'code_prefix' => 'required|alpha|min:2|max:5|unique:categories,code_prefix,' . $id,
        ]);

        // get data by ID
        $category = Category::findOrFail($id);

        // update data
        $category->update([
            'name' => $request->name,
            'code_prefix' => strtolower($request->code_prefix),
            'description' => $request->description,
        ]);

        return redirect()->route('categories.show', $category->id)->with(['success' => 'The category has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // delete data
        $category->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('categories.index')->with(['success' => 'The category has been deleted!']);
    }
}
