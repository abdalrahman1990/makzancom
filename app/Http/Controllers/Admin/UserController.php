<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
   

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }
    

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:15',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,vendor,user',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $data['image'] = $path;
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:15',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'     => 'nullable|in:admin,vendor,user',
            'status'   => 'nullable|in:active,inactive',
        ]);

            
        if ($request->hasFile('image')) {
            // Delete old image
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('users', 'public');
            $data['image'] = $path;
        }

       // ddd($data);
        $user->update($data);

        flash()
        ->translate('ar')
        ->addSuccess('تمت العملية بنجاح.', 'تهانينا');
        
    
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }



    public function destroy(User $user)
    {
        try {
            // Delete the user's image
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
    
            // Delete the user
            $user->delete();

            flash()
            ->translate('ar')
            ->addSuccess('تمت العملية بنجاح.', 'تهانينا');
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);

        } catch (\Exception $e) {
            
            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was a problem deleting the user. Please try again.');
        }
    }
    

}
