@extends('layouts.admin')

@section('title','Billing')

@section('content')
<h3 class="mb-2">Billing – Project #{{ $project->name }}</h3>
<p class="text-muted mb-3">Status: <strong>{{ ucfirst($project->status) }}</strong></p>

<div class="row">
    @include('admin.projects.commonprojectdetail')
</div>


<style>
    /* 🔥 Allow full width inputs */
    #billingTable input.form-control,
    #billingTable select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    #billingTable td:nth-child(3) input,
    #billingTable td:nth-child(5) input {
        min-width: 250px;
    }

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

<div class="container mt-3">
    <h3 class="mb-3">Project Billings</h3>

    <div class="table-responsive">
        <table id="billingTable" class="table class-table nowrap" style="width:100%">
            <thead class="table-dark">

                <tr>
                    <th>#</th>
                    <th>BILL NUMBER</th>
                    <th>BILL TYPE</th>
                    <th>BILL DATE</th>
                    <th>MB NO</th>
                    <th>PAGE</th>
                    <th>GROSS AMOUNT</th>
                    <th>RECOVERIES</th>
                    <th>NET PAYABLE</th>
                    <th>REMARKS</th>
                    <th>FILE</th>
                    <th>ACTION</th>
                    <th >COMPLETION DATE</th>
                </tr>
            </thead>

            <tbody>
            @forelse($billings as $index => $bill)
           
                <tr data-id="{{ $bill->id }}">
                    <td>{{ $index+1 }}</td>

                    <td><input type="text" class="form-control bill_number" value="{{ $bill->bill_number }}"></td>

                    <td>
                        <select class="form-control bill_type">
                            <option value="running" {{ $bill->bill_type=='running'?'selected':'' }}>Running</option>
                            <option value="final" {{ $bill->bill_type=='final'?'selected':'' }}>Final</option>
                            <option value="rescind" {{ $bill->bill_type=='rescind'?'selected':'' }}>Rescind</option>
                        </select>
                    </td>

                    <td><input type="date" class="form-control bill_date" value="{{ $bill->bill_date }}"></td>
                    <td><input type="text" class="form-control mb_number" value="{{ $bill->mb_number }}"></td>
                    <td><input type="text" class="form-control page_number" value="{{ $bill->page_number }}"></td>
                    <td><input type="number" step="0.01" class="form-control gross_amount" value="{{ $bill->gross_amount }}"></td>

                    <td>
                       
                            {{ number_format($bill->recoveries_sum_total ?? 0, 2) }}
                       
                    </td>

                    <td><input type="number" step="0.01" class="form-control net_payable" value="{{ $bill->net_payable }}"></td>
                    <td><input type="text" class="form-control remarks" value="{{ $bill->remarks }}"></td>
                    <td>
                        @if($bill->bill_file)
                            <a href="{{ Storage::url($bill->bill_file) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary mb-1">
                                View
                            </a>
                        @endif

                        <input type="file" class="form-control bill_file">
                    </td>


                    <td>
                        <button class="btn btn-success btn-sm saveRow">Update</button>
                         <a href="{{ route('admin.projects.recoveries.index', [$project->id, $bill->id]) }}" class="btn btn-primary btn-sm">Add Recoveries</a>
                    </td>

                    <td class="completionCell" style="display:none;">
                        <input type="date" class="form-control completion_date"
                               value="{{ $bill->completion_date ?? '' }}">
                    </td>
                </tr>
            @empty
                <tr>
                    <td>1</td>
                    <td><input type="text" class="form-control bill_number"></td>
                    <td>
                        <select class="form-control bill_type">
                            <option value="">Select</option>
                            <option value="running">Running</option>
                            <option value="final">Final</option>
                            <option value="rescind">Rescind</option>
                        </select>
                    </td>
                    <td><input type="date" class="form-control bill_date"></td>
                    <td><input type="text" class="form-control mb_number"></td>
                    <td><input type="text" class="form-control page_number"></td>
                    <td><input type="number" step="0.01" class="form-control gross_amount"></td>
                    <td>0.00</td>
                    <td><input type="number" step="0.01" class="form-control net_payable"></td>
                    <td><input type="text" class="form-control remarks"></td>
                    <td><input type="file" class="form-control bill_file"></td>
                    <td><button class="btn btn-success btn-sm saveRow">Save</button></td>
                    <td >
                        <div class="completionCell" style="display:none;">
                            <input type="date" class="form-control completion_date">
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        
    </div>
