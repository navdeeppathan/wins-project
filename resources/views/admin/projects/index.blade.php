@extends('layouts.admin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Bidding)</h3>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        + Create Project
    </a>
</div>
{{-- <form method="GET" action="{{ route('admin.projects.index') }}">
    <div class="row mb-3">
        <div class="col-md-3">
            <label class="fw-bold">Filter by Year (Created)</label>
            <select name="year" class="form-select" onchange="this.form.submit()">
                <option value="">All Years</option>
                @for($y = 2025; $y <= 2050; $y++)
                    <option value="{{ $y }}"
                        {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form> --}}

@php
    use Carbon\Carbon;

    $startFY = 2011;

    $today = Carbon::today();
    $currentFY = $today->month >= 4
        ? $today->year
        : $today->year - 1;
@endphp

<form method="GET" action="{{ route('admin.projects.index') }}">
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="fw-bold">Filter by Financial Year</label>
            <select name="fy" class="form-select" onchange="this.form.submit()">
                <option value="">All Financial Years</option>

                @for ($fy = $startFY; $fy <= $currentFY; $fy++)
                    @php $label = $fy . '-' . ($fy + 1); @endphp
                    <option value="{{ $fy }}"
                        {{ request('fy') == $fy ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</form>

@if($projects->count() > 0)

    <div class="table-responsive">
        <table id="projectTable" class="table table-bordered class-table nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>NIT No</th>
                    {{-- <th>Location</th>
                    <th>Department</th> --}}
                    <th>Date of Opening</th>
                    <th>Estimate Amt</th>
                    <th>EMD Amt</th>
                    <th>Qualified</th>

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
                <td class="text-start">
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $p->name), 10)
                        )) !!}
                    </td>




                    <td class="text-start">{{ $p->nit_number }}</td>
                    {{-- <td>{{ $p->state->name ?? '-' }}</td>
                    <td>{{ $p->departments->name ?? '-' }}</td> --}}
                    <td>{{ date('d-m-Y', strtotime($p->date_of_opening)) }}</td>
                    <td class="text-center">{{ number_format($p->estimated_amount,2) }}</td>
                    <td class="text-center">{{ number_format($p->emds->sum('amount'),2) }}</td>
                    {{-- @if ($p->isQualified==0) --}}
                    <td class="text-center">

                        <input type="checkbox"
                            class="form-check-input isQualifiedBox"
                            data-id="{{ $p->id }}"
                            {{ $p->isQualified ? 'checked' : '' }}>
                    &nbsp;&nbsp;
                        <button class="btn btn-success btn-sm saveQualifiedBtn"
                            data-id="{{ $p->id }}">
                            Save
                        </button>
                    </td>
                    {{-- @else
                    <td  class="text-center ">
                        <span class="badge bg-success">Qualified</span>
                    </td>

                    @endif --}}

                    <td>
                        <a href="{{ route('admin.projects.edit', $p) }}"
                        class="btn btn-warning btn-sm">Edit</a>

                    <a href="{{ route('admin.inventory.index') }}?project_id={{ $p->id }}"
                            class="btn btn-primary btn-sm">
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
        Data is not available. Start Your Projects.
    </div>
@endif

@endsection


{{-- ================= STYLES ================= --}}


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
                window.location.reload();
                alert("Updated Successfully");

            }
        });
    });

    new DataTable('#projectTable', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: true,
        layout: {
            topStart: {
                buttons: [ 'pdf', 'colvis']
            }
        },

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
