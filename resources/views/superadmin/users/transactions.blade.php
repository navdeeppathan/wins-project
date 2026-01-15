@extends('layouts.superadmin')

@section('title', 'User Transactions')

@section('content')
<div class="container-fluid py-4">

<h4 class="mb-3">
    Transactions – {{ $user->name }}
</h4>



<form action="{{ route('superadmin.users.transactions.store') }}" method="POST">
@csrf

<table class="table table-bordered" id="transactionTable">
    <thead>
        <tr>
            <th>Amount</th>
            <th>Transaction Date</th>
            <th>Transaction Number</th>
            <th>Expiry Date</th>
            <th>Note</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                <input type="number" step="0.01" name="amount[]" class="form-control" required>
            </td>
            <td>
                <input type="date" name="transaction_date[]" class="form-control" required>
            </td>
            <td>
                <input type="text" name="transaction_number[]" class="form-control">
            </td>
            <td>
                <input type="date" name="expiry_date[]" class="form-control">
            </td>
            <td>
                <input type="text" name="note[]" class="form-control">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
            </td>
        </tr>
    </tbody>
</table>

    <button type="button" id="addRow" class="btn btn-secondary btn-sm">
    ➕ Add More
    </button>

    <button type="submit" class="btn btn-primary mt-3">
        Save Transactions
    </button>

</form>

<hr>

<h5 class="mt-4">Transaction History</h5>

<table class="table table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Amount</th>
    <th>Transaction Number</th>
    <th>Date</th>
    <th>Expiry</th>
    <th>Note</th>
</tr>
</thead>
<tbody>
@forelse($transactions as $t)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>₹{{ number_format($t->amount,2) }}</td>
    <td>{{ $t->transaction_number }}</td>
    <td>{{ date('d M Y', strtotime($t->transaction_date)) }}</td>
    <td>{{ $t->expiry_date ? date('d M Y', strtotime($t->expiry_date)) : '-' }}</td>
    <td>{{ $t->note }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center">No Transactions</td></tr>
@endforelse
</tbody>
</table>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('addRow').addEventListener('click', function () {
    let row = document.querySelector('#transactionTable tbody tr').cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    document.querySelector('#transactionTable tbody').appendChild(row);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeRow')){
        let rows = document.querySelectorAll('#transactionTable tbody tr');
        if(rows.length > 1){
            e.target.closest('tr').remove();
        }
    }
});
</script>
@endpush
