@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h2 class="text-white">Edit Category</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <br>
                        <!-- Icon Input -->
                      
                       <div class="mb-4">     
                            <button class="btn btn-primary"
                                name="icon" 
                                data-selected-class="btn-danger"
                                data-unselected-class="btn-primary" role="iconpicker">                           
                            </button>
                            <label style='font-size:16px'> Select Icon </label> 
                        </div>
    

                        <!-- Status Radio Buttons -->
                        <div class="form-group">
                            <label>Status</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="0" {{ $category->status == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                            @error('status')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript" 
src="https://code.jquery.com/jquery-3.3.1.min.js">
</script>
<!-- Bootstrap CDN -->
<script 
type="text/javascript" 
src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js">
</script>
<!-- Bootstrap-Iconpicker Bundle -->

