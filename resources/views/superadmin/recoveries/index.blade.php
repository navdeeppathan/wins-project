@extends('layouts.superadmin')

@section('title','Billing')

@section('content')

<h3 class="mb-3">Recoveries</h3>
@if(isset($recoveries) && $recoveries->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered class-table nowrap" id="recoveryTable" style="width:100%">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Security (2.5%)</th>
                    <th>Income Tax (2%)</th>
                    <th>Labour Cess (1%)</th>
                    <th>Water Charges (1%)</th>
                    <th>License Fee</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>Withheld 1</th>
                    <th>Withheld 2</th>
                    <th>Recovery</th>
                    <th>Total</th>
                    
                </tr>
            </thead>

            <tbody id="recoveryBody">
            @foreach($recoveries as $index => $r)
                <tr >
                    <td>{{ $index+1 }}</td>

                    <td>{{ $r->security }}</td>
                    <td>{{ $r->income_tax }}</td>
                    <td>{{ $r->labour_cess }}</td>
                    <td>{{ $r->water_charges }}</td>

                    <td>{{ $r->license_fee }}</td>

                    <td>{{ $r->cgst }}</td>
                    <td>{{ $r->sgst }}</td>

                    <td>{{ $r->withheld_1 }}</td>
                    <td>{{ $r->withheld_2 }}</td>

                    <td>{{ $r->recovery }}</td>

                    <td>
                        {{ $r->total }}
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
    @include('superadmin.security_deposites.index')
</div>

@push('scripts')
<script>
    new DataTable('#recoveryTable', {
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

@endsection