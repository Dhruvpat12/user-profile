@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Category') }}</div>

                <div class="card-body">
                    <form method="POST" id="add-categoryes" data-action="{{ route('add-category') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="parent_id" class="col-md-4 col-form-label text-md-right">Parent Category</label>
                        <div class="col-md-6">
                            <select class="form-control" id="parent_id" name="parent_id">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="row mb-3">
                            <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

                            <div class="col-md-6">
                                <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}"  autocomplete="slug">

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category_image" class="col-md-4 col-form-label text-md-right">{{ __('Category Image') }}</label>

                            <div class="col-md-6">
                                <input id="category_image" type="file" class="form-control @error('category_image') is-invalid @enderror" name="category_image[]" value="{{ old('category_image') }}"  autocomplete="category_image" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('add Category') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! $validator->selector('#add-categoryes') !!}
<script src="{{ asset('js/custom/category.js') }}"></script>

@endsection
