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
                    <h2 class="text-white">اضافة تصنيف فرعي جديد</h2>
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

                    <form action="{{ route('admin.subcategory.store') }}" method="POST">
                        @csrf

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name..." required onkeyup="generateSlug(this.value)">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <br>
                        <!-- Category Dropdown for Subcategory -->
                        <div class="form-group">
                            <label for="parent_category">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <!-- Status Field -->
                        <div class="form-group">
                            <label>Status</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="1" checked>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                            @error('status')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <br>
                        <center>
                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block">ارسال</button>
                        </div>
                       </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')

@endpush

@endsection

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Bootstrap CDN -->
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap-Iconpicker Bundle -->

