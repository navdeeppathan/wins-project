@extends('layouts.admin')

@section('title','User Details')

@section('content')

<h3 class="mb-3">User Details</h3>

<div class="row">

    {{-- STATE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">State</label>
        <input type="text"
               class="form-control"
               value="{{ $user->state ?? '-' }}"
               disabled>
    </div>

   <div class="col-md-6 mb-3">
        <label class="form-label">Balance</label>
        <input type="text"
            class="form-control fw-bold"
            style="background:#fff3cd"
            value="₹ {{ number_format($balanceAmount, 2) }}"
            readonly>
    </div>


    {{-- USER NAME --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text"
               class="form-control"
               value="{{ $user->name }}"
               disabled>
    </div>

    {{-- CONTACT NUMBER --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Contact Number</label>
        <input type="text"
               class="form-control"
               value="{{ $user->phone ?? '-' }}"
               disabled>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               class="form-control"
               value="{{ $user->email }}"
               disabled>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Total Due Amount</label>
        <input type="text"
            class="form-control"
            value="₹ {{ number_format($totalNetPayable, 2) }}"
            readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Total Paid</label>
        <input type="text"
            class="form-control"
            value="₹ {{ number_format($totalPaidNetPayable, 2) }}"
            readonly>
    </div>
   
</div>





<h3 class="mb-3">
    Inventories
</h3>



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
@if($inventories->count() > 0)

<div class="table-responsive">
<table id="inventoryTable" class="table class-table nowrap" style="width:100%">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Paid To</th>
            
            <th>Category</th>
            <th>Voucher Number</th>
            <th>Description of Item</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Amount</th>
           
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($inventories as $index => $i)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $i->date }}</td>
                <td>{{ $i->paid_to ?? '-' }}</td>
                
                <td>{{ $i->category ?? '-' }}</td>
                <td>{{ $i->voucher ?? '-' }}</td>
                <td>{{ $i->description ?? '-' }}</td>
                <td>{{ $i->quantity }}</td>
                <td>₹ {{ number_format($i->amount, 2) }}</td>
                <td>₹ {{ number_format($i->net_payable, 2) }}</td>
                
                <td>
                    <button class="btn btn-success btn-sm approveBtn"
                            data-id="{{ $i->id }}"
                            {{ $i->isApproved == 1 ? 'disabled' : '' }}>
                        {{ $i->isApproved == 1 ? 'Approved' : 'Approve' }}
                    </button>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center text-muted">
                    No records found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@else
<div class="alert alert-warning text-center">
    Data is not available.
</div>
@endif


@push('scripts')
<script>
    $('.approveBtn').click(function () {
    let id = $(this).data('id');

    $.ajax({
        url: `/admin/inventory/${id}/approve`,
        type: 'PATCH',
        data: {
            isApproved:1,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            window.location.reload();
            alert(res.message);
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


@endsection
