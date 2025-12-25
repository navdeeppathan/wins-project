@extends('layouts.admin')

@section('title','Billing')

@section('content')
<h3 class="mb-2">Billing – Project #{{ $project->name}}</h3>
<p class="text-muted mb-3">Status: <strong>{{ ucfirst($project->status) }}</strong></p>

<div class="row">

    <div class="row">

        <div class="col-md-4 mb-3">
            <label>State</label>
            <input class="form-control"
                value="{{ $project->state->name ?? '-' }}"
                disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Department</label>
            <input class="form-control"
                value="{{ $project->departments->name ?? '-' }}"
                disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Project Name</label>
            <input type="text" class="form-control" value="{{ $project->name }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>NIT Number</label>
            <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Date of Submission</label>
            <input type="text" class="form-control" value="{{ $project->date_of_start }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Date of Opening</label>
            <input type="text" class="form-control" value="{{ $project->date_of_opening }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Estimated Amount</label>
            <input type="text" class="form-control" value="{{ $project->estimated_amount }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Time Allowed (Number)</label>
            <input type="text" class="form-control" value="{{ $project->time_allowed_number }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Time Type</label>
            <input type="text" class="form-control" value="{{ $project->time_allowed_type }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Total Work Done</label>
            <input type="text" class="form-control" value="{{ $project->total_work_done  ?? 0 }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Total Work To Be Done</label>
            <input type="text" class="form-control" value="{{$project->tendered_amount - $project->total_work_tobe_done ?? 0 }}" disabled>
        </div>

    </div> 



{{-- </div>
   
   <div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-header bg-light">
            <strong>Create Bill</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.projects.billing.store', $project) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-2">
                    <label class="form-label">Bill No *</label>
                    <input type="text" name="bill_number" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Bill Date *</label>
                    <input type="date" name="bill_date" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Type *</label>
                    <select name="bill_type" class="form-select" required>
                        <option value="">-- Select --</option>
                        <option value="running">Running</option>
                        <option value="final">Final</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label">MB No *</label>
                    <input type="text" name="mb_number" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Page No *</label>
                    <input type="text" name="page_number" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Gross Amount</label>
                    <input type="number"
                           step="0.01"
                           name="gross_amount"
                           class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label">Net Amount</label>
                    <input type="number"
                           step="0.01"
                           name="net_payable"
                           class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label">File</label>
                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <button class="btn btn-primary btn-sm mt-2">
                    Create Bill
                </button>
            </form>
        </div>
    </div>
</div> --}}



{{-- <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Billings)</h3>

</div>
@if($project->billings->count() > 0)
<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Bill No</th>
                <th>Bill Status</th>
                <th>Date</th>
                <th>MB No</th>
                <th>Page No</th>
                <th>Gross AMT</th>
                <th>Recoveries</th>
                <th>Net Payable</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
             @php
                $i=1;
            @endphp
            @forelse($project->billings as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->bill_number }}</td>
                    <td>{{ $p->bill_type }}</td>
                    <td>{{ $p->bill_date }}</td>
                    <td>{{ $p->mb_number }}</td>
                    <td>{{ $p->page_number }}</td>
                    <td>{{ number_format($p->gross_amount,2) }}</td>
                    <td>
                        <a href="{{ route('admin.projects.recoveries.index', [
                            'project' => $project->id,
                            'billing' => $p->id
                        ]) }}">
                            {{ number_format($project->recoveries?->sum('amount') ?? 0, 2) }}
                        </a>
                    </td>
                    <td>{{ number_format($p->net_payable,2) }}</td>
                    <td>{{ $p->remarks }}</td>
                </tr>
                 @php
                $i++;
            @endphp
            @empty
                <tr><td colspan="13" class="text-center">No Billings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
    <div class="alert alert-warning text-center">
        Data is not available.
    </div>
@endif --}}


