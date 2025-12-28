@extends('layouts.staff')

@section('title','Milestones Edit')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">

            <div class="card">
                <div class="card-header">Edit Activity</div>
                <div class="card-body">

                    <form method="POST" action="{{ route('staff.activities.update', $activity) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Activity Name</label>
                            <input type="text" name="activity_name"
                                   class="form-control"
                                   value="{{ $activity->activity_name }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date"
                                       class="form-control"
                                       value="{{ $activity->from_date->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date"
                                       class="form-control"
                                       value="{{ $activity->to_date->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Weightage</label>
                                <input type="number" name="weightage"
                                       class="form-control"
                                       value="{{ $activity->weightage }}" min="0" max="100">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Progress</label>
                                <input type="number" name="progress"
                                       class="form-control"
                                       value="{{ $activity->progress }}" min="0" max="100">
                            </div>
                        </div>

                        <button class="btn btn-success">Update</button>
                        <a href="{{ route('staff.activities.index') }}" class="btn btn-secondary">Back</a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
