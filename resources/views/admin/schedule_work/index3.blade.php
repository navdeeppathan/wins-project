@extends('layouts.admin')
@section('title','Schedule Of Work')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<h4 class="mb-3">Schedule Of Work – {{ $project->name }}</h4>

@php
    $estimated = (float) $project->estimated_amount;
    $tendered  = (float) $project->tendered_amount;

    $percentageText = '-';
    if ($estimated > 0 && $tendered > 0) {
        $percentage = round((($estimated - $tendered) / $estimated) * -100, 2);
        $percentageText = $percentage < 0
            ? abs($percentage).' % BELOW'
            : $percentage.' % ABOVE';
    }
@endphp

{{-- PROJECT INFO --}}
<div class="row mb-4">
    <div class="col-md-4 mb-2">
        <label>Department</label>
        <input class="form-control" value="{{ $project->departments->name ?? '-' }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>State</label>
        <input class="form-control" value="{{ $project->state->name ?? '-' }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>NIT Number</label>
        <input class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>
{{--
    <div class="col-md-12 mb-2">
        <label>Project Name</label>
        <input class="form-control" value="{{ $project->name }}" disabled>
    </div> --}}

    <div class="col-md-4 mb-2">
        <label>Estimated Amount</label>
        <input class="form-control" value="{{ $project->estimated_amount }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Time Allowed</label>
        <input class="form-control" value="{{ $project->time_allowed_number }} {{ $project->time_allowed_type }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Tender Amount</label>
        <input class="form-control" value="{{ $project->tendered_amount }}" disabled>
    </div>


   <div class="col-md-4 mb-2">
        <label>Date of Start</label>
        <input class="form-control" disabled
            value="{{
                $project->date_ofstartof_work
                    ? date('d-m-Y', strtotime($project->date_ofstartof_work))
                    : $project->created_at->format('d-m-Y')
            }}">
    </div>
    <div class="col-md-4 mb-2">
        <label>Date of Completion</label>
        <input class="form-control" disabled
            value="{{
                $project->stipulated_date_ofcompletion
                    ? date('d-m-Y', strtotime($project->stipulated_date_ofcompletion))
                    : $project->created_at->format('d-m-Y')
            }}">
    </div>
    <div class="col-md-4 mb-2">
        <label>Percentage</label>
        <input class="form-control {{ str_contains($percentageText,'BELOW')?'text-danger':'text-success' }}"
               value="{{ $percentageText }}" disabled>
    </div>
</div>

{{-- TABLE --}}
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center">QUANTITY</th>
                <th class="text-center">UNIT</th>
                <th class="text-center">RATE</th>
                <th class="text-center">AMOUNT</th>
                <th class="text-center">Total Amount</th>
                <th class="text-center">Qty Issued</th>
            </tr>
        </thead>
        <tbody id="workTable">
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">{{ $scheduleWork->description }}</td>
                <td class="text-center">{{ $scheduleWork->quantity }}</td>
                <td class="text-center">{{ $scheduleWork->unit }}</td>
                <td class="text-center">{{ number_format($scheduleWork->rate, 2) }}</td>
                <td class="text-center">{{ number_format($scheduleWork->amount, 2) }}</td>
                <td class="text-center">{{ $totalnetpayable }}</td>
                <td class="text-center">{{ $scheduleWork->measured_quantity }}</td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
</div>



@php

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

    #inventoryTable input.form-control,
    #inventoryTable select.form-select {
        min-width: 120px;
        width: 100%;
    }

    #inventoryTable td:nth-child(3) input,
    #inventoryTable td:nth-child(5) input {
        min-width: 140px;
    }

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


