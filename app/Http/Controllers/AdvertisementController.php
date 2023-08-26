<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\DataTables\AdvertisementDataTable;
use Illuminate\Support\Str;
use App\Models\Advertisement;
use App\Models\Subcategory;


class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdvertisementDataTable $dataTable){

        return $dataTable->render('admin.advertisements.index');
        
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(){

        $subcategories = Subcategory::all();
        return view('admin.advertisements.create' , compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);
    
        // Generate the slug from the title
        $slug = Str::slug($data['title']);
        $count = Advertisement::where('slug', 'LIKE', "{$slug}%")->count();
        
        // If other slugs have a similar pattern, adjust slug accordingly
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;
    
        $advertisement = new Advertisement($data);
        $advertisement->user_id = auth()->id();
        $advertisement->save();
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('advertisements', 'public');
                $advertisement->images()->create(['path' => $path]);
            }
        }
    
        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement created successfully!');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('advertisements.show', compact('advertisement'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        $subcategories = Subcategory::all();
        return view('admin.advertisements.edit', compact('advertisement','subcategories'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);

        // Generate the slug from the title
        $slug = Str::slug($data['title']);
        $count = Advertisement::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $advertisement->id)->count();

        // If other slugs have a similar pattern, adjust slug accordingly
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;

        $advertisement->update($data);

        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageId) {
                $image = $advertisement->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }
        

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('advertisements', 'public');
                $advertisement->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */

     public function destroy(Advertisement $advertisement){
    try {
        // Eager-load the images relationship for the advertisement.
        $advertisement->load('images');
        
        // Delete associated images and their files.
        foreach ($advertisement->images as $image) {
            // First, try to delete the file.
            if (Storage::disk('public')->exists($image->path) && Storage::disk('public')->delete($image->path)) {
                // If the file deletion is successful, delete the database record.
                $image->delete();
            }
        }

        // Now delete the advertisement.
        $advertisement->delete();

        return response()->json(['success' => true], 200);

    } catch (\Exception $e) {
        // This could log the error for debugging.
        Log::error("Error deleting advertisement: " . $e->getMessage());

        return response()->json(['success' => false], 500);
    }

    return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement deleted successfully!');
   
    }

   

    public function search(Request $request){
    $query = $request->input('query');
    $advertisements = Advertisement::where('title', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%")
                    ->get();
    return view('advertisements.search', compact('advertisements'));

    }

}
