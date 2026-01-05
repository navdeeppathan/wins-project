@extends('layouts.admin')

@section('title', 'Inventory')

@section('content')
@php
    $selectedProjectId = request('project_id');
@endphp

<h3 class="mb-3">
    Inventory (Office Contingency)
    @if($selectedProjectId)
        — <strong>{{ $projects->firstWhere('id', $selectedProjectId)->name }}</strong>
    @endif
</h3>

@if ($selectedProjectId)
<div class="row">

    <div class="col-md-4 mb-3">
        <label>Department</label>
        <input class="form-control"
               value="{{ $project->departments->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>State</label>
        <input class="form-control"
               value="{{ $project->state->name ?? '-' }}"
               disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>NIT Number</label>
        <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>

     <div class="col-md-12 mb-3">
        <label>Project Name</label>
        <input type="text" class="form-control" value="{{ $project->name }}" disabled>
    </div>

</div>

@endif

@php
    // $selectedProjectId = request('project_id');

    $categories = [
        'MATERIAL',
        'WAGES',
        'LOGISTIC',
        'MAINTENANCE',
        'OFFICE',
        'T&P',
        'FEE',
        'TOURS',
        'OTHERS',

    ];
@endphp

<style>
    /* ðŸ”¥ Allow full width inputs */
    #inventoryTable input.form-control,
    #inventoryTable select.form-select {
        min-width: 120px;
        width: 100%;
    }

    /* ðŸ”¥ Paid To & Narration extra wide */
    #inventoryTable td:nth-child(3) input,
    #inventoryTable td:nth-child(5) input {
        min-width: 140px;
    }

    /* ðŸ”¥ Disable text cutting */
    #inventoryTable input,
    #inventoryTable select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* ðŸ”¥ Horizontal scroll inside input */
    #inventoryTable input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #inventoryTable input::-webkit-scrollbar {
        height: 6px;
    }
</style>

