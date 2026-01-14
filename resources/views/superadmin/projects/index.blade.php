@extends('layouts.superadmin')
@section('title','Projects')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Projects</h3>
    </div>



    @if($projects->count() > 0)
        <div class="table-responsive">
            <table id="example"  class="table class-table nowrap">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">NIT No</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Estimate Amt</th>
                        <th class="text-center">EMD Amt</th>
                        <th class="text-center">Date of Opening</th>
                        <th class="text-center">Actions</th>
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
                                <td class="text-center">{{ $p->departments->name ?? '-' }}</td>
                                <td class="text-center">{{ number_format($p->estimated_amount,2) }}</td>

                                <td class="text-center">{{ number_format($p->emd_amount,2) }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($p->date_of_opening)) ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('superadmin.users.projects.allbillings', $p->id) }}"
                                           class="btn btn-sm btn-primary">Billings</a> 
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


    <div class="mt-4">
        @include('superadmin.inventory.index')
    </div>
    <div class="mt-4">
        @include('superadmin.daily_notes.index')
    </div>
@endsection
