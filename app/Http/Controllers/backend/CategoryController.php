<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category; //assuming Category is the name of your model

class CategoryController extends Controller
{
    //Display a listing of the resource.
    public function index(CategoryDataTable $dataTable){

        return $dataTable->render('admin.category.index');
        
    }

    //Show the form for creating a new resource.
    public function create(){
        return view('admin.category.create');
    }

    //Store a newly created resource in storage.
    public function store(Request $request){
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'icon' => 'nullable|string|max:255',
        'status' => 'required|boolean',
    ]);

    Category::create([
        'name' => $validatedData['name'],
        'slug' => Str::slug($validatedData['name']),
        'icon' => $validatedData['icon'],
        'status' => $validatedData['status'],
    ]);

    return redirect()->route('admin.category.index')->with('success', 'Category created successfully!');
}


    //Display the specified resource.
    public function show($id){
        $category = Category::findOrFail($id);
        return view('admin.category.show', compact('category'));
    }


    //Show the form for editing the specified resource.
    public function edit($id){
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }


    //Update the specified resource in storage.
    public function update(Request $request, $id){
    // Validation
    $request->validate([
        'name'   => 'required|string|max:255',
        'icon'   => 'nullable|string|max:255',
        'status' => 'required|in:0,1',
    ]);

    $category = Category::findOrFail($id);

    // Update fields
    $category -> name   = $request -> name;
    $category -> icon   = $request -> icon;
    $category -> status = $request -> status;

    $category->save();

    return redirect()->route('admin.category.index')->with('success', 'Category updated successfully!');
   } 

   public function toggleStatus($id) {
    $category = Category::find($id);
    
    if($category) {
        $category->status = !$category->status; // Toggle status
        $category->save();
        
        return response()->json(['message' => 'Status updated successfully.'], 200);
    } else {
        return response()->json(['message' => 'Category not found.'], 404);
    }
}


    public function destroy($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['success' => false, 'message' => 'Category not found']);
    }

    $category->delete();
    return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
}

    
}
