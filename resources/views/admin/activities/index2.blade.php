@extends('layouts.admin')

@section('title','Milestones')



@section('content')
<div class="container">
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
                @forelse($activities as $index => $activity)
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
                        <button class="btn btn-danger btn-sm removeRow">Del</button>
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

        <button id="addRow" class="btn btn-primary btn-sm mt-2">+ Add New Row</button>
    </div>

    <div class="card mb-4 mt-4">
        <div class="card-header">Activity Progress Overview</div>
        <div class="card-body">
            <canvas id="progressChart" height="120"></canvas>
        </div>
    </div>
</div>

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
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
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
const chartData = @json($chartData);

const labels = chartData.map(i => i.name);
const weightage = chartData.map(i => i.weightage);
const progress = chartData.map(i => i.progress);

new Chart(document.getElementById('progressChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Weightage',
                data: weightage,
                backgroundColor: '#3B82F6',
                barThickness: 18,
                borderRadius: 6
            },
            {
                label: 'Progress',
                data: progress,
                backgroundColor: '#22C55E',
                barThickness: 18,
                borderRadius: 6
            }
        ]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: ctx => `${ctx.dataset.label}: ${ctx.raw}%`
                }
            }
        },
        scales: {
            x: {
                max: 100,
                ticks: {
                    callback: value => value + '%'
                }
            },
            y: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>


<script>
    new DataTable('#activitiesTable', {
          scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,




        /* ðŸ”¥ GUARANTEED ROW COLOR FIX */
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

@endpush



@endsection
