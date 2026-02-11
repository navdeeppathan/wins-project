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
                <input class="form-control" disabled
                    value="{{
                        $project->date_ofstartof_work
                            ? date('d-m-Y', strtotime($project->date_ofstartof_work))
                            : $project->created_at->format('d-m-Y')
                    }}">
            </div>
            <div class="col-md-4 mb-2">
                <label>Date of Completion</label>
                <input class="form-control" disabled
                    value="{{
                        $project->stipulated_date_ofcompletion
                            ? date('d-m-Y', strtotime($project->stipulated_date_ofcompletion))
                            : $project->created_at->format('d-m-Y')
                    }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>Percentage</label>
                <input class="form-control {{ str_contains($percentageText,'BELOW')?'text-danger':'text-success' }}"
                    value="{{ $percentageText }}" disabled>
            </div>
        </div>

        <style>
            .readonly-row {
                background-color: #f1f1f1;
            }

            .readonly-row input,
            .readonly-row textarea {
                background-color: #e9ecef;
                cursor: not-allowed;
            }
        </style>
        <style>
            #example textarea.form-control {
                display: block !important;
                align-self: flex-start !important;
                text-align: left !important;
                vertical-align: top !important;
                padding-top: 8px !important;
            }
        </style>
{{-- TABLE --}}
<div class="table-responsive">
    <table id="example" class="table class-table table-bordered nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>GST</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Amount</th>
                {{-- <th>Measured Qty</th>
                <th>Inventory</th> --}}
                <th >Action</th>
            </tr>
        </thead>
        <tbody id="workTable">
            @forelse($works->slice(1) as $i => $w)
                <tr >
                    <td>{{ $i+1 }}
                        <input type="hidden" class="row-id" value="{{ $w->id }}">
                    </td>

                    <td>
                        <textarea class="form-control description text-left"
                            >
                            {{ $w->description }}
                        </textarea>
                    </td>


                    <td>
                        <input class="form-control qty"
                            value="{{ $w->quantity }}"
                            >
                    </td>

                    <td>
                        <input class="form-control gst"
                            value="{{ $w->gst }}"
                            >
                    </td>

                    <td>
                        <input class="form-control unit"
                            value="{{ $w->unit }}"
                            >
                    </td>

                    <td>
                        <input class="form-control rate"
                            value="{{ $w->rate }}"
                            >
                    </td>

                    <td class="amount text-center">
                        {{ number_format($w->amount,2) }}
                    </td>

                    {{-- <td>
                        <input class="form-control measured_quantity"
                            value="{{ $w->measured_quantity }}"
                           >
                    </td> --}}

                    {{-- <td>
                        
                        <a href="{{ route('admin.projects.schedule-work.index3', [$project, $w]) }}"
                        class="btn btn-primary btn-sm">
                        Inventory
                        </a>
                    </td> --}}

                    <td>
                        
                        <button type="button"
                                class="btn btn-success btn-sm saveRow"
                                >
                            Save
                        </button>

                        <button type="button"
                                class="btn btn-danger btn-sm deleteRow"
                                >
                            ❌
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>1
                        <input type="hidden" class="row-id">
                    </td>
                    <td><textarea class="form-control description"></textarea></td>
                    <td><input class="form-control qty"></td>
                    <td><input class="form-control gst"></td>
                    <td><input class="form-control unit" value="1"></td>
                    <td><input class="form-control rate"></td>
                    <td class="amount text-center">0.00</td>
                    {{-- <td><input class="form-control measured_quantity"></td> --}}
                    {{-- <td></td> --}}
                    <td>
                        <button type="button" class="btn btn-success btn-sm saveRow">Save</button>
                        <button type="button" class="btn btn-danger btn-sm deleteRow">❌</button>
                    </td>
                </tr>
            @endforelse
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
            <td><input class="form-control gst"></td>
            <td><input class="form-control unit" value="1"></td>
            <td><input class="form-control rate"></td>
            <td class="amount text-center">0.00</td>

            
        
            <td>
                <button type="button" class="btn btn-success btn-sm saveRow">save</button>
                <button type="button" class="btn btn-danger btn-sm deleteRow">❌</button>
            </td>

        </tr>`);
        index++;
    };

    // document.addEventListener('input', e => {
    //     if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
    //         let row = e.target.closest('tr');
    //         let q = parseFloat(row.querySelector('.qty').value)||0;
    //         let r = parseFloat(row.querySelector('.rate').value)||0;
    //         let gst = parseFloat(row.querySelector('.gst').value)||0;
    //         row.querySelector('.amount').innerText = (q*r+gst).toFixed(2);
    //     }
    // });
    document.addEventListener('input', e => {
        if (
            e.target.classList.contains('qty') ||
            e.target.classList.contains('rate') ||
            e.target.classList.contains('gst')
        ) {
            let row = e.target.closest('tr');

            let q = parseFloat(row.querySelector('.qty')?.value) || 0;
            let r = parseFloat(row.querySelector('.rate')?.value) || 0;
            let gst = parseFloat(row.querySelector('.gst')?.value) || 0;

            row.querySelector('.amount').innerText = (q * r + gst).toFixed(2);
        }
    });


    document.addEventListener('click', e => {
        if (!e.target.classList.contains('saveRow')) return;

        let row = e.target.closest('tr');

        let payload = {
            id: row.querySelector('.row-id').value,
            description: row.querySelector('.description').value,
            quantity: row.querySelector('.qty').value,
            gst: row.querySelector('.gst').value,
            unit: row.querySelector('.unit').value,
            rate: row.querySelector('.rate').value,
            // measured_quantity: row.querySelector('.measured_quantity').value,
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
            e.target.textContent = "Saved";
            window.location.reload();
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
    new DataTable('#example', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: true,
        layout: {
            topStart: {
                buttons: [ 'pdf', 'colvis']
            }
        },

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


@endsection
