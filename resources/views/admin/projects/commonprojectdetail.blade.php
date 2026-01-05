@php
    $estimated = (float) $project->estimated_amount;
    $tendered  = (float) $project->tendered_amount;


    $percentageText = '-';

    if ($estimated > 0 && $tendered > 0) {
        $percentage = (($estimated - $tendered) / $estimated) * -100;
        $percentage = round($percentage, 2);
        if ($percentage == '-0') {
            $percentageText = 'AT PAR';
        }elseif ($percentage < 0) {
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
