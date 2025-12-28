@extends('layouts.staff')
@section('title','Schedule Of Work')

@section('content')

<h4>Schedule Of Work – {{ $project->name }}</h4>

@include("staff.projects.commonprojectdetail")

<form method="POST"
      action="{{ route('staff.projects.schedule-work.save',$project) }}">
@csrf
<div class="table-responsive">
    <table id="example" class="table class-table nowrap" style="width:100%">

<thead class="">
<tr>
    <th>#</th>
    <th>Section</th>
    <th>Description</th>
    <th>Qty</th>
    <th>Unit</th>
    <th>Rate</th>
    <th>Amount</th>
    <th>Action</th>
</tr>
</thead>

<tbody id="workTable">
@forelse($works as $i => $w)
<tr>
    <td>{{ $i+1 }}</td>

    <input type="hidden" name="work[{{ $i }}][id]" value="{{ $w->id }}">

    <td>
        <input name="work[{{ $i }}][section_name]"
               value="{{ $w->section_name }}"
               class="form-control">
    </td>

    <td>
        <textarea name="work[{{ $i }}][description]"
                  class="form-control">{{ $w->description }}</textarea>
    </td>

    <td><input name="work[{{ $i }}][quantity]"
               value="{{ $w->quantity }}"
               class="form-control qty"></td>

    <td><input name="work[{{ $i }}][unit]"
               value="{{ $w->unit }}"
               class="form-control unit"></td>

    <td><input name="work[{{ $i }}][rate]"
               value="{{ $w->rate }}"
               class="form-control rate"></td>

    <td class="amount">{{ number_format($w->amount,2) }}</td>

    <td><button type="button" class="btn btn-danger removeRow">X</button></td>
</tr>
@empty
<tr>
<td>1</td>
<td><input name="work[0][section_name]" value="GENERAL" class="form-control"></td>
<td><textarea name="work[0][description]" class="form-control"></textarea></td>
<td><input name="work[0][quantity]" class="form-control qty"></td>
<td><input name="work[0][unit]" value="1" class="form-control unit"></td>
<td><input name="work[0][rate]" class="form-control rate"></td>
<td class="amount">0.00</td>
<td></td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="d-flex align-items-center justify-content-end mt-3 mb-3">
<button type="button" class="btn btn-primary" id="addRow">+ Add More</button>
</div>
<div class="d-flex align-items-center justify-content-end mt-2">
<button class="btn btn-success float-end">Save Schedule</button>
</div>

</form>


<script>
let index = {{ $works->count() ?? 1 }};

document.getElementById('addRow').addEventListener('click', function () {

let row = `
<tr>
<td>${index+1}</td>
<td><input name="work[${index}][section_name]" value="GENERAL" class="form-control"></td>
<td><textarea name="work[${index}][description]" class="form-control"></textarea></td>
<td><input name="work[${index}][quantity]" class="form-control qty"></td>
<td><input name="work[${index}][unit]" value="1" class="form-control unit"></td>
<td><input name="work[${index}][rate]" class="form-control rate"></td>
<td class="amount">0.00</td>
<td><button type="button" class="btn btn-danger removeRow">X</button></td>
</tr>`;

document.getElementById('workTable')
        .insertAdjacentHTML('beforeend', row);
index++;
});

document.addEventListener('input',function(e){
if(e.target.classList.contains('qty') ||
   e.target.classList.contains('rate') ||
   e.target.classList.contains('unit')){

    let row = e.target.closest('tr');
    let q = parseFloat(row.querySelector('.qty').value)||0;
    let r = parseFloat(row.querySelector('.rate').value)||0;
    let u = parseFloat(row.querySelector('.unit').value)||1;
    row.querySelector('.amount').innerText = (q*r*u).toFixed(2);
}
});

document.addEventListener('click',function(e){
if(e.target.classList.contains('removeRow')){
    e.target.closest('tr').remove();
}
});
</script>

@endsection
