
<h3 class="mb-3">EMD Details</h3>

<form action="{{ route('admin.projects.emd.save', $project) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf

<div class="table-responsive">
<table id="emdTable" class="table class-table nowrap" style="width:100%">

    {{-- <table class="table table-sm table-bordered" id="emdTable"> --}}
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Instrument Type</th>
            <th>Instrument No</th>
            <th>Instrument Date</th>
            <th>Amount *</th>
            <th>Upload</th>
            <th>Action</th>

        </tr>
    </thead>

<tbody>
    @forelse($emds as $i => $emd)
    <tr>
        <td>{{ $i+1 }}</td>

        <input type="hidden" name="emd[{{ $i }}][id]" value="{{ $emd->id }}">

        <td>
            <select name="emd[{{ $i }}][instrument_type]" class="form-select">
                <option value="">Select</option>
                @foreach(['FDR','DD','BG','Challan'] as $t)
                    <option value="{{ $t }}" @selected($emd->instrument_type==$t)>
                        {{ $t }}
                    </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="text"
                name="emd[{{ $i }}][instrument_number]"
                class="form-control"
                value="{{ $emd->instrument_number }}">
        </td>

        <td>
            <input type="date"
                name="emd[{{ $i }}][instrument_date]"
                class="form-control"
                value="{{ $emd->instrument_date }}">
        </td>

        <td>
            <input type="number"
                step="0.01"
                name="emd[{{ $i }}][amount]"
                class="form-control"
                value="{{ $emd->amount }}"
                required>
        </td>

        <td>
            @if($emd->upload)
                <a href="{{ asset('storage/'.$emd->upload) }}"
                target="_blank"
                class="btn btn-sm btn-outline-primary mb-1">
                View
                </a>
            @endif

            <input type="file"
                name="emd[{{ $i }}][upload]"
                class="form-control">
        </td>
        <td>
            <button
                type="submit"
                name="row_index"
                value="{{ $i }}"
                class="btn btn-success btn-sm">
                Update
            </button>
        </td>


        {{-- <td>
            <button type="button" class="btn btn-danger btn-sm removeRow">
                Del
            </button>
        </td> --}}
    </tr>
    @empty
    <tr>
        <td>1</td>

        <td>
            <select name="emd[0][instrument_type]" class="form-select">
                <option value="">Select</option>
                <option value="FDR">FDR</option>
                <option value="DD">DD</option>
                <option value="BG">BG</option>
                <option value="CHALLAN">CHALLAN</option>
                <option value="EXEMPTED">EXEMPTED</option>
            </select>
        </td>

        <td><input type="text" name="emd[0][instrument_number]" class="form-control"></td>
        <td><input type="date" name="emd[0][instrument_date]" class="form-control"></td>
        <td><input type="number" step="0.01" name="emd[0][amount]" class="form-control" required></td>
        <td><input type="text" name="emd[0][remarks]" class="form-control"></td>
        <td><input type="file" name="emd[0][upload]" class="form-control"></td>
        <td>
            <button
                type="submit"
                name="row_index"
                value="0"
                class="btn btn-success btn-sm">
                Save
            </button>
        </td>

    </tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="d-flex flex-column align-items-end justify-content-end gap-4">
    <button type="button" id="addRow" class="btn btn-primary btn-sm mt-2 ">
    + Add Row
</button>

{{-- <button class="btn btn-success mt-2 float-end">
    Save EMD Details
</button> --}}
</div>

</form>

@push('scripts')
<script>
let index = {{ count($emds) ?? 1 }};

$('#addRow').click(function(){
    let row = `
    <tr>
        <td>${index+1}</td>

        <td>
            <select name="emd[${index}][instrument_type]" class="form-select">
                <option value="">Select</option>
                <option value="FDR">FDR</option>
                <option value="DD">DD</option>
                <option value="BG">BG</option>
                <option value="CHALLAN">CHALLAN</option>
                <option value="EXEMPTED">EXEMPTED</option>
            </select>
        </td>

        <td><input type="text" name="emd[${index}][instrument_number]" class="form-control"></td>
        <td><input type="date" name="emd[${index}][instrument_date]" class="form-control"></td>
        <td><input type="number" step="0.01" name="emd[${index}][amount]" class="form-control" required></td>
        <td><input type="text" name="emd[${index}][remarks]" class="form-control"></td>
        <td><input type="file" name="emd[${index}][upload]" class="form-control"></td>
        <td>
            <button
                type="submit"
                name="row_index"
                value="${index}"
                class="btn btn-success btn-sm">
                Save
            </button>
        </td>


    </tr>`;
    $('#emdTable tbody').append(row);
    index++;
});

$(document).on('click','.removeRow',function(){
    $(this).closest('tr').remove();
});

 new DataTable('#emdTable', {
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