<div class="table-responsive">
<table id="inventoryTable" class="table class-table nowrap" style="width:100%">
    <thead class="table-light">
    <tr>
        <th>#</th>
        {{-- <th>Project</th> --}}
        <th>Date</th>
        <th>Paid To</th>
        <th>Category</th>

        <th>Voucher Number</th>
         <th>Description of Item</th>
        <th>Quantity</th>
        <th>Rate</th>
        <th>Deduction</th>
        <th>Net Payment</th>
        <th>Upload</th>
        <th width="">Action</th>
    </tr>
    </thead>

    <tbody>
        @forelse($items as $index => $i)
            <tr data-id="{{ $i->id }}">
                <td>{{ $index + 1 }}</td>

                {{-- PROJECT --}}
                {{-- <td>
                    @if($selectedProjectId)
                        <strong>{{ $projects->firstWhere('id',$selectedProjectId)->name }}</strong>
                        <input type="hidden" class="project_id" value="{{ $selectedProjectId }}">
                    @else
                        <select class="form-select project_select">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ $i->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </td> --}}

                <td><input type="date" class="form-control date" value="{{ $i->date }}"></td>


                {{-- <td><input type="text" class="form-control paid_to" value="{{ $i->paid_to }}"></td> --}}
                <td width="">
                    <select class="form-select paid_to">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->vendor_agency_name }}"
                                {{ $i->paid_to == $vendor->vendor_agency_name ? 'selected' : '' }}>
                                {{ $vendor->vendor_agency_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-select category">
                        <option value="">Select</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $i->category === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </td>


                <td><input type="text" class="form-control voucher" value="{{ $i->voucher }}"></td>
                <td><input type="text" class="form-control description" value="{{ $i->description }}"></td>
                <td><input type="number" step="0.01" class="form-control quantity" value="{{ $i->quantity }}"></td>
                <td><input type="number" step="0.01" class="form-control amount" value="{{ $i->amount }}"></td>
                <td><input type="number" step="0.01" class="form-control deduction" value="{{ $i->deduction }}"></td>

                <td class="net_payable">{{ number_format($i->net_payable,2) }}</td>

                <td>
                    @if($i->upload)
                        <a href="{{ asset($i->upload) }}" target="_blank"
                        class="btn btn-sm btn-outline-primary mb-1">View</a>
                    @endif
                    <input type="file" class="form-control upload">
                </td>

                <td>

                    <button class="btn btn-success btn-sm saveRow">Saved</button>
                    <button class="btn btn-danger btn-sm removeRow">Del</button>
                </td>
            </tr>
        @empty
            <tr>
                <td>1</td>

                {{-- <td>
                    <select class="form-select project_select">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </td> --}}

                <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
                <td>
                    <select class="form-select paid_to">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->vendor_agency_name }}">
                                {{ $vendor->vendor_agency_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-select category">
                        <option value="">Select</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $cat === 'T&P' ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td><input type="text" class="form-control description"></td>

                <td><input type="text" class="form-control voucher"></td>
                <td><input type="number" class="form-control quantity"></td>
                <td><input type="number" class="form-control amount"></td>
                <td><input type="number" class="form-control deduction"></td>
                <td class="net_payable">0.00</td>
                <td><input type="file" class="form-control upload"></td>

                <td>
                    <button class="btn btn-success btn-sm saveRow">Save</button>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="d-flex align-items-center justify-content-end">

<button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>

</div>
@endsection

@push('scripts')
<script>
$(function () {

    let selectedProjectId = "{{ $selectedProjectId }}";

    // ADD ROW
    $('#addRow').click(function () {

        let index = $('#inventoryTable tbody tr').length + 1;

        let projectCell = selectedProjectId
            ? `<strong>{{ $selectedProjectId ? $projects->firstWhere('id',$selectedProjectId)->name : '' }}</strong>
               <input type="hidden" class="project_id" value="${selectedProjectId}">`
            : `<select class="form-select project_select">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
               </select>`;

        let row = `
        <tr>
            <td>${index}</td>

            <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
            <td>
                    <select class="form-select paid_to">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->vendor_agency_name }}">
                                {{ $vendor->vendor_agency_name }}
                            </option>
                        @endforeach
                    </select>
            </td>
            <td>
                <select class="form-select category">
                    <option value="">Select</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control description"></td>

            <td><input type="text" class="form-control voucher"></td>
            <td><input type="number" class="form-control quantity"></td>
            <td><input type="number" class="form-control amount"></td>
            <td><input type="number" class="form-control deduction"></td>
            <td class="net_payable">0.00</td>
            <td><input type="file" class="form-control upload"></td>
            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>`;

        $('#inventoryTable tbody').append(row);
    });

    // NET PAYABLE
    $(document).on('input', '.amount, .deduction', function () {
        let row = $(this).closest('tr');
        let a = parseFloat(row.find('.amount').val()) || 0;
        let c = parseFloat(row.find('.quantity').val()) || 0;
        let d = parseFloat(row.find('.deduction').val()) || 0;
        row.find('.net_payable').text((a * c - d).toFixed(2));
    });

    // SAVE
    $(document).on('click', '.saveRow', function () {

        let row = $(this).closest('tr');
        let id  = row.data('id') || null;

        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");

        // ✅ SINGLE SOURCE OF PROJECT_ID
        let projectId = row.find('.project_id').length
            ? row.find('.project_id').val()
            : row.find('.project_select').val();

        // formData.append('project_id', projectId);
        formData.append('date', row.find('.date').val());
        formData.append('category', row.find('.category').val());
        formData.append('description', row.find('.description').val());
        formData.append('paid_to', row.find('.paid_to').val());
        formData.append('voucher', row.find('.voucher').val());
        formData.append('quantity', row.find('.quantity').val());
        formData.append('amount', row.find('.amount').val());
        formData.append('deduction', row.find('.deduction').val());

        let file = row.find('.upload')[0];
        if (file && file.files.length) {
            formData.append('upload', file.files[0]);
        }

        $.ajax({
            url: id
                ? `/admin/inventory/${id}/update`
                : "{{ route('admin.inventory.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                location.reload();
            }
        });
    });

    // DELETE
    $(document).on('click', '.removeRow', function () {
        let row = $(this).closest('tr');
        let id  = row.data('id');

        if (id) {
            if (confirm('Delete this item?')) {
                $.post(`/admin/inventory/${id}/destroy`,
                    { _token: "{{ csrf_token() }}" },
                    function () { row.remove(); }
                );
            }
        } else {
            row.remove();
        }
    });

});


 new DataTable('#inventoryTable', {
        scrollX: true,
        scrollY:        600,
        deferRender:    true,
        scroller:       true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,
        fixedHeader: true,


        /* 🔥 GUARANTEED ROW COLOR FIX */
        createdRow: function (row, data, index) {
            let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
             let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

            $(row).off('mouseenter mouseleave').hover(
                () => $('td', row).css('background-color', '#e9ecff'),
                () => $('td', row).css('background-color', base)
            );
        }


    });
</script>
@endpush
