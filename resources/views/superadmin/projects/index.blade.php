@extends('layouts.superadmin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects</h3>
</div>

@if($projects->count() > 0)

<div class="table-responsive">
    <table id="projectTable" class="table class-table nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate Amt</th>
                <th>Date of Opening</th>
                <th>Location</th>
                <th>Department</th>
                <th>EMD Amt</th>


                <th width="160">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($projects as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->nit_number }}</td>
                <td>{{ number_format($p->estimated_amount,2) }}</td>
                <td>{{ $p->date_of_opening }}</td>
                <td>{{ $p->state->name ?? '-' }}</td>
                <td>{{ $p->departments->name ?? '-' }}</td>
                <td>{{ number_format($p->emds->sum('amount'),2) }}</td>


                <td>
                    <a href="{{ route('superadmin.projects.edit', $p) }}"
                       class="btn btn-warning btn-sm">
                       <i class="fas fa-eye me-2"></i>
                    </a>

                 </td>
            </tr>
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

    new DataTable('#projectTable', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,

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
