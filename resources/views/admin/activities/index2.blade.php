@extends('layouts.admin')

@section('title','Milestones')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h4 class="mb-3">Activities</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Create Form -->
            <div class="card mb-4">
                <div class="card-header">Add Activity</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.activities.store') }}">
                        @csrf
                        <div class="row g-3">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                           <div class="col-md-12">
                                <label class="form-label">Activity Name</label>
                                <textarea 
                                    name="activity_name" 
                                    class="form-control" 
                                    rows="3"
                                    placeholder="Enter activity name"
                                    required></textarea>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" required>
                            </div>

                            {{-- <div class="col-md-1">
                                <label class="form-label">Weightage</label>
                                <input type="number" name="weightage" class="form-control" min="0" max="100">
                            </div> --}}

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Weightage</label>
                                <select name="weightage" class="form-control"  required>
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 120; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    
                                </select>
                            </div>

                            {{-- <div class="col-md-1">
                                <label class="form-label">Progress</label>
                                <input type="number" name="progress" class="form-control" min="0" max="100">
                            </div> --}}

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Progress</label>
                                <select name="progress" class="form-control"  required>
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 120; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card">
                <div class="card-header">Activity List</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Activity</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Weightage</th>
                                <th>Progress</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->activity_name }}</td>
                                    <td>{{ $activity->from_date->format('d-m-Y') }}</td>
                                    <td>{{ $activity->to_date->format('d-m-Y') }}</td>
                                    <td>{{ $activity->weightage }}</td>
                                    <td>{{ $activity->progress }}</td>
                                    <td>
                                        <a href="{{ route('admin.activities.edit', $activity) }}" 
                                           class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
