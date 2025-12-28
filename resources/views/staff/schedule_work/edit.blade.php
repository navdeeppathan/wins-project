@extends('layouts.staff')

@section('title','Edit Schedule of Work')

@section('content')
<div class="container">
    <div class="col-md-8 mx-auto">

        <div class="card">
            <div class="card-header">Edit Work Item</div>
            <div class="card-body">

                <form method="POST" action="{{ route('staff.schedule-work.update', $scheduleWork) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required>
                            {{ $scheduleWork->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" step="0.01" name="quantity"
                                   class="form-control" value="{{ $scheduleWork->quantity }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit"
                                   class="form-control" value="{{ $scheduleWork->unit }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rate</label>
                            <input type="number" step="0.01" name="rate"
                                   class="form-control" value="{{ $scheduleWork->rate }}" required>
                        </div>
                    </div>

                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('staff.schedule-work.index') }}" class="btn btn-secondary">Back</a>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
