@extends('layouts.admin')
@section('title','Milestones')
@section('content')

    <h4 class="mb-3">Activities #{{ $project->name }}</h4>
    @php
        $estimated = (float) $project->estimated_amount;
        $tendered  = (float) $project->tendered_amount;

        $percentageText = '-';

        if ($estimated > 0 && $tendered > 0) {
            $percentage = (($estimated - $tendered) / $estimated) * -100;
            $percentage = round($percentage, 2);

            if ($percentage < 0) {
                $percentageText = abs($percentage) . ' % BELOW';
            } else {
                $percentageText = $percentage . ' % ABOVE';
            }
        }
    @endphp

    {{-- PROJECT INFO (DISABLED) --}}
    <div class="row">

        <div class="col-md-4 mb-3">
            <label>Department</label>
            <input class="form-control"
                value="{{ $project->departments->name ?? '-' }}"
                disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>State</label>
            <input class="form-control"
                value="{{ $project->state->name ?? '-' }}"
                disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>NIT Number</label>
            <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
        </div>

        {{-- <div class="col-md-12 mb-3">
            <label>Project Name</label>
            <input type="text" class="form-control" value="{{ $project->name }}" disabled>
        </div> --}}


        <div class="col-md-4 mb-3">
            <label>Estimated Amount</label>
            <input type="text" class="form-control" value="{{ $project->estimated_amount }}" disabled>
        </div>

        <div class="col-md-4 flex mb-3">
            <label>Time</label>
            <input type="text" class="form-control" value="{{ $project->time_allowed_number }} {{ $project->time_allowed_type }}" disabled>

        </div>

        <div class="col-md-4 mb-3">
            <label>Tender Amount</label>
            <input type="text" class="form-control" value="{{ $project->tendered_amount }}" disabled>
        </div>



        <div class="col-md-4 mb-3">
            <label>Date Of Start Of Work</label>
            <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime($project->date_ofstartof_work)) ?? '-' }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>DATE OF COMPLETION (STIPULATED)</label>
            <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime($project->stipulated_date_ofcompletion)) ?? '-' }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label>Percentage</label>
            <input type="text"
                class="form-control {{ str_contains($percentageText, 'BELOW') ? 'text-danger' : 'text-success' }}"
                value="{{ $percentageText }}"
                disabled>
        </div>
    </div>

    <div class="table-responsive">
        <table id="activitiesTable" class="table class-table table-bordered" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Activity Name *</th>
                    <th>From Date *</th>
                    <th>To Date *</th>
                    <th>Target *</th>
                    <th>Progress *</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allactivities as $index => $activity)
                <tr data-id="{{ $activity->id }}">
                    <td>{{ $index+1 }}</td>
                    <td><textarea class="form-control activity_name">{{ $activity->activity_name }}</textarea></td>
                    <td><input type="date" class="form-control from_date" value="{{ $activity->from_date->format('Y-m-d') }}"></td>
                    <td><input type="date" class="form-control to_date" value="{{ $activity->to_date->format('Y-m-d') }}"></td>
                    <td>
                        {{-- <input type="number" class="form-control weightage" min="1" max="120" value="{{ $activity->weightage }}"> --}}
                        <select class="form-control weightage">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ isset($activity) && $activity->weightage == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    {{-- <td>

                        <select class="form-control progresss">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ isset($activity) && $activity->progress == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>


                    </td> --}}
                    <td>
                        <input
                            type="number"
                            name="progress"
                            class="form-control progresss show-spinner"
                            min="1"
                            max="100"
                            step="1"
                            placeholder="0"
                            value="{{ old('progress', $activity->progress ?? '') }}"
                        >
                    </td>

                    <td >
                        <button class="btn btn-success btn-sm saveRow">Update</button>
                        {{-- <button class="btn btn-danger btn-sm removeRow">Del</button> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td>1</td>
                    <td><textarea class="form-control activity_name"></textarea></td>
                    <td><input type="date" class="form-control from_date" value="{{ date('Y-m-d') }}"></td>
                    <td><input type="date" class="form-control to_date" value="{{ date('Y-m-d') }}"></td>

                    <td>
                        <select class="form-control weightage">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </td>

                    {{-- <td>
                        <select class="form-control progresss">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </td> --}}
                    <td>

                        <input
                            type="number"
                            name="progress"
                            class="form-control progresss"
                            min="1"
                            max="100"
                            step="1"
                            placeholder="0"
                        >
                    </td>


                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>
            <a href="{{ url('admin/award')}}" class="btn btn-secondary btn-sm mt-2 ms-2">Back</a>

        </div>

    </div>



    <div class="mt-4 mb-1 d-flex justify-content-end">
        <button id="exportPdf" class="btn btn-secondary mb-3">
        <i class="fa fa-file-pdf"></i> Export Progress PDF
    </button>
    </div>
    <div id="progressPdfArea">
        <div class="card ">
            <div class="card-header text-white" style="background:#5c5d5e">
                <small>All Construction Progress</small>
            </div>

            <div class="card-body progress-wrapper">
                @foreach($activities as $a)
                    <div class="activity-block">
                        <div class="activity-title">
                            {{ $a['name'] }} ({{ $a['status'] }})
                        </div>

                        {{-- <div class="progress-track">
                            <div class="progress-fill {{ $a['color'] }}"
                                style="width: {{ $a['progress'] }}%">
                            </div>
                        </div> --}}
                        <div class="progress-track">

                            <!-- WEIGHTAGE (white area) -->
                            <div class="weightage-base" style="width: {{ $a['weightage'] }}%">

                                <!-- PROGRESS (percent of weightage) -->
                                <div class="progress-fill {{ $a['color'] }}"
                                    style="width: {{ $a['progress'] }}%">

                                </div>

                            </div>

                        </div>






                    </div>
                @endforeach
            </div>
        </div>
    </div>
        <style>
            .progress-wrapper {
                background: linear-gradient(180deg, #818285, #7a7b7c);
                padding: 30px;

            }

            .activity-block {
                margin-bottom: 22px;
            }

            .activity-title {
                color: #fff;
                font-weight: 500;
                margin-bottom: 6px;
                font-size: 15px;
            }
            .progress-track {
                width: 100%;
                height: 16px;
                border-radius: 20px;
                border: 2px solid rgba(255,255,255,0.6);
                overflow: hidden;
            }

            /* White allocated weightage */
            .weightage-base {
                height: 100%;
                background: rgb(123, 155, 243);
                position: relative;
            }

            /* Actual progress */
            .progress-fill {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Progress colors */
            .progress-fill.green { background:#22c55e; }
            .progress-fill.yellow { background:#facc15; }
            .progress-fill.red { background:#ef4444; }

            /* White text */
            .bar-text {
                color: white;
                font-size: 11px;
                font-weight: 600;
                text-shadow: 0 0 4px rgba(0,0,0,0.6);
                white-space: nowrap;
            }


        </style>

@push('scripts')
    <script>
        $(document).ready(function() {

            // Add new empty row
            $('#addRow').click(function() {
                let index = $('#activitiesTable tbody tr').length + 1;
                let newRow = `<tr>
                    <td>${index}</td>
                    <td><textarea class="form-control activity_name"></textarea></td>
                    <td><input type="date" class="form-control from_date" value="{{ date('Y-m-d') }}"></td>
                    <td><input type="date" class="form-control to_date" value="{{ date('Y-m-d') }}"></td>

                    <td>
                        <select class="form-control weightage">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </td>

                    <td>

                                <input
                                    type="number"
                                    name="progress"
                                    class="form-control progresss"
                                    min="1"
                                    max="100"
                                    step="1"
                                    placeholder="0"
                                >
                    </td>

                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm saveRow">Save</button>
                            <button class="btn btn-danger btn-sm removeRow">Del</button>
                        </div>
                    </td>
                </tr>`;
                $('#activitiesTable tbody').append(newRow);
            });

            // Save row via AJAX
            $(document).on('click', '.saveRow', function () {

                let row = $(this).closest('tr');
                let id = row.data('id') || null;

                let data = {
                    _token: "{{ csrf_token() }}",
                    project_id: "{{ $project->id }}",
                    activity_name: row.find('.activity_name').val(),
                    from_date: row.find('.from_date').val(),
                    to_date: row.find('.to_date').val(),
                    weightage: row.find('.weightage').val(),
                    progress: row.find('.progresss').val()
                };

                $.ajax({
                    url: id ? `/admin/activities/${id}` : "{{ route('admin.activities.store') }}",
                    type: "POST",
                    data: data,

                    success: function (res) {
                        alert(id ? 'Updated successfully' : 'Saved successfully');
                        window.location.reload();
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';

                            $.each(errors, function (key, value) {
                                errorMsg += value[0] + '\n';
                            });

                            alert(errorMsg);
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
            });


            // Remove row
            $(document).on('click', '.removeRow', function() {
                let row = $(this).closest('tr');
                let id = row.data('id');
                if(id) {
                    if(confirm('Delete this activity?')) {
                        $.ajax({
                            url: `/admin/activities/${id}/destroy`,
                            type: 'POST',
                            data: {_token: "{{ csrf_token() }}"},
                            success: function() { row.remove(); }
                        });
                    }
                } else {
                    row.remove(); // just remove unsaved row
                }
            });

        });
    </script>

    <script>
        $(document).on('change', '.weightage, .progresss', function () {

            let row = $(this).closest('tr');

            let weightage = parseInt(row.find('.weightage').val()) || 0;
            let progress  = parseInt(row.find('.progresss').val()) || 0;

            // ❌ Weightage > 100
            if (weightage > 100) {
                alert('Weightage cannot be greater than 100');
                row.find('.weightage').val(100);
                weightage = 100;
            }

            // ❌ Progress > 100
            if (progress > 100) {
                alert('Progress cannot be greater than 100');
                row.find('.progresss').val(100);
                progress = 100;
            }
            // ❌ TOTAL Weightage > 100
            let totalWeightage = calculateTotalWeightage();

            if (totalWeightage > 100) {
                alert('Total Weightage cannot exceed 100');

                row.find('.weightage').val(0);
            }

            // ✅ Toggle Add Row Button
            toggleAddRowButton();
        });
    </script>

    <script>
        $(document).ready(function () {
            toggleAddRowButton();
        });
    </script>

    <script>
        new DataTable('#activitiesTable', {
            scrollX: true,
            scrollCollapse: true,
            responsive: false,
            autoWidth: false,

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
        function calculateTotalWeightage() {
            let total = 0;

            $('#activitiesTable tbody tr').each(function () {
                let weightage = parseInt($(this).find('.weightage').val()) || 0;
                total += weightage;
            });

            return total;
        }

        function toggleAddRowButton() {
            let totalWeightage = calculateTotalWeightage();

            if (totalWeightage >= 100) {
                $('#addRow').prop('disabled', true)
                    .addClass('btn-secondary')
                    .removeClass('btn-primary')
                    .text('Weightage Reached 100');
            } else {
                $('#addRow').prop('disabled', false)
                    .addClass('btn-primary')
                    .removeClass('btn-secondary')
                    .text('+ Add New Row');
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById("exportPdf").addEventListener("click", function () {

            const element = document.getElementById("progressPdfArea");

            html2canvas(element, {
                scale: 4,          // 🔥 Higher = sharper
                useCORS: true,
                backgroundColor: "#ffffff"
            }).then(canvas => {

                const imgData = canvas.toDataURL("image/png", 1.0);

                // Normal compact page size
                const pdfWidth  = 180;
                const pdfHeight = 230;

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: "p",
                    unit: "mm",
                    format: [pdfWidth, pdfHeight]
                });

                const margin = 10;
                const imgWidth = pdfWidth - margin * 2;
                const imgHeight = canvas.height * imgWidth / canvas.width;

                const y = (pdfHeight - imgHeight) / 2;

                // High quality image insert
                pdf.addImage(imgData, "PNG", margin, y, imgWidth, imgHeight, "", "FAST");

                pdf.save("Construction_Progress.pdf");
            });

        });
    </script>



@endpush



@endsection
