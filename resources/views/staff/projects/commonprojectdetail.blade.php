<div class="row">

     <div class="col-md-12 mb-3">
        <label>Project Name</label>
        <input type="text" class="form-control" value="{{ $project->name }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>NIT Number</label>
        <input type="text" class="form-control" value="{{ $project->nit_number }}" disabled>
    </div>

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
        <label>Date of Submission</label>
        <input type="text" class="form-control" value="{{ date('d-m-y', strtotime($project->date_of_start)) ?? '-' }}" disabled>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Opening</label>
        <input type="text" class="form-control" value="{{ date('d-m-y', strtotime($project->date_of_opening)) ?? '-' }}" disabled>
    </div>


    

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

</div>