<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\DataTables\SubCategoryDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory; //assuming Category is the name of your model

class SubcategoryController extends Controller
{
    //Display a listing of the resource.
    public function index(SubcategoryDataTable $dataTable){

        return $dataTable->render('admin.subcategory.index');
        
    }

    //Show the form for creating a new resource.
    public function create(){

        $categories = Category::all();

        return view('admin.subcategory.create' , compact('categories'));
        
    }

    //Store a newly created resource in storage.
   
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
    
        Subcategory::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'status' => $validatedData['status'],
            'category_id' => $validatedData['category_id'],  // this line maps the 'parent_id' input to 'category_id' in the database
        ]);
    
        return redirect()->route('admin.subcategory.index')->with('success', 'ٍSubCategory created successfully!');
    }
    


    // Using Route Model Binding
    public function show(Subcategory $subcategory) {
        return view('admin.subcategory.show', compact('subcategory'));
    }


    public function edit($id){

        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all();  // Fetch all categories
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    
    }


    public function update(Request $request, Subcategory $subcategory) {
        // Validation
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:0,1',
        ]);

        // Update fields directly from validated data
        $subcategory->update([
            'name' => $request->name,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        // flash()
        //     ->success('Your information has been saved.')
        //     ->flash();
            
        flash()
        ->translate('ar')
        ->addSuccess('تمت العملية بنجاح.', 'تهانينا');

        // flash()->addError('There was an issue unlocking your account.');
        // flash()->addWarning('Your account may not have been re-activated.');
        // flash()->addInfo('Your account has been created, but requires verification.');
       // flash()->addFlash('error', 'There was an issue restoring your account.');

        return redirect()->route('admin.subcategory.index')->with('success', 'Subcategory updated successfully!');
    }


    public function toggleStatus($id) {
        $subcategory = Subcategory::find($id);

        if(!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategory not found.'], 404);
        }

        // Toggle status
        $subcategory->status = !$subcategory->status;
        $subcategory->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }


    public function destroy($id) {
        $subcategory = Subcategory::find($id);

        if(!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategory not found.'], 404);
        }

        $subcategory->delete();

        return response()->json(['success' => true, 'message' => 'Subcategory deleted successfully.']);
    }


    }
