@extends('layouts.admin')

@section('title','Edit Vendor')

@section('content')

<h3 class="mb-3">Edit Vendor</h3>

<form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
@csrf
@method('POST')

<div class="row g-3">

    <div class="col-md-4">
        <label>State</label>
        <select name="state" class="form-select" required>
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->name }}"
                    {{ $vendor->state == $state->name ? 'selected' : '' }}>
                    {{ $state->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label>Vendor Agency Name</label>
        <input type="text"
               name="vendor_agency_name"
               class="form-control"
               value="{{ $vendor->vendor_agency_name }}"
               required>
    </div>

    <div class="col-md-4">
        <label>Contact Person</label>
        <input type="text"
               name="contact_person"
               class="form-control"
               value="{{ $vendor->contact_person }}"
               required>
    </div>

    <div class="col-md-4">
        <label>Contact Number</label>
        <input type="text"
               name="contact_number"
               class="form-control"
               value="{{ $vendor->contact_number }}"
               required>
    </div>

    <div class="col-md-4">
        <label>Email</label>
        <input type="email"
               name="email_id"
               class="form-control"
               value="{{ $vendor->email_id }}">
    </div>

    <div class="col-md-4">
        <label>GST Number</label>
        <input type="text"
               name="gst_number"
               class="form-control"
               value="{{ $vendor->gst_number }}">
    </div>

    <div class="col-md-12 mt-3">
        <button class="btn btn-success">Update Vendor</button>
        <a href="{{ route('admin.vendors.index') }}"
           class="btn btn-secondary ms-2">
            Back
        </a>
    </div>

</div>
</form>

@endsection
