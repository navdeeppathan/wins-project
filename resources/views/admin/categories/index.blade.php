@extends('layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-4">Category Management</h3>

{{-- @if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif --}}

{{-- ADD CATEGORY --}}
<div class="card mb-4">
<div class="card-header">Add Category</div>
<div class="card-body">

<form method="POST" action="{{ route('categories.store') }}">
@csrf

<div class="row">

<div class="col-md-4">
<input type="text" name="name" class="form-control" placeholder="Category Name" required>
</div>

<div class="col-md-2">
<button class="btn btn-primary">Add</button>
</div>

</div>

</form>

</div>
</div>

{{-- CATEGORY LIST --}}
<div class="card">
<div class="card-header">All Categories</div>

<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Status</th>
<th>Subcategories</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($categories as $category)

<tr>

<td>{{ $category->id }}</td>

<td>{{ $category->name }}</td>

<td>


<form action="{{ route('categories.status',$category->id) }}" method="POST">
@csrf

<div class="form-check form-switch">

<input 
class="form-check-input"
type="checkbox"
onchange="this.form.submit()"
{{ $category->status ? 'checked' : '' }}>

</div>

</form>



</td>

<td>

<ul class="">

@foreach($category->subcategories as $sub)

<li class="mb-2 text-start gap-2" style="display: flex">

{{ $sub->name }}

@if($sub->status)

<form action="{{ route('subcategories.status',$sub->id) }}" method="POST">
@csrf

<div class="form-check form-switch">

<input 
class="form-check-input"
type="checkbox"
onchange="this.form.submit()"
{{ $sub->status ? 'checked' : '' }}>

</div>

</form>

@endif

<form action="{{ route('subcategories.delete',$sub->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger">Delete</button>
</form>

</li>

@endforeach

</ul>

{{-- ADD SUBCATEGORY --}}

<form method="POST" action="{{ route('subcategories.store') }}">
@csrf

<input type="hidden" name="category_id" value="{{ $category->id }}">

<div class="row mt-2">

<div class="col-md-8">
<input type="text" name="name" class="form-control" placeholder="Subcategory Name">
</div>

<div class="col-md-4">
<button class="btn btn-success btn-sm">Add</button>
</div>

</div>

</form>

</td>

<td>

{{-- EDIT CATEGORY --}}

<button class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#editCategory{{ $category->id }}">
Edit
</button>

{{-- DELETE CATEGORY --}}

<form action="{{ route('categories.destroy',$category->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

{{-- EDIT MODAL --}}

<div class="modal fade" id="editCategory{{ $category->id }}">

<div class="modal-dialog">

<div class="modal-content">

<form method="POST" action="{{ route('categories.update',$category->id) }}">

@csrf
@method('PUT')

<div class="modal-header">
<h5>Edit Category</h5>
</div>

<div class="modal-body">

<input type="text"
name="name"
class="form-control"
value="{{ $category->name }}">

</div>

<div class="modal-footer">

<button class="btn btn-primary">
Update
</button>

</div>

</form>

</div>

</div>

</div>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection