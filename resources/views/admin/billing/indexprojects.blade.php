@extends('layouts.admin')

@section('title','Projects Billing')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Billing</h3>
</div>

@if($projects->count() > 0)
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>NIT No</th>
                <th>Location</th>
                <th>Department</th>
                <th>Estimated</th>
                <th>Date of Opening</th>
                <th width="">Actions</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($projects as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->nit_number }}</td>
                    <td>{{  $p->state->name ?? '-' }}</td>
                    <td>{{ $p->departments->name }}</td>
                    <td>{{ number_format($p->estimated_amount,2) }}</td>
                    <td>{{ date('d-m-y', strtotime($p->date_of_opening)) ?? '-' }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.projects.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                        <a href="{{ route('admin.projects.billing.index', $p) }}" class="btn btn-sm btn-secondary">
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
