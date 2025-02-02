@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('edit user') }}</div>

                <div class="card-body">
                    <form method="POST"  action="{{url('update-category', $category->id) }}" id="edit-category">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category->name }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

                            <div class="col-md-6">
                                <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ $category->slug }}"  autocomplete="slug" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="parent_id" class="col-md-4 col-form-label text-md-right">Parent Category</label>
                            <div class="col-md-6">
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">None</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" 
                                            {{ isset($category->parent_id) && $category->parent_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>
                            
                    <div class="row mb-3">
                        <label for="category_image" class="col-md-4 col-form-label text-md-right">{{ __('Category Image') }}</label>
                       
                        <div class="col-md-6">
                            <input id="category_image" type="file" class="form-control @error('category_image') is-invalid @enderror" name="category_image[]" value="{{ old('category_image') }}"  autocomplete="category_image" autofocus>
                            @if(!empty($record->category_image))
                            <img src="{{ asset('images/'.$category->category_image) }}" alt="Category  image" width="50" height="50">
                             @endif
                            {{-- @foreach ($category as $image)
                            <img src="{{ asset('images/'.$image->category_image) }}" alt="Category  image" width="50" height="50">
                          @endforeach --}}
                        </div>
                    </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit"  class="btn btn-primary">
                                    {{ __('Update Category') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src = "https://ajax.aspnetCDN.com/ajax/jQuery/jQuery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/custom/category.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! $editvalidator->selector('#edit-category') !!}
@endsection
