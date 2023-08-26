@extends('admin.layouts.app')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="profile-foreground position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg">
                    <img src="{{ Storage::url($user->image) }}" alt="" class="profile-wid-img" />
                </div>
            </div>
           
            <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
                <div class="row g-4">
                    <div class="col-auto">
                        @if($user->image)
                            <div class="mt-2">
                                <img src="{{ Storage::url($user->image) }}" alt="User Image" class="img-thumbnail" width="150">
                            </div>
                            @endif
                    </div>
                    <!--end col-->
                    <div class="col">
                        <div class="p-2">
                            <h3 class="text-white mb-1">{{$user->name}}</h3>
                            <p class="text-white-75">user name:{{$user->username}}</p>
                            <div class="hstack text-white-50 gap-1">
                                <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>{{$user->email}}</div>
                                <div>
                                    <i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>{{$user->phone}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-12 col-lg-auto order-last order-lg-0">
                        <div class="row text text-white-50 text-center">
                            <div class="col-lg-6 col-4">
                                <div class="p-2">
                                    <h4 class="text-white mb-1">Role</h4>
                                    <p class="fs-14 mb-0">{{$user->role}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-4">
                                <div class="p-2">
                                    <h4 class="text-white mb-1">Status</h4>
                                    <p class="fs-14 mb-0">{{$user->status}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->

                </div>
                <!--end row-->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div class="d-flex">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                        <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-14" data-bs-toggle="tab" href="#activities" role="tab">
                                        <i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Activities</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-14" data-bs-toggle="tab" href="#projects" role="tab">
                                        <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Projects</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab">
                                        <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Documents</span>
                                    </a>
                                </li>
                            </ul>
                            
                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content pt-4 text-muted">
                            <div class="tab-pane active" id="overview-tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-xxl-3"> 
                                        <style>
                                            .text-right {
                                                text-align: right;
                                            }
                                        </style>
                                        <div class="card">
                                            <div class="card-body">
                                               
                                                <div class="table-responsive">
                                                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                        
                                                        <table class="table table-borderless shadow-lg p-3 mb-5 bg-white rounded">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        {{-- <label for="image">Image:</label><br> --}}
                                                                        <input id="image" type="file" name="image" required>
                                                                        <img src="{{Storage::url($user->image)}}" alt="{{ $user->name }}" width="100" height="100" class="rounded-circle mt-2">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="name">Name:</label>
                                                                        <input id="name" type="text" name="name" value="{{ $user->name }}" required class="form-control text-right">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="email">Email:</label>
                                                                        <input id="email" type="email" name="email" value="{{ $user->email }}" required class="form-control text-right">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label for="phone">Phone:</label>
                                                                        <input id="phone" type="tel" name="phone" value="{{ $user->phone }}" required class="form-control text-right">
                                                                    </td>
                                                                </tr>
                                                                <!-- Add more fields as necessary -->
                                                            </tbody>
                                                        </table>
                                        
                                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--end tab-content-->
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div><!-- container-fluid -->
    </div><!-- End Page-content -->
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ __('Update Password') }}</h5>
            <p class="mb-3">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
            <div class="table-responsive">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
    
                    <table class="table table-borderless shadow-lg p-3 mb-5 bg-white rounded">
                        <tbody>
                            <tr>
                                <td>
                                    <label for="current_password">{{ __('Current Password') }}</label>
                                    <input id="current_password" type="password" name="current_password" required class="form-control">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">{{ __('New Password') }}</label>
                                    <input id="password" type="password" name="password" required class="form-control">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
    
                    <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                    @if (session('status') === 'password-updated')
                        <p class="mt-2">{{ __('Update password.') }}</p>
                    @endif
                    <br>
                </form>
            </div>
        </div>
    </div>
    
   
       
    
</div>
