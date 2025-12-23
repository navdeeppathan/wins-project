@extends('layouts.admin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Bidding)</h3>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        + Create Project
    </a>
</div>

@if($projects->count() > 0)

<div class="table-responsive">
    <table id="projectTable" class="table class-table nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                
                <th>Date of Opening</th>
                <th>Location</th>
                <th>Department</th>
                <th>Estimate Amount</th>
                <th>EMD Amount</th>
                <th>Qualified</th>
                <th>Save</th>
                {{-- <th>Status</th> --}}

                <th width="160">Actions</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @php
                $i=1;
            @endphp
            @foreach($projects as $p)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $p->name }}</td>
                <td class="text-center">{{ $p->nit_number }}</td>
                <td>{{ date('d-m-y', strtotime($p->date_of_opening)) }}</td>
                <td>{{ $p->state->name ?? '-' }}</td>
                <td>{{ $p->departments->name ?? '-' }}</td>
                <td class="text-center">{{ number_format($p->estimated_amount,2) }}</td>

                <td class="text-center">{{ number_format($p->emds->sum('amount'),2) }}</td>

                <td class="text-center">
                    <input type="checkbox"
                        class="form-check-input isQualifiedBox"
                        data-id="{{ $p->id }}"
                        {{ $p->isQualified ? 'checked' : '' }}>
                </td>

                <td class="text-center">
                    <button class="btn btn-success btn-sm saveQualifiedBtn"
                        data-id="{{ $p->id }}">
                        Save
                    </button>
                </td>

                {{-- <td>
                    <span class="badge bg-info">
                        {{ ucfirst($p->status) }}
                    </span>
                </td> --}}

                <td>
                    <a href="{{ route('admin.projects.edit', $p) }}"
                       class="btn btn-warning btn-sm">Edit</a>

                   <a href="{{ route('admin.inventory.index') }}?project_id={{ $p->id }}" 
                        class="btn btn-secondary btn-sm">
                        Inventory
                    </a>

                </td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>

@else
<div class="alert alert-warning text-center">
    Data is not available.
</div>
@endif

@endsection


{{-- ================= STYLES ================= --}}
@push('styles')
<style>


        /* ================= WRAPPER ================= */
        .table-responsive {
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            padding: 10px;
            cursor: pointer;
        }

        /* ================= HEADER ================= */
        .dataTables_scrollHead thead th,
        .class-table thead th {
            background: #6f7ae0 !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 14px;
            padding: 14px 16px;
            border: none !important;
           

        }

        /* ================= CRITICAL FIX ================= */
        /* OVERRIDE BOOTSTRAP 5 TABLE BACKGROUND */
        .table.class-table > :not(caption) > tbody > tr:nth-child(odd) > * {
            background-color: #f7f8ff !important;
        }

        .table.class-table > :not(caption) > tbody > tr:nth-child(even) > * {
            background-color: #ffffff !important;
        }

        .table.class-table > :not(caption) > tbody > tr:hover > * {
            background-color: #c6ccfd !important;
        }

        /* ================= BODY CELLS ================= */
        .table.class-table tbody td {
            padding: 14px 16px;
            font-size: 13px;
            color: #555;
            border: none !important;
            vertical-align: middle;
        }

        /* ================= BUTTON ================= */
        .class-table .btn-success {
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 12px;
        }

        /* ================= BADGE ================= */
        .class-table .badge {
            border-radius: 12px;
            padding: 6px 10px;
            font-size: 12px;
        }

        /* ================= PAGINATION ================= */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #f0f2ff !important;
            border: none !important;
            border-radius: 6px !important;
            margin: 0 3px;
            padding: 6px 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6f7ae0 !important;
            color: #fff !important;
        }

        /* ================= SEARCH ================= */
        .dataTables_filter input {
            border-radius: 20px;
            padding: 6px 12px;
            border: 1px solid #ddd;
        }

        /* ================= SCROLL ================= */
        .dataTables_scrollBody {
            max-height: 420px;
        }

        /* ================= OPTIONAL: ROUNDED ROWS ================= */
        .table.class-table tbody tr td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table.class-table tbody tr td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

</style>
@endpush

{{-- ================= SCRIPTS ================= --}}
@push('scripts')
<script>
    $(document).on('click', '.saveQualifiedBtn', function () {

        let id = $(this).data('id');
        let isQualified = $(this)
            .closest('tr')
            .find('.isQualifiedBox')
            .is(':checked') ? 1 : 0;

        $.ajax({
            url: "/admin/projects/update-qualified/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                isQualified: isQualified,
            },
            success: function () {
                alert("Updated Successfully");
            }
        });
    });

    new DataTable('#projectTable', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,
       layout: {
        topStart: {
            buttons: [ 'excel', 'pdf', 'colvis']
        }
    },

        /* 🔥 GUARANTEED ROW COLOR FIX */
        createdRow: function (row, data, index) {
            let bg = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
            let base = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';

            $(row).off('mouseenter mouseleave').hover(
                () => $('td', row).css('background-color', '#e9ecff'),
                () => $('td', row).css('background-color', base)
            );
        }

        
    });
</script>
@endpush
