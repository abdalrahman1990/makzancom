@extends('admin.layouts.app')

<style>
    .rtl-form {
        direction: rtl;
    }
    .rtl-form .form-label, 
    .rtl-form .form-check-label {
        display: block;
        text-align: right;
        margin-bottom: 8px;
    }
    .rtl-form .input-group {
        direction: ltr; /* to keep input-group behavior consistent */
    }
    .rtl-form .input-group .btn-outline-secondary {
        border-right: 1px solid #ced4da; /* adding border to the left of button */
    }
    .rtl-form .d-flex {
        direction: ltr; /* To keep the button in the center */
    }
</style>

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h2 class="text-white">إضافة إعلان جديد</h2>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter advertisement title..." required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter advertisement description..." rows="4"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Price Field -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price...">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Images Upload -->
                        <div class="form-group">
                            <label for="images">Upload Images</label>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple>
                            @error('images')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Subcategory Selection -->
                        <div class="form-group">
                            <label for="subcategory_id">Subcategory</label>
                            <select class="form-control" id="subcategory_id" name="subcategory_id">
                                <option value="">Select a Subcategory</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <center>
                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block">إرسال</button>
                        </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Add any specific JS scripts here -->
@endpush
