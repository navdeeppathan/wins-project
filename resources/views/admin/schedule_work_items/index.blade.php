@extends('layouts.admin')

@section('content')
<div class="container">

    {{-- @foreach($scheduleWorks->slice(1) as $scheduleWork) --}}

        {{-- SCHEDULE WORK HEADER --}}
        <div class="card mb-2">
            <div class="card-header bg-light fw-bold">
                {{ $scheduleWork->description }}
            </div>

            <div class="card-body p-0">

                <table id="example" class="table table-bordered class-table mb-0 schedule-table "
                       data-schedule="{{ $scheduleWork->id }}">

                    <thead class="table-light">
                        <tr>
                            <th>S. No.</th>
                            <th>Number</th>
                            <th>Description</th>
                            <th>Slides</th>
                            <th>Length</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Factor</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($scheduleWorkItems->count() > 0)
                            {{-- EXISTING ROWS --}}
                            @forelse($scheduleWorkItems as $item)
                                <tr>
                                    <form method="POST"
                                        action="{{ route('admin.schedule-work-items.update', $item->id) }}">
                                        @csrf
                                        @method('POST')

                                        <td>{{ $loop->iteration }}</td>
                                        <td><input name="sr_no" value="{{ $item->sr_no }}" class="form-control"></td>
                                        <td><input name="description"  value="{{ $item->description }}" class="form-control"></td>
                                        <td><input name="no_of_items" value="{{ $item->no_of_items }}" class="form-control"></td>
                                        <td><input name="length" value="{{ $item->length }}" class="form-control"></td>
                                        <td><input name="width" value="{{ $item->width }}" class="form-control"></td>
                                        <td><input name="height" value="{{ $item->height }}" class="form-control"></td>
                                        <td><input name="factor" value="{{ $item->factor }}" class="form-control"></td>
                                        <td><input name="qty" readonly value="{{ $item->qty }}" class="form-control"></td>
                                        <td class="d-flex gap-1">
                                                <button class="btn btn-sm btn-primary">Update</button>
                                            </form>

                                            <form method="POST"
                                                action="{{ route('admin.schedule-work-items.destroy', $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">X</button>
                                            </form>
                                        </td>
                                </tr>
                            @empty
                                {{-- DEFAULT ROW IF NO ITEMS --}}
                                <tr>
                                    <form method="POST" action="{{ route('admin.schedule-work-items.store') }}">
                                    @csrf

                                    <input type="hidden" name="schedule_work_id" value="{{ $scheduleWork->id }}">

                                    <td>
                                        <input type="text" name="id" class="form-control" placeholder="1" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="sr_no" class="form-control" placeholder="Enter No">
                                    </td>

                                    <td>
                                        <input type="text" name="description" class="form-control" placeholder="Enter Description">
                                    </td>

                                    <td>
                                        <input type="text" name="no_of_items" class="form-control" placeholder="Enter Slides">
                                    </td>

                                    <td>
                                        <input type="text" name="length" class="form-control" placeholder="Enter Length">
                                    </td>

                                    <td>
                                        <input type="text" name="width" class="form-control" placeholder="Enter Width">
                                    </td>

                                    <td>
                                        <input type="text" name="height" class="form-control" placeholder="Enter Height">
                                    </td>

                                    <td>
                                        <input type="text" name="factor" class="form-control" placeholder="Enter Factor">
                                    </td>

                                    <td>
                                        <input type="text" name="qty" readonly class="form-control" placeholder="Enter Qty">
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-success">Save</button>
                                    </td>

                                    </form>
                                    </tr>
                            @endforelse
                        @else
                            <tr><td colspan="10" class="text-center">No items yet.</td></tr>
                        @endif

                    </tbody>

                    {{-- TOTAL --}}
                    <tfoot class="table-warning">
                        <tr>
                            <th colspan="8" class="text-end">Total</th>
                            <th>{{ $scheduleWork->items->sum('qty') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                {{-- ADD ROW BUTTON --}}
                <div class="p-2 text-end">
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        Back
                    </a>
                    <button type="button"
                            class="btn btn-sm btn-success add-row-btn"
                            data-schedule="{{ $scheduleWork->id }}">
                        + Add Row
                    </button>
                </div>

            </div>
        </div>

    {{-- @endforeach --}}

</div>

<script>

    document.addEventListener('input', function (e) {

        if (
            e.target.name === 'sr_no' ||
            e.target.name === 'no_of_items' ||
            e.target.name === 'length' ||
            e.target.name === 'width' ||
            e.target.name === 'height' ||
            e.target.name === 'factor'
        ) {
            let row = e.target.closest('tr');

            let number  = 1; // default (if you don't have field)
            let numberField = parseFloat(row.querySelector('[name="sr_no"]')?.value) || 0;
            let slides  = parseFloat(row.querySelector('[name="no_of_items"]')?.value) || 0;
            let length  = parseFloat(row.querySelector('[name="length"]')?.value) || 0;
            let width   = parseFloat(row.querySelector('[name="width"]')?.value) || 0;
            let height  = parseFloat(row.querySelector('[name="height"]')?.value) || 0;
            let factor  = parseFloat(row.querySelector('[name="factor"]')?.value) || 0;

            let qty = numberField * slides * length * width * factor * height;

            row.querySelector('[name="qty"]').value = qty.toFixed(2);
        }
    });

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".add-row-btn").forEach(button => {

         button.addEventListener("click", function () {

            let scheduleId = this.dataset.schedule;

            let table = document.querySelector(
                '.schedule-table[data-schedule="'+scheduleId+'"] tbody'
            );

            // ✅ Correct place
            let count = table.querySelectorAll('tr').length + 1;

            let row = `
            <tr>
                <td>${count}</td>
                <td><input name="sr_no" class="form-control" placeholder="Enter NO"></td>
                <td><input name="description" class="form-control" placeholder="Enter Description"></td>
                <td><input name="no_of_items" class="form-control" placeholder="Enter No of Items"></td>
                <td><input name="length" class="form-control" placeholder="Enter Length"></td>
                <td><input name="width" class="form-control" placeholder="Enter Width"></td>
                <td><input name="height" class="form-control" placeholder="Enter Height"></td>
                <td><input name="factor" class="form-control" placeholder="Enter Factor"></td>
                <td><input name="qty" readonly class="form-control" placeholder="Enter Qty"></td>
                <td>
                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                </td>
            </tr>
            `;

            table.insertAdjacentHTML("beforeend", row);

        });

    });

});
// 
</script>
@endsection