</div>

<div class="d-flex align-items-center justify-content-end gap-2">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm mt-3">Back to Home</a>
    <button id="addBillRow" class="btn btn-primary btn-sm mt-3">
                + Add New Bill
    </button>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.saveRow', function () {
    let row = $(this).closest('tr');
    let id = row.data('id') || null;

    let formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('project_id', "{{ $project->id }}");

    row.find('input, select').each(function () {
        if (this.type !== 'file') {
            formData.append(this.className.split(' ')[1], this.value);
        }
    });

    let file = row.find('.bill_file')[0];
    if (file && file.files.length) {
        formData.append('bill_file', file.files[0]);
    }

    $.ajax({
        url: id ? `/admin/projects/billing/${id}/update`
                : "{{ route('admin.projects.billing.store', $project) }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: () => {
            row.find('.saveRow').text('saved');
            window.location.reload();
            alert('Saved successfully');
            if (!id) location.reload();
        }
    });
});

$('#addBillRow').click(function () {
    let index = $('#billingTable tbody tr').length + 1;

    $('#billingTable tbody').append(`
    <tr>
        <td>${index}</td>
        <td><input type="text" class="form-control bill_number"></td>
        <td>
            <select class="form-control bill_type">
                <option value="">Select</option>
                <option value="running">Running</option>
                <option value="final">Final</option>
                <option value="rescind">Rescind</option>
            </select>
        </td>
        <td><input type="date" class="form-control bill_date"></td>
        <td><input type="text" class="form-control mb_number"></td>
        <td><input type="text" class="form-control page_number"></td>
        <td><input type="number" step="0.01" class="form-control gross_amount"></td>
        <td>0.00</td>
        <td><input type="number" step="0.01" class="form-control net_payable"></td>
        <td><input type="text" class="form-control remarks"></td>
        <td><input type="file" class="form-control bill_file"></td>
        <td><button class="btn btn-success btn-sm saveRow">Save</button></td>
        <td class="completionCell" style="display:none;">
            <input type="date" class="form-control completion_date">
        </td>
    </tr>`);
});

function updateCompletionVisibility() {
    let show = false;

    $('.bill_type').each(function () {
        let row = $(this).closest('tr');
        let cell = row.find('.completionCell');
        let input = row.find('.completion_date');

        if (this.value === 'final' || this.value === 'rescind') {
            show = true;
            cell.show();
            input.prop({disabled:false, required:true});
        } else {
            cell.hide();
            input.prop({disabled:true, required:false}).val('');
        }
    });

    $('#completionHeader').toggle(show);
    $('#addBillRow').prop('disabled', show).toggleClass('disabled', show);
}

$(document).on('change', '.bill_type', updateCompletionVisibility);
$(document).ready(updateCompletionVisibility);
</script>
<script>
    new DataTable('#billingTable', {
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
<script>
function calculateNetPayable(row) {
    const gross = parseFloat(row.querySelector('.gross_amount')?.value) || 0;
    const recovery = parseFloat(row.querySelector('.total_recovery')?.value) || 0;
    const netInput = row.querySelector('.net_payable');

    if (!netInput) return;

    const netPayable = gross - recovery;
    netInput.value = netPayable.toFixed(2);
}

// Listen for input changes
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('gross_amount') ||
        e.target.classList.contains('total_recovery')) {

        const row = e.target.closest('tr');
        if (row) calculateNetPayable(row);
    }
});

// Calculate on page load
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('tr').forEach(row => {
        if (row.querySelector('.gross_amount')) {
            calculateNetPayable(row);
        }
    });
});
</script>
@endpush
