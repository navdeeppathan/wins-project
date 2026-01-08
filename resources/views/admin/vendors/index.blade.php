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
            <th class="text-center">#</th>
            <th class="text-center">State</th>
            <th class="text-center">Vendor Agency</th>
            <th class="text-center">Contact Person</th>
            <th class="text-center">Contact No</th>
            <th class="text-center">Email</th>
            <th class="text-center">GST</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($vendors as $i => $v)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td class="text-center">{{ $v->state }}</td>
            <td class="text-center">{{ $v->vendor_agency_name }}</td>
            <td class="text-center">{{ $v->contact_person }}</td>
            <td class="text-center">{{ $v->contact_number }}</td>
            <td class="text-center">{{ $v->email_id }}</td>
            <td class="text-center">{{ $v->gst_number }}</td>
            <td class="text-center">
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
