@extends('layouts.admin')

@section('title','Vendors')

@section('content')



<div class="d-flex justify-content-between align-items-center mb-3">
<h3 class="mb-3">Vendors</h3>
<a href="{{ route('admin.vendors.create') }}"
   class="btn btn-primary btn-sm mb-3 float-end">
    + Add Vendor
</a>
</div>

<div class="table-responsive">
<table id="example" class="table class-table nowrap" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>State</th>
            <th>Vendor Agency</th>
            <th>Contact Person</th>
            <th>Contact No</th>
            <th>Email</th>
            <th>GST</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($vendors as $i => $v)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $v->state }}</td>
            <td>{{ $v->vendor_agency_name }}</td>
            <td>{{ $v->contact_person }}</td>
            <td>{{ $v->contact_number }}</td>
            <td>{{ $v->email_id }}</td>
            <td>{{ $v->gst_number }}</td>
            <td>
                <a href="{{ url('admin/vendors/edit/'.$v->id) }}"
                    class="btn btn-sm btn-success">Edit</a>
                    <a href="{{route('admin.vendors.details.index', $v->id)}}" class="btn btn-sm btn-primary">View</a>

                @if($vendors->count() > 1)
                    <form action="{{ route('admin.vendors.destroy',$v->id) }}"
                        method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this vendor?')">
                            Del
                        </button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

@endsection

@push('scripts')
<script>
new DataTable('#vendorTable',{
    scrollX:true,
    responsive:false,
    autoWidth:false
});
</script>
@endpush
