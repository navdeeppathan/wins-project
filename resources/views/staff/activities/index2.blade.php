@extends('layouts.staff')

@section('title','Milestones')



@section('content')
<div class="container">
    <h4 class="mb-3">Activities #{{ $project->name }}</h4>

    <div class="card mb-4">
        <div class="card-header">Activity Progress Overview</div>
        <div class="card-body">
            <canvas id="progressChart" height="120"></canvas>
        </div>
    </div>

    <div class="table-responsive">
        <table id="activitiesTable" class="table table-sm table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Activity Name *</th>
                    <th>From Date *</th>
                    <th>To Date *</th>
                    <th>Weightage *</th>
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
                    <td>
                       
                        <select class="form-control progresss">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}" {{ isset($activity) && $activity->progress == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                  

                    </td>
                    <td>
                        <button class="btn btn-success btn-sm saveRow">Save</button>
                        @if($index != 0)
                        <button class="btn btn-danger btn-sm removeRow">Del</button>
                        @endif
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

                    <td>
                        <select class="form-control progresss">
                            <option value="">Select</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
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
                <select class="form-control progresss">
                    <option value="">Select</option>
                    @for ($i = 1; $i <= 100; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </td>

            <td>
                <button class="btn btn-success btn-sm saveRow">Save</button>
                <button class="btn btn-danger btn-sm removeRow">Del</button>
            </td>
        </tr>`;
        $('#activitiesTable tbody').append(newRow);
    });

    // Save row via AJAX
    $(document).on('click', '.saveRow', function() {
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

        $.post(id ? `/staff/activities/${id}` : "{{ route('staff.activities.store') }}", data, function(res){
            if(!id) {
                location.reload(); // reload to get new id
            } else {
                alert('Updated successfully');
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
                    url: `/staff/activities/${id}/destroy`,
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
const chartData = @json($chartData);

const labels = chartData.map(i => i.name);
const total = chartData.map(() => 100);
const weightage = chartData.map(i => i.weightage);
const progress = chartData.map(i => i.progress);

new Chart(document.getElementById('progressChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            

            // WEIGHTAGE
            {
                label: 'Weightage',
                data: weightage,
                backgroundColor: '#3B82F6',
                barThickness: 20,
                borderRadius: 6,
                stack: 'combined'
            },

            // PROGRESS (inside weightage)
            {
                label: 'Progress',
                data: progress,
                backgroundColor: '#22C55E',
                barThickness: 20,
                borderRadius: 6,
                stack: 'combined'
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
                stacked: true,
                max: 100,
                ticks: {
                    callback: value => value + '%'
                }
            },
            y: {
                stacked: true
            }
        }
    }
});
</script>


@endpush



@endsection