<div class="container">
    <h3 class="mb-3">Project Billings</h3>

    <div class="table-responsive">
        <table id="billingTable" class="table table-sm table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Bill No *</th>
                    <th>Type *</th>
                    <th>Date *</th>
                    <th>MB No *</th>
                    <th>Page *</th>
                    <th>Gross Amt</th>
                    <th>Recoveries</th>
                    <th>Net Payable</th>
                    <th>Remarks</th>
                    <th>File</th>
                    <th width="90">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($project->billings as $index => $bill)
                <tr data-id="{{ $bill->id }}">
                    <td>{{ $index+1 }}</td>

                    <td>
                        <input type="text" class="form-control bill_number"
                               value="{{ $bill->bill_number }}">
                    </td>

                    <td>
                        <select class="form-control bill_type">
                            <option value="running" {{ $bill->bill_type=='running'?'selected':'' }}>Running</option>
                            <option value="final" {{ $bill->bill_type=='final'?'selected':'' }}>Final</option>
                        </select>
                    </td>

                    <td>
                        <input type="date" class="form-control bill_date"
                               value="{{ $bill->bill_date }}">
                    </td>

                    <td>
                        <input type="text" class="form-control mb_number"
                               value="{{ $bill->mb_number }}">
                    </td>

                    <td>
                        <input type="text" class="form-control page_number"
                               value="{{ $bill->page_number }}">
                    </td>

                    <td>
                        <input type="number" step="0.01"
                               class="form-control gross_amount"
                               value="{{ $bill->gross_amount }}">
                    </td>

                    <td>
                        <a href="{{ route('admin.projects.recoveries.index', [
                            'project' => $project->id,
                            'billing' => $bill->id
                        ]) }}">
                            {{ number_format($bill->recoveries?->sum('amount') ?? 0, 2) }}
                        </a>
                    </td>

                    <td>
                        <input type="number" step="0.01"
                               class="form-control net_payable"
                               value="{{ $bill->net_payable }}">
                    </td>

                    <td>
                        <input type="text" class="form-control remarks"
                               value="{{ $bill->remarks }}">
                    </td>

                    <td>
                        <input type="file" class="form-control file">
                    </td>

                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                    </td>
                </tr>
                @empty
                {{-- Default empty row --}}
                <tr>
                    <td>1</td>
                    <td><input type="text" class="form-control bill_number"></td>
                    <td>
                        <select class="form-control bill_type">
                            <option value="">Select</option>
                            <option value="running">Running</option>
                            <option value="final">Final</option>
                        </select>
                    </td>
                    <td><input type="date" class="form-control bill_date"></td>
                    <td><input type="text" class="form-control mb_number"></td>
                    <td><input type="text" class="form-control page_number"></td>
                    <td><input type="number" step="0.01" class="form-control gross_amount"></td>
                    <td>0.00</td>
                    <td><input type="number" step="0.01" class="form-control net_payable"></td>
                    <td><input type="text" class="form-control remarks"></td>
                    <td><input type="file" class="form-control file"></td>
                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button id="addBillRow" class="btn btn-primary btn-sm mt-2">
            + Add New Bill
        </button>
    </div>
</div>


@push('scripts')
<script>
$(document).on('click', '.saveRow', function () {

    let row = $(this).closest('tr');
    let id = row.data('id') || null;

    let formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('project_id', "{{ $project->id }}");

    formData.append('bill_number', row.find('.bill_number').val());
    formData.append('bill_type', row.find('.bill_type').val());
    formData.append('bill_date', row.find('.bill_date').val());
    formData.append('mb_number', row.find('.mb_number').val());
    formData.append('page_number', row.find('.page_number').val());
    formData.append('gross_amount', row.find('.gross_amount').val());
    formData.append('net_payable', row.find('.net_payable').val());
    formData.append('remarks', row.find('.remarks').val());

    let fileInput = row.find('.file')[0];
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    $.ajax({
        url: id
            ? `/admin/projects/billing/${id}/update`
            : "{{ route('admin.projects.billing.store', $project) }}",
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            alert('Saved successfully');
            if(!id) location.reload();
        }
    });
});

$('#addBillRow').click(function () {
    let index = $('#billingTable tbody tr').length + 1;

    let row = `
    <tr>
        <td>${index}</td>
        <td><input type="text" class="form-control bill_number"></td>
        <td>
            <select class="form-control bill_type">
                <option value="">Select</option>
                <option value="running">Running</option>
                <option value="final">Final</option>
            </select>
        </td>
        <td><input type="date" class="form-control bill_date"></td>
        <td><input type="text" class="form-control mb_number"></td>
        <td><input type="text" class="form-control page_number"></td>
        <td><input type="number" step="0.01" class="form-control gross_amount"></td>
        <td>0.00</td>
        <td><input type="number" step="0.01" class="form-control net_payable"></td>
        <td><input type="text" class="form-control remarks"></td>
        <td><input type="file" class="form-control file"></td>
        <td><button class="btn btn-success btn-sm saveRow">Save</button></td>
    </tr>`;
    $('#billingTable tbody').append(row);
});
</script>
@endpush



   
</div>

<a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-2">Back to Projects</a>
@endsection
