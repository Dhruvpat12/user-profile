@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<div class="container">
    <div class="row justify-content-center">
        @if (!empty($success))
    <h1>{{$success}}</h1>
@endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Category Listing') }}</div>

                <div class="card-body">
                  
                    <table id="show-category">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>slug</th>
                                <th>Sub Category Name </th>
                                <th>Category Image </th>
                                <th>action</th>
                            </tr>
                        </thead>
                           <tbody></tbody>
                    </table>
                  
                </div>
            </div>
        </div>
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="{{ asset('js/custom/category.js') }}"></script>
@endsection



