@extends('admin.layouts.app')

@section('content')

<div class="container my-4">

    <!-- Flash messages for session data (like success or error messages) -->
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 text-white">ادارة التصنيفات الفرعية</h4>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">
                    <i class="bx bxs-message-square-add"></i> اضافة تصنيف فرعي جديد
                </a>
            </div>

            {!! $dataTable->table() !!}

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end container -->

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@endsection
