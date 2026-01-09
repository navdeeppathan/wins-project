@extends('layouts.admin')

@section('title','Projects Billing')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Billing</h3>
</div>
{{-- <form method="GET" action="{{ route('admin.indexprojects') }}">
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

<form method="GET" action="{{ route('admin.indexprojects') }}">
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
    <table id="example" class="table class-table nowrap" style="width:100%">
        <thead class="table-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">NIT No</th>
                <th class="text-center">Location</th>
                <th class="text-center">Department</th>
                <th class="text-center">Estimated</th>
                <th class="text-center">Date of Opening</th>
                <th class="text-center" width="">Actions</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td style="
                            text-align: justify;
                            text-align-last: justify;
                            text-justify: inter-word;
                            hyphens: auto;
                            word-break: break-word;
                        ">
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $p->name), 10)
                        )) !!}
                    </td>
                    <td class="text-center">{{ $p->nit_number }}</td>
                    <td class="text-center">{{  $p->state->name ?? '-' }}</td>
                    <td class="text-center">{{ $p->departments->name }}</td>
                    <td class="text-center">{{ number_format($p->estimated_amount,2) }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($p->date_of_opening)) ?? '-' }}</td>
                    <td class="text-center">
                        {{-- <a href="{{ route('admin.projects.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                        <a href="{{ route('admin.projects.billing.index', $p) }}" class="btn btn-sm btn-primary">
                            Billing
                        </a>
                    </td>
                </tr>
                 @php
                $i++;
            @endphp
            @empty
                <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
@endif

{{ $projects->links() }}
@endsection
