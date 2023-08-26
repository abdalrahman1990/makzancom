@extends('admin.layouts.app')

@section('content')
<style>
 .custom-checkbox {
    width: 30px;
    height: 30px;
}

.image-delete-checkbox {
    opacity: 0;
    position: absolute;
    width: 30px;
    height: 30px;
    cursor: pointer;
    z-index: 1;
}

.image-delete-checkbox + label {
    position: relative;
    width: 30px;
    height: 30px;
    border: 2px solid #eee;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 50%;
    cursor: pointer;
}

.image-delete-checkbox:checked + label::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 16px;
    height: 16px;
    background-color: white;
    border-radius: 50%;
}
  
.image-box {
    position: relative;
}

.checkmark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    opacity: 0.7;
}

.image-box.dimmed .image {
    filter: brightness(50%);
}

.image-box.dimmed .checkmark {
    display: block;
}


</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h2 class="text-white">تعديل الإعلان</h2>
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

                    <form action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $advertisement->title }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ $advertisement->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Price Field -->
                        <div class="form-group">
                            <label for="price">السعر</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ $advertisement->price }}">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Images Upload -->
                        <div class="form-group">
                            <label for="images">رفع الصور</label>
                            <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple>
                            @error('images')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Display Existing Images -->
                        <div class="form-group">
                            <label>الصور الحالية</label>
                            <div class="row">
                                @foreach($advertisement->images as $image)
                                    <div class="col-md-3 mb-3 position-relative image-box">
                                        <img src="{{ Storage::url($image->path) }}" alt="Advertisement Image" class="img-thumbnail image">

                                        <!-- Checkmark Icon -->
                                        <i class="fas fa-trash-alt fa-2x checkmark" style="display: none;"></i>

                                        <!-- Custom Styled Checkbox -->
                                        <div class="custom-checkbox position-absolute" style="top: 10px; right: 10px;">
                                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" id="delete-{{ $image->id }}" class="image-delete-checkbox" onchange="toggleImageState(this)">
                                            <label for="delete-{{ $image->id }}"></label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Subcategory Selection -->
                        <div class="form-group">
                            <label for="subcategory_id">التصنيف الفرعي</label>
                            <select class="form-control" id="subcategory_id" name="subcategory_id">
                                <option value="">اختر تصنيف فرعي</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $advertisement->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <center>
                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block">تحديث</button>
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
<script>


if ($request->has('remove_images')) {
    foreach ($request->input('remove_images') as $imageId) {
        $image = $advertisement->images()->find($imageId);
        if ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}

</script>
@endpush
