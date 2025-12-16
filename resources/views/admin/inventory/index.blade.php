@extends('layouts.admin')

@section('title','Inventory')

@section('content')
<h3 class="mb-3">Inventory</h3>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Add Inventory Item</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inventory.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Item Name *</label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Quantity *</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Project ID (optional)</label>
                        <input type="number" name="project_id" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Vendor ID (optional)</label>
                        <input type="number" name="vendor_id" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2"></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <table class="table table-sm table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Project</th>
                    <th>Vendor</th>
                    <th>Remarks</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    <tr>
                        <td>{{ $i->id }}</td>
                        <td>{{ $i->item_name }}</td>
                        <td>{{ $i->quantity }}</td>
                        <td>{{ $i->project_id }}</td>
                        <td>{{ $i->vendor_id }}</td>
                        <td>{{ $i->remarks }}</td>
                        <td>
                            {{-- <form action="{{ route('admin.inventory.destroy', $i) }}" method="POST"
                                  onsubmit="return confirm('Delete item?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Del</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No inventory.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $items->links() }}
    </div>
</div>
@endsection
