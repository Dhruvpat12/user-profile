@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Display Category') }}</div>

                <div class="card-body">
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                {{ $category->name }}

                                <!-- Check for subcategories under this parent category -->
                                @if ($category->children->count() > 0)
                                    <ul>
                                        @foreach ($category->children as $subcategory)
                                            <li>{{ $subcategory->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <ul>
                        <!-- Loop for displaying all subcategories -->
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script src="{{ asset('js/custom/category.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script> --}}
{{-- {!! $validator->selector('#add-category') !!} --}}
@endsection