<div class="table-responsive mt-3">
    <table id="inventoryTable" class="table class-table nowrap" style="width:100%">
        <thead class="table-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">DATE</th>
                <th class="text-center">STAFF</th>
                <th class="text-center">CATEGORY</th>
                <th class="text-center">DESCRIPTION OF ITEM</th>
                <th class="text-center">AMOUNT</th>
                <th class="text-center" width="">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventories as $index => $i)
                <tr data-id="{{ $i->id }}">
                    <td>
                        {{ $index + 1 }}
                        <input type="hidden" class="project_id" value="{{ $project->id }}">
                        <input type="hidden" class="schedule_work_id" value="{{ $scheduleWork->id }}">
                    </td>

                    <td><input type="date" class="form-control date" value="{{ $i->date }}"></td>
                    <td width="">
                        <select class="form-select staff_id">
                            <option value="">Select Staff</option>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}"
                                    {{ $i->staff_id == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
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
                    <td>
                        <select class="form-select description" data-selected="{{ $i->description }}">
                            <option value="">Select description</option>
                        </select>
                        <input type="hidden" class="form-control quantity" value="1">
                        <input type="hidden" class="form-control amount" value="1">
                    </td>
                    <td><input type="number" step="0.01" class="form-control net_payable" value="{{ $i->net_payable }}"></td>
                    <td>
                        <button class="btn btn-success btn-sm saveRow">Update</button>
                        <button class="btn btn-danger btn-sm removeRow">Del</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        1
                        <input type="hidden" class="project_id" value="{{ $project->id }}">
                        <input type="hidden" class="schedule_work_id" value="{{ $scheduleWork->id }}">
                    </td>

                    <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>
                    <td width="">
                        <select class="form-select staff_id">
                            <option value="">Select Staff</option>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}">
                                    {{ $staff->name }}
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
                    <td>
                        <select class="form-select description">
                            <option value="">Select description</option>
                        </select>
                        <input type="hidden" class="form-control quantity" value="1">
                        <input type="hidden" class="form-control amount" value="1">
                    </td>

                    <td><input type="number" class="form-control net_payable"></td>
                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-end gap-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm mt-2">
        Back
    </a>
    <button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>
</div>

@push('scripts')
<script>
    const allInventories = @json($allInventories);
</script>


<script>
    $(function () {

        let selectedProjectId = "{{ $project->id }}";
        let schedule_workId = "{{ $scheduleWork->id }}";

        // ADD ROW
        $('#addRow').click(function () {

            let index = $('#inventoryTable tbody tr').length + 1;

            let row = `
            <tr>
                <td>${index}</td>
                <input type="hidden" class="project_id" value="${selectedProjectId}">
                <input type="hidden" class="schedule_work_id" value="${schedule_workId}">
                <td><input type="date" class="form-control date" value="{{ date('Y-m-d') }}"></td>

                <td width="">
                    <select class="form-select staff_id">
                        <option value="">Select Staff</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">
                                {{ $staff->name }}
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
                <td>
                    <select class="form-select description">
                        <option value="">Select description</option>
                    </select>
                </td>



                <input type="number" class="form-control quantity">
                <input type="number" class="form-control amount">
                <td><input type="number" class="form-control net_payable"></td>

                <td>
                    <button class="btn btn-success btn-sm saveRow">Save</button>
                    <button class="btn btn-danger btn-sm removeRow">Del</button>
                </td>
            </tr>`;

            $('#inventoryTable tbody').append(row);
        });

        // SAVE
        $(document).on('click', '.saveRow', function () {

            let row = $(this).closest('tr');
            let id  = row.data('id') || null;

            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");

            // âœ… SINGLE SOURCE OF PROJECT_ID
            let projectId = row.find('.project_id').length
                ? row.find('.project_id').val()
                : row.find('.project_select').val();

            let schedule_work_id = row.find('.schedule_work_id').val()

            formData.append('project_id', projectId);
            formData.append('schedule_work_id', schedule_work_id);
            formData.append('date', row.find('.date').val());
            formData.append('category', row.find('.category').val());
            formData.append('description', row.find('.description').val());
            formData.append('quantity', row.find('.quantity').val());
            formData.append('amount', row.find('.amount').val());
            formData.append('net_payable', row.find('.net_payable').val());
            formData.append('staff_id', row.find('.staff_id').val());

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
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,
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

<script>
    document.addEventListener('change', function (e) {

        // CATEGORY CHANGE
        if (e.target.classList.contains('category')) {

            let row = e.target.closest('tr');
            let category = e.target.value;

            let descSelect = row.querySelector('.description');
            let qtyInput  = row.querySelector('.quantity');

            // reset
            descSelect.innerHTML = '<option value="">Select description</option>';
            // qtyInput.value = '';

            if (!category) return;

            // filter inventories by category
            let matches = allInventories.filter(inv => inv.category === category);

            matches.forEach(inv => {
                let opt = document.createElement('option');
                opt.value = inv.description;
                opt.textContent = inv.description;
                opt.dataset.quantity = inv.quantity;
                opt.dataset.amount = inv.amount;
                descSelect.appendChild(opt);
            });
        }

        // DESCRIPTION CHANGE → autofill quantity
        if (e.target.classList.contains('description')) {

            let row = e.target.closest('tr');
            let selectedOption = e.target.selectedOptions[0];

            if (!selectedOption) return;

            let qty = selectedOption.dataset.quantity ?? '';
            let amount = selectedOption.dataset.amount ?? '';
            row.querySelector('.quantity').value = qty;
            row.querySelector('.amount').value = amount;
        }

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#inventoryTable tbody tr').forEach(row => {

            let categorySelect = row.querySelector('.category');
            let descSelect     = row.querySelector('.description');
            let qtyInput       = row.querySelector('.quantity');

            if (!categorySelect || !descSelect) return;

            let category = categorySelect.value;
            let selectedDesc = descSelect.dataset.selected;

            if (!category) return;

            descSelect.innerHTML = '<option value="">Select description</option>';

            let matches = allInventories.filter(inv => inv.category === category);

            matches.forEach(inv => {
                let opt = document.createElement('option');
                opt.value = inv.description;
                opt.textContent = inv.description;
                opt.dataset.quantity = inv.quantity;

                if (inv.description === selectedDesc) {
                    opt.selected = true;
                    qtyInput.value = inv.quantity;
                }

                descSelect.appendChild(opt);
            });

        });
    });
</script>



@endpush




@endsection
