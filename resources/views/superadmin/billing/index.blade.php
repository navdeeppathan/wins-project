@extends('layouts.superadmin')

@section('title','Billing')

@section('content')
<h3 class="mb-2">Billings</h3>



<style>

    /* 🔥 Disable text cutting */
    #billingTable input,
    #billingTable select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    #billingTable input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #billingTable input::-webkit-scrollbar {
        height: 6px;
    }
</style>

@if(isset($billings) && $billings->count() > 0)
    <div class="table-responsive">
        <table id="billingTable" class="table table-bordered class-table nowrap dataTable">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">BILL NUMBER</th>
                    <th class="text-center">BILL TYPE</th>
                    <th class="text-center">BILL DATE</th>
                    <th class="text-center">MB NO</th>
                    <th class="text-center">PAGE</th>
                    <th class="text-center">GROSS AMOUNT</th>
                    <th class="text-center">RECOVERIES</th>
                    <th class="text-center">NET PAYABLE</th>
                    <th class="text-center" >COMPLETION DATE</th>
                    <th class="text-center">ACTION</th>
                </tr>
            </thead>

            <tbody>
                @foreach($billings as $index => $bill)

                    <tr data-id="{{ $bill->id }}">
                        <td>{{ $index+1 }}</td>

                        <td>{{ $bill->bill_number }}</td>

                        <td>
                            {{ $bill->bill_type }}
                        </td>

                        <td>{{ date('d-m-Y', strtotime($bill->bill_date)) ?? '-' }}</td>
                        <td>{{ $bill->mb_number }}</td>
                        <td>{{ $bill->page_number }}</td>
                        <td>{{ $bill->gross_amount }}</td>

                        <td>
                            {{ number_format($bill->recoveries_sum_total ?? 0, 2) }}
                            
                        </td>

                        <td>{{ $bill->net_payable }}</td>
                        
                       

                        <td  >
                            {{ $bill->completion_date }}
                        </td>
                         <td>
                           
                            {{-- <a href="{{ route('admin.projects.recoveries.index', [$project->id, $bill->id]) }}" class="btn btn-primary btn-sm">Recoveries</a> --}}
                        </td>
                    </tr>
               
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-warning text-center">
        No  data found.
    </div>
@endif

<div class="mt-4">
    @include('superadmin.projects.emdspg')
</div>

<div class="mt-4">
    @include('superadmin.schedule_of_work.index')
</div>
@endsection





@push('scripts')

<script>
    new DataTable('#billingTable', {
        scrollX: true,
        scrollCollapse: true,
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
