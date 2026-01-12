@extends('layouts.admin')

@section('title','User Details')

@section('content')

<h3 class="mb-3">Vendore Details</h3>
<style>
    .summary-box {
        background: #f8f9fa;
        border-left: 6px solid #0d6efd;
    }

    .summary-value {
        font-size: 18px;
        font-weight: 600;
        padding: 8px 0;
    }

    .summary-value.balance {
        color: #856404;
    }

    .summary-value.due {
        color: #dc3545;
    }

    .summary-value.paid {
        color: #198754;
    }
</style>

<div class="row">

    {{-- STATE --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">State</label>
        <input type="text"
               class="form-control"
               value="{{ $vendor->state ?? '-' }}"
               disabled>
    </div>




    {{-- USER NAME --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" value="{{ $vendor->vendor_agency_name }}" disabled>
    </div>

    {{-- CONTACT NUMBER --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control" value="{{ $vendor->contact_number ?? '-' }}" disabled>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Email</label>
        <input type="email"
            class="form-control"
            value="{{ $vendor->email_id }}"
            disabled>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <div class="p-3 border rounded summary-box">
            <div class="row text-center">



                <div class="col-md-4">
                    <label class="form-label text-muted">Total Due</label>
                    <div class="summary-value due">
                        ₹ {{ number_format($totalNetPayable, 2) }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-muted">Total Paid</label>
                    <div class="summary-value paid">
                        ₹ {{ number_format($totalPaidNetPayable, 2) }}
                    </div>
                </div>
                 <div class="col-md-4">
                    <label class="form-label text-muted">Balance</label>
                    <div class="summary-value balance">
                        ₹ {{ number_format($balanceAmount, 2) }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="d-flex align-items-end gap-2 justify-content-between mb-3">

    <h3 class="mb-3">Inventory</h3>
    <a href="{{ route('admin.vendors.index') }}"
        class="btn btn-secondary">
        Back
    </a>
</div>
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
            <thead class="table-light text-center">
                <tr style="text-align: center;">
                    <th class="text-center">#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Paid By</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Bill Number</th>
                    <th class="text-center">Description of Item</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Rate</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($inventories as $index => $i)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-center">{{ $i->date }}</td>
                        <td class="text-center">{{ $i->user->name ?? 'Admin' }}</td>

                        <td class="text-center">{{ $i->category ?? '-' }}</td>
                        <td>{{ $i->voucher ?? '-' }}</td>
                        <td class="text-center">{{ $i->description ?? '-' }}</td>
                        <td class="text-center">{{ $i->quantity }}</td>
                        <td class="text-center">₹ {{ number_format($i->amount, 2) }}</td>
                        <td class="text-center">₹ {{ number_format($i->net_payable, 2) }}</td>

                        <td class="text-center">
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
