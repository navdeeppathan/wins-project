@extends('layouts.staff')

@section('title','Correspondence')

@section('content')

<h3 class="mb-3">Project – Correspondence – #{{ $project->name}}</h3>


@include("staff.projects.commonprojectdetail")

<hr>

<h4 class="mb-3">
    Correspondence – {{ $project->name }}
</h4>

<form action="{{ route('staff.projects.correspondence.save', $project) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf

<div class="table-responsive">

    <table id="example" class="table class-table nowrap" style="width:100%">
    
<thead>
<tr>
    <th>#</th>
    <th>Letter Subject</th>
    <th>Letter Date</th>
    <th>Upload</th>
    <th>Action</th>
</tr>
</thead>

<tbody id="corrTable">
@forelse($letters as $i => $l)
<tr>
    <td>{{ $i+1 }}</td>

    <input type="hidden" name="correspondence[{{ $i }}][id]" value="{{ $l->id }}">

    <td>
        <input type="text"
               name="correspondence[{{ $i }}][letter_subject]"
               value="{{ $l->letter_subject }}"
               class="form-control">
    </td>

    <td>
        <input type="date"
               name="correspondence[{{ $i }}][letter_date]"
               value="{{ $l->letter_date }}"
               class="form-control">
    </td>

    <td>
        @if($l->upload)
            <a href="{{ asset('storage/'.$l->upload) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary mb-1">
               View
            </a>
        @endif

        <input type="file"
               name="correspondence[{{ $i }}][upload]"
               class="form-control">
    </td>

    <td>
        <button type="button" class="btn btn-danger removeRow">X</button>
    </td>
</tr>
@empty
<tr>
    <td>1</td>
    <td>
        <input type="text"
               name="correspondence[0][letter_subject]"
               class="form-control">
    </td>
    <td>
        <input type="date"
               name="correspondence[0][letter_date]"
               class="form-control">
    </td>
    <td>
        <input type="file"
               name="correspondence[0][upload]"
               class="form-control">
    </td>
    <td></td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="d-flex justify-content-between mt-3">
    <button type="button" id="addRow" class="btn btn-primary btn-sm">
        + Add More
    </button>

    <button class="btn btn-success btn-sm">
        Save Correspondence
    </button>
</div>

</form>

@endsection

@push('scripts')
<script>
let index = {{ $letters->count() ?: 1 }};

document.getElementById('addRow').addEventListener('click', function () {

    let row = `
    <tr>
        <td>${index+1}</td>
        <td>
            <input type="text"
                   name="correspondence[${index}][letter_subject]"
                   class="form-control">
        </td>
        <td>
            <input type="date"
                   name="correspondence[${index}][letter_date]"
                   class="form-control">
        </td>
        <td>
            <input type="file"
                   name="correspondence[${index}][upload]"
                   class="form-control">
        </td>
        <td>
            <button type="button" class="btn btn-danger removeRow">X</button>
        </td>
    </tr>`;

    document.getElementById('corrTable')
        .insertAdjacentHTML('beforeend', row);

    index++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endpush
