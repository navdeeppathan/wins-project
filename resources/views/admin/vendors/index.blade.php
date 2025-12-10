@extends('layouts.admin')

@section('title','Vendors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Vendors</h3>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Add Vendor</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vendors.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">GST No</label>
                        <input type="text" name="gst_number" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">PAN No</label>
                        <input type="text" name="pan_number" class="form-control">
                    </div>
                    <button class="btn btn-primary btn-sm">Save Vendor</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>GST</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $v)
                    <tr>
                        <td>{{ $v->id }}</td>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->contact_person }}</td>
                        <td>{{ $v->phone }}</td>
                        <td>{{ $v->gst_number }}</td>
                        <td>
                            <form action="{{ route('admin.vendors.destroy', $v) }}" method="POST"
                                  onsubmit="return confirm('Delete vendor?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Del</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No vendors.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $vendors->links() }}
    </div>
</div>
@endsection
