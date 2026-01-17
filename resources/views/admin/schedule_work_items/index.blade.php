@extends('layouts.admin')

@section('content')
<div class="container">

    @foreach($scheduleWorks->slice(1) as $scheduleWork)

        {{-- SCHEDULE WORK HEADER --}}
        <div class="card mb-2">
            <div class="card-header bg-light fw-bold">
                {{ $scheduleWork->description }}
            </div>

            <div class="card-body p-0">

                <table id="example" class="table table-bordered class-table mb-0 schedule-table"
                       data-schedule="{{ $scheduleWork->id }}">

                    <thead class="table-light">
                        <tr>
                            <th>Sr</th>
                            <th>Description</th>
                            <th>No</th>
                            <th>Length</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Factor</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        {{-- EXISTING ROWS --}}
                        @forelse($scheduleWork->items as $item)
                        <tr>
                            <form method="POST"
                                  action="{{ route('admin.schedule-work-items.update', $item->id) }}">
                                @csrf
                                @method('POST')

                                <td><input name="sr_no" value="{{ $item->sr_no }}" class="form-control"></td>
                                <td><input name="description" value="{{ $item->description }}" class="form-control"></td>
                                <td><input name="no_of_items" value="{{ $item->no_of_items }}" class="form-control"></td>
                                <td><input name="length" value="{{ $item->length }}" class="form-control"></td>
                                <td><input name="width" value="{{ $item->width }}" class="form-control"></td>
                                <td><input name="height" value="{{ $item->height }}" class="form-control"></td>
                                <td><input name="factor" value="{{ $item->factor }}" class="form-control"></td>
                                <td><input name="qty" value="{{ $item->qty }}" class="form-control"></td>

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
                                <form method="POST"
                                      action="{{ route('admin.schedule-work-items.store') }}">
                                    @csrf
                                    <input type="hidden" name="schedule_work_id"
                                           value="{{ $scheduleWork->id }}">

                                    <td><input name="sr_no" class="form-control"></td>
                                    <td><input name="description" class="form-control"></td>
                                    <td><input name="no_of_items" class="form-control"></td>
                                    <td><input name="length" class="form-control"></td>
                                    <td><input name="width" class="form-control"></td>
                                    <td><input name="height" class="form-control"></td>
                                    <td><input name="factor" class="form-control"></td>
                                    <td><input name="qty" class="form-control"></td>
                                    <td>
                                        <button class="btn btn-sm btn-success">Save</button>
                                    </td>
                                </form>
                            </tr>
                        @endforelse

                    </tbody>

                    {{-- TOTAL --}}
                    <tfoot class="table-warning">
                        <tr>
                            <th colspan="7" class="text-end">Total</th>
                            <th>{{ $scheduleWork->items->sum('qty') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                {{-- ADD ROW BUTTON --}}
                <div class="p-2 text-end">
                    <button type="button"
                            class="btn btn-sm btn-success add-row-btn"
                            data-schedule="{{ $scheduleWork->id }}">
                        + Add Row
                    </button>
                </div>

            </div>
        </div>

    @endforeach

</div>
@endsection
