@extends('layouts.admin')

@section('title','Correspondence')

@section('content')

<h3 class="mb-3">Project – Correspondence – #{{ $project->name}}</h3>


@include("admin.projects.commonprojectdetail")

<hr>

{{-- <h4 class="mb-3">
    Correspondence – {{ $project->name }}
</h4> --}}

<form action="{{ route('admin.projects.correspondence.save', $project) }}"
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
<tr data-index="{{ $i }}">
    <td>{{ $i+1 }}</td>

    <input type="hidden"
           name="correspondence[{{ $i }}][id]"
           value="{{ $l->id }}">

    <td>
        <input type="text"
               name="correspondence[{{ $i }}][letter_subject]"
               value="{{ $l->letter_subject }}"
               class="form-control letter_subject">
    </td>

    <td>
        <input type="date"
               name="correspondence[{{ $i }}][letter_date]"
               value="{{ $l->letter_date ? \Carbon\Carbon::parse($l->letter_date)->format('Y-m-d') : '' }}"
               class="form-control letter_date">
    </td>

    <td>
        @if($l->upload)
            <a href="{{ Storage::url($l->upload) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary mb-1">
                View
            </a>
        @endif

        <input type="file"
               class="form-control upload">
    </td>

    <td>
        <button type="button" class="btn btn-success btn-sm saveRow">Save</button>
        <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
    </td>
</tr>

@empty
<tr data-index="0">
    <td>1</td>

    <td>
        <input type="text"
               class="form-control letter_subject">
    </td>

    <td>
        <input type="date"
               class="form-control letter_date">
    </td>

    <td>
        <input type="file"
               class="form-control upload">
    </td>

    <td>
        <button type="button" class="btn btn-success btn-sm saveRow">Save</button>
        <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
    </td>
</tr>
@endforelse

</tbody>
</table>
</div>

<div class="d-flex justify-content-between mt-3">
    <button type="button" id="addRow" class="btn btn-primary btn-sm">
        + Add More
    </button>

    
</div>

</form>

@endsection

@push('scripts')
<script>
document.addEventListener('click', function (e) {

    // SAVE SINGLE ROW
    if (e.target.classList.contains('saveRow')) {

        let row = e.target.closest('tr');
        let index = row.getAttribute('data-index') ?? Date.now();

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        let idInput = row.querySelector('input[name*="[id]"]');
        if (idInput) {
            formData.append(`correspondence[0][id]`, idInput.value);
        }

        formData.append(`correspondence[0][letter_subject]`,
            row.querySelector('.letter_subject')?.value || '');

        formData.append(`correspondence[0][letter_date]`,
            row.querySelector('.letter_date')?.value || '');

        let fileInput = row.querySelector('.upload');
        if (fileInput && fileInput.files.length > 0) {
            formData.append(`correspondence[0][upload]`, fileInput.files[0]);
        }

        fetch("{{ route('admin.projects.correspondence.save', $project) }}", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(() => {
            window.location.reload();
            e.target.classList.remove('btn-success');
            e.target.classList.add('btn-outline-success');
            e.target.textContent = 'Saved';
        })
        .catch(() => alert('Save failed'));
    }

    // REMOVE ROW (UI ONLY)
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>


<script>
let corrIndex = {{ $letters->count() ?: 1 }};

document.getElementById('addRow').addEventListener('click', function () {

    let row = `
    <tr data-index="${corrIndex}">
        <td>${corrIndex + 1}</td>

        <td>
            <input type="text"
                   class="form-control letter_subject">
        </td>

        <td>
            <input type="date"
                   class="form-control letter_date">
        </td>

        <td>
            <input type="file"
                   class="form-control upload">
        </td>

        <td>
            <button type="button" class="btn btn-success btn-sm saveRow">Save</button>
            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
        </td>
    </tr>`;

    document.getElementById('corrTable')
        .insertAdjacentHTML('beforeend', row);

    corrIndex++;
});
</script>


@endpush

