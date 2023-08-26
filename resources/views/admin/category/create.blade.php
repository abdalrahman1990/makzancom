@extends('admin.layouts.app')

@section('content')
<div class="container my-5">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-header bg-primary ">
            <h4 class="mb-0 text-white">Create Category</h4>
        </div>
        <div class="card-body rtl-form">
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name..." required onkeyup="generateSlug(this.value)">
                </div>

                <div class="mb-4"> 
                    <button class="btn btn-primary" name="icon" data-selected-class="btn-danger" data-unselected-class="btn-primary" role="iconpicker"></button>
                    <label style="font-size:16px"> Select Icon </label> 
                </div>
                
                <div class="mb-4">
                    <label style="font-size:16px" class="form-label">Status</label>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1" checked>
                        <label class="form-check-label" for="active">Active</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
        direction: ltr;
    }
    .rtl-form .input-group .btn-outline-secondary {
        border-right: 1px solid #ced4da;
    }
    .rtl-form .d-flex {
        direction: ltr;
    }
</style>
@endpush

@push('scripts')

@endpush
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!-- Add other necessary scripts here -->