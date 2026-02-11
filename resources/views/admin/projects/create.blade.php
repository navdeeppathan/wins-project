@extends('layouts.admin')

@section('title','Create Project')

@section('content')
<h3 class="mb-3">Create Project (Bidding)</h3>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">

        <div class="col-md-12 mb-3">
            <label class="form-label">Project Name *</label>
            <textarea name="name"
                    class="form-control"
                    placeholder="Enter Project Name"
                    rows="3"
                    required>{{ old('name') }}</textarea>
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">NIT Number *</label>
            <input type="text" name="nit_number" value="{{ old('nit_number') }}" placeholder="Enter NIT Number" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Department *</label>
            <select name="department" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">State *</label>
            <select name="location" class="form-select" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Estimated Amount *</label>
           <input type="number" step="0.01" name="estimated_amount"
            id="estimated_amount"
            value="{{ old('estimated_amount') }}"
            placeholder="Enter Estimated Cost"
            class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Time Allowed *</label>
            <select name="time_allowed_number" class="form-select"  required>
                <option value="">Select</option>
                @for ($i = 1; $i <= 120; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Term *</label>
            <select name="time_allowed_type" class="form-select" required>
                <option value="">Select</option>
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
                <option value="Years">Years</option>
            </select>
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">EMD Rate *</label>
            <select id="emd_rate" name="emd_rate" class="form-select">
                <option value="2">2 PERCENT</option>
                <option value="1">1 PERCENT</option>
                <option value="other">OTHER</option>
            </select>
        </div>

        {{-- EMD AMOUNT --}}
        <div class="col-md-2 mb-3">
            <label class="form-label">EMD Amount *</label>
            <input type="text"
                    id="emd_amount_display"
                    class="form-control"
                    placeholder="EMD Amount">

                <input type="hidden" name="emd_amount" id="emd_amount">
        </div>

        <div class="col-md-2 mb-3">
            <label class="form-label">Tender Fee</label>
           <input type="number" step="0.01" name="tender_fee"
            id="tender_fee"
            value="{{ old('tender_fee') }}"
            placeholder="Enter Estimated Cost"
            class="form-control" >
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Date of Submission *</label>
            <input
                type="date"
                name="date_of_start"
                id="date_of_start"
                value="{{ old('date_of_start') }}"
                class="form-control"
                required
            >
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Date of Opening *</label>
            <input
                type="date"
                name="date_of_opening"
                id="date_of_opening"
                value="{{ old('date_of_opening') }}"
                class="form-control"
                required
            >
        </div>

    </div>

    <!-- ---------------- EMD DETAILS MULTIPLE ROW SECTION ---------------- -->
    {{-- <h4 class="mt-4">EMD Details (Multiple)</h4> --}}

        {{-- <div class="table-responsive">
            <table class="table class-table example table-bordered" id="emdTable" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Instrument Type</th>
                        <th>Instrument Number</th>
                        <th>Instrument Date</th>
                        <th>Amount</th>
                        <th>Upload (PDF)</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
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
                        <td>
                            <input type="number" step="0.01"
                                name="emd[0][amount]"
                                class="form-control emd-amount">
                        </td>
                        <td><input type="file" name="emd[0][upload]" class="form-control"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div> --}}

        <div class="d-flex align-items-end gap-2 justify-content-end" >
            <button class="btn btn-success mb-3">Save Project</button>
            {{-- <button type="button" class="btn btn-primary mb-3" id="addEmdRow">
                + Add More
            </button> --}}
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mb-3">Back</a>
        </div>


</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const rateSelect = document.getElementById('emd_rate');
        const displayAmt = document.getElementById('emd_amount_display');
        const hiddenAmt  = document.getElementById('emd_amount');
        const estInput   = document.getElementById('estimated_amount');

        let userEdited = false;

        function calculateEMD() {
            let rate = rateSelect.value;
            let baseAmount = parseFloat(estInput.value) || 0;

            // Auto calculation only if user has not edited manually
            if (!userEdited && rate !== 'other' && baseAmount > 0) {
                let emd = (baseAmount * rate) / 100;
                emd = emd.toFixed(2);

                displayAmt.value = emd;
                hiddenAmt.value  = emd;
            }
        }

        // Detect manual edit
        displayAmt.addEventListener('input', function () {
            userEdited = true;
            hiddenAmt.value = this.value;
        });

        // Reset manual flag when rate changes
        rateSelect.addEventListener('change', function () {
            userEdited = false;
            calculateEMD();
        });

        // Recalculate when estimated amount changes
        estInput.addEventListener('input', function () {
            if (!userEdited) {
                calculateEMD();
            }
        });

        // Initial run
        calculateEMD();

    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const submission = document.getElementById('date_of_start');
    const opening    = document.getElementById('date_of_opening');

    let openingManuallyChanged = false;

    // Mark opening as manually edited
    opening.addEventListener('input', function () {
        openingManuallyChanged = true;
    });

    // Auto-fill opening when submission changes
    submission.addEventListener('change', function () {
        if (!openingManuallyChanged || opening.value === '') {
            opening.value = submission.value;
        }
    });

});
</script>

<script>
let emdIndex = 1;

// Function to calculate and fill EMD amounts
function updateEmdAmounts() {
    const estimatedCost = parseFloat(document.getElementById('estimated_amount').value) || 0;
    const emdInputs = document.querySelectorAll('.emd-amount');

    emdInputs.forEach(input => {
        // Only set default if empty
        if (!input.dataset.userChanged) {
            input.value = (estimatedCost * 0.02).toFixed(2);
        }
    });
}

// Mark manually changed EMD amounts
document.addEventListener('input', function(e){
    if(e.target.classList.contains('emd-amount')){
        e.target.dataset.userChanged = true;
    }
});

// On page load
window.addEventListener('DOMContentLoaded', updateEmdAmounts);

// When estimated cost changes
document.getElementById('estimated_amount').addEventListener('input', updateEmdAmounts);

// Add Row
document.getElementById('addEmdRow').addEventListener('click', function () {
    const estimatedCost = parseFloat(document.getElementById('estimated_amount').value) || 0;

    let table = document.querySelector('#emdTable tbody');

    let newRow = `
        <tr>
            <td>${emdIndex + 1}</td>
            <td>
                <select name="emd[${emdIndex}][instrument_type]" class="form-select">
                    <option value="">Select</option>
                    <option value="FDR">FDR</option>
                    <option value="DD">DD</option>
                    <option value="BG">BG</option>
                    <option value="CHALLAN">CHALLAN</option>
                    <option value="EXEMPTED">EXEMPTED</option>
                </select>
            </td>
            <td><input type="text" name="emd[${emdIndex}][instrument_number]" class="form-control"></td>
            <td><input type="date" name="emd[${emdIndex}][instrument_date]" class="form-control"></td>
            <td>
                <input type="number" step="0.01"
                       name="emd[${emdIndex}][amount]"
                       class="form-control emd-amount"
                       value="${(estimatedCost * 0.02).toFixed(2)}">
            </td>
            <td><input type="file" name="emd[${emdIndex}][upload]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', newRow);
    emdIndex++;
});

// Remove Row
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});


document.addEventListener('DOMContentLoaded', function () {

    const submission = document.getElementById('date_of_start');
    const opening    = document.getElementById('date_of_opening');

    let manuallyChanged = false;

    // detect manual change
    opening.addEventListener('input', function () {
        manuallyChanged = true;
    });

    // auto fill on submission date change
    submission.addEventListener('change', function () {
        if (!manuallyChanged || opening.value === '') {
            opening.value = submission.value;
        }
    });

});


 new DataTable('.emdClass', {
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
@endsection
