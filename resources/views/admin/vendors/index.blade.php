@extends('layouts.admin')

@section('title','Vendor Expenses')

@section('content')

<h3 class="mb-3">Vendors</h3>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <table id="vendorTable" class="table class-table nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>State</th>
                        <th>Vendor Agency Name</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Email ID</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                @if($vendors->count())
    @foreach($vendors as $index => $v)
        <tr data-id="{{ $v->id }}">
            <td>{{ $index + 1 }}</td>

            <td>
                <select class="form-select state">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->name }}"
                            {{ $v->state == $state->name ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="text"
                       class="form-control vendor_agency_name"
                       value="{{ $v->vendor_agency_name }}">
            </td>

            <td>
                <input type="text"
                       class="form-control contact_person"
                       value="{{ $v->contact_person }}">
            </td>

            <td>
                <input type="text"
                       class="form-control contact_number"
                       value="{{ $v->contact_number }}">
            </td>

            <td>
                <input type="email"
                       class="form-control email_id"
                       value="{{ $v->email_id }}">
            </td>

            <td>
                <button class="btn btn-success btn-sm saveRow">Update</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>
    @endforeach
    @else
        {{-- EMPTY EDITABLE ROW --}}
        <tr>
            <td>1</td>

            <td>
                <select class="form-select state">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="text" class="form-control vendor_agency_name">
            </td>

            <td>
                <input type="text" class="form-control contact_person">
            </td>

            <td>
                <input type="text" class="form-control contact_number">
            </td>

            <td>
                <input type="email" class="form-control email_id">
            </td>

            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>
    @endif

                    </tbody>
                </table>

                <button id="addRow" class="btn btn-primary btn-sm mt-2 float-end">
                    + Add New Vendor
                </button>

            </div>
        </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // ADD NEW ROW
    $('#addRow').on('click', function () {
        let index = $('#vendorTable tbody tr').length + 1;

        let row = `
        <tr>
            <td>${index}</td>

            <td>
                <select class="form-select state">
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="text" class="form-control vendor_agency_name">
            </td>

            <td>
                <input type="text" class="form-control contact_person">
            </td>

            <td>
                <input type="text" class="form-control contact_number">
            </td>

            <td>
                <input type="email" class="form-control email_id">
            </td>

            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>
        `;

        $('#vendorTable tbody').append(row);
    });

    // SAVE ROW
    $(document).on('click', '.saveRow', function () {
        let row = $(this).closest('tr');
        let id  = row.data('id') || null;

        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('state', row.find('.state').val());
        formData.append('vendor_agency_name', row.find('.vendor_agency_name').val());
        formData.append('contact_person', row.find('.contact_person').val());
        formData.append('contact_number', row.find('.contact_number').val());
        formData.append('email_id', row.find('.email_id').val());

        $.ajax({
            url: id ? `/admin/vendors/${id}/update` : "{{ route('admin.vendors.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                
                alert('Saved successfully');
                window.location.reload()
                // if (!id) window.location.reload();
            },
            error: function () {
                alert('Error saving vendor');
            }
        });
    });

    // DELETE ROW
    $(document).on('click', '.removeRow', function () {
        let row = $(this).closest('tr');
        let id  = row.data('id');

        if (id) {
            if (confirm('Delete this vendor?')) {
                $.post(`/admin/vendors/${id}/destroy`,
                    {_token: "{{ csrf_token() }}"},
                    function () {
                        row.remove();
                        reindex();
                    }
                );
            }
        } else {
            row.remove();
            reindex();
        }
    });

    function reindex() {
        $('#vendorTable tbody tr').each(function (i) {
            $(this).find('td:first').text(i + 1);
        });
    }

    // DATATABLE
    new DataTable('#vendorTable', {
        scrollX: true,
        responsive: false,
        autoWidth: false
    });

});
</script>
@endpush
