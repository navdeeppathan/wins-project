@extends('layouts.admin')
@section('title','Schedule Of Work')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<h4 class="mb-3">Schedule Of Work – {{ $project->name }}</h4>

@php
    $estimated = (float) $project->estimated_amount;
    $tendered  = (float) $project->tendered_amount;

    $percentageText = '-';
    if ($estimated > 0 && $tendered > 0) {
        $percentage = round((($estimated - $tendered) / $estimated) * -100, 2);
        $percentageText = $percentage < 0
            ? abs($percentage).' % BELOW'
            : $percentage.' % ABOVE';
    }
@endphp

{{-- PROJECT INFO --}}
<div class="row mb-4">
    <div class="col-md-4 mb-2">
        <label>Department</label>
        <input class="form-control" value="{{ $project->departments->name ?? '-' }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>State</label>
        <input class="form-control" value="{{ $project->state->name ?? '-' }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>NIT Number</label>
        <input class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>
{{-- 
    <div class="col-md-12 mb-2">
        <label>Project Name</label>
        <input class="form-control" value="{{ $project->name }}" disabled>
    </div> --}}

    <div class="col-md-4 mb-2">
        <label>Estimated Amount</label>
        <input class="form-control" value="{{ $project->estimated_amount }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Time Allowed</label>
        <input class="form-control" value="{{ $project->time_allowed_number }} {{ $project->time_allowed_type }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Tender Amount</label>
        <input class="form-control" value="{{ $project->tendered_amount }}" disabled>
    </div>

    <div class="col-md-4 mb-2">
        <label>Date of Start</label>
        <input class="form-control" value="{{ date('d-m-Y', strtotime($project->date_ofstartof_work)) }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Date of Completion</label>
        <input class="form-control" value="{{ date('d-m-Y', strtotime($project->stipulated_date_ofcompletion)) }}" disabled>
    </div>
    <div class="col-md-4 mb-2">
        <label>Percentage</label>
        <input class="form-control {{ str_contains($percentageText,'BELOW')?'text-danger':'text-success' }}"
               value="{{ $percentageText }}" disabled>
    </div>
</div>

{{-- TABLE --}}
<div class="table-responsive">
<table id="example" class="table class-table nowrap" style="width:100%">
    <thead class="table-dark">
        <tr>
            <th>#</th>
           
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Rate</th>
            <th>Amount</th>
             <th>Inventory</th>
            <th>Measured Quantity</th>
            {{-- <th>Category</th> --}}
            <th >Action</th>
        </tr>
    </thead>

    <tbody id="workTable">
        @foreach($works as $i => $w)
            <tr>
                <td>{{ $i+1 }}</td>

                <input type="hidden" class="row-id" value="{{ $w->id }}">
               

                <td><textarea class="form-control description">{{ $w->description }}</textarea></td>
                <td><input class="form-control qty" value="{{ $w->quantity }}"></td>
                <td><input class="form-control unit" value="{{ $w->unit }}"></td>
                <td><input class="form-control rate" value="{{ $w->rate }}"></td>
                <td class="amount">{{ number_format($w->amount,2) }}</td>
                 <td>
                    
                    <select class="form-select inventory_select">
                        <option value="">Select Inventory</option>
                        @foreach($inventories as $inventory)
                            <option value="{{ $inventory->id }}"
                                {{ $w->inventory_id == $inventory->id ? 'selected' : '' }}>
                                {{ $inventory->description }}
                            </option>
                        @endforeach
                    </select>

                   
                </td>
                <td><input class="form-control measured_quantity" value="{{ $w->measured_quantity }}"></td>


                {{-- <td>
                    <select class="form-control category">
                        <option value="">Select</option>
                        @foreach(['MATERIAL','WAGES','LOGISTIC','FEE','TOURS','OTHERS'] as $cat)
                            <option value="{{ $cat }}" {{ $w->category==$cat?'selected':'' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </td> --}}

                <td>
                    <button type="button" class="btn btn-success btn-sm saveRow">save</button>
                    <button type="button" class="btn btn-danger btn-sm deleteRow">❌</button>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="text-end mt-3">
    <button type="button" class="btn btn-primary" id="addRow">+ Add Row</button>
</div>

{{-- SCRIPT --}}
<script>
let index = {{ $works->count() }};

document.getElementById('addRow').onclick = () => {
    document.getElementById('workTable').insertAdjacentHTML('beforeend', `
    <tr>
        <td>${index+1}</td>
        <input type="hidden" class="row-id">
        

        <td><textarea class="form-control description"></textarea></td>
        <td><input class="form-control qty"></td>
        <td><input class="form-control unit" value="1"></td>
        <td><input class="form-control rate"></td>
        <td class="amount">0.00</td>
        <td>
            <select class="form-select inventory_select">
                <option value="">Select Inventory</option>
                @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}">
                        {{ $inventory->description }}
                    </option>
                @endforeach
            </select>
        </td>
        <td><input class="form-control measured_quantity"></td>
        
        <td>
            <button type="button" class="btn btn-success btn-sm saveRow">save</button>
            <button type="button" class="btn btn-danger btn-sm deleteRow">❌</button>
        </td>

    </tr>`);
    index++;
};

document.addEventListener('input', e => {
    if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
        let row = e.target.closest('tr');
        let q = parseFloat(row.querySelector('.qty').value)||0;
        let r = parseFloat(row.querySelector('.rate').value)||0;
        row.querySelector('.amount').innerText = (q*r).toFixed(2);
    }
});

document.addEventListener('click', e => {
    if (!e.target.classList.contains('saveRow')) return;

    let row = e.target.closest('tr');

    let payload = {
        id: row.querySelector('.row-id').value,
        inventory_id: row.querySelector('.inventory_select').value,
        description: row.querySelector('.description').value,
        quantity: row.querySelector('.qty').value,
        unit: row.querySelector('.unit').value,
        rate: row.querySelector('.rate').value,
        measured_quantity: row.querySelector('.measured_quantity').value,
        // category: row.querySelector('.category').value,
    };

    fetch("{{ route('admin.projects.schedule-work.save',$project) }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ work:[payload] })
    })
    .then(res => res.json())
    .then(res => {
        if(res.id) row.querySelector('.row-id').value = res.id;
        e.target.textContent = "✔ Saved";
        e.target.classList.replace('btn-success','btn-secondary');
    });
});
</script>

<script>
document.addEventListener('click', function (e) {

    if (!e.target.classList.contains('deleteRow')) return;

    if (!confirm('Are you sure you want to delete this row?')) return;

    let row = e.target.closest('tr');
    let id  = row.querySelector('.row-id')?.value;

    // 🔹 If row not saved yet → just remove from UI
    if (!id) {
        row.remove();
        return;
    }

    // 🔹 If row exists in DB → AJAX delete
    fetch("{{ route('admin.projects.schedule-work.delete') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(res => {
        if (res.status) {
            row.remove();
        } else {
            alert('Delete failed');
        }
    })
    .catch(() => alert('Server error'));
});
</script>


@endsection
