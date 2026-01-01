@extends('layouts.admin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (PG)</h3>
</div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="fw-bold">Filter by Project Name</label>
            <input type="text" id="filterProjectName"
                class="form-control"
                placeholder="Enter project name">
        </div>

        <div class="col-md-4">
            <label class="fw-bold">Filter by NIT No</label>
            <input type="text" id="filterNit"
                class="form-control"
                placeholder="Enter NIT number">
        </div>

        <div class="col-md-4">
            <label class="fw-bold">Filter by Department</label>
            <input type="text" id="filterDepartment"
                class="form-control"
                placeholder="Enter department">
        </div>
    </div>
<div class="tabs-wrapper">

    <div class="tabs">
        <button class="tab active" onclick="switchTab('tab-active', this)">Active</button>
        <button class="tab" onclick="switchTab('tab-returned', this)">Returned</button>
        <button class="tab" onclick="switchTab('tab-forfeited', this)">Forfeited</button>
    </div>
    <div class="tab-content">
        <div class="content2 emd tab-active">
            @if($actives->count() > 0)
                <div class="table-responsive">
                    <table id="emdactive" class="table table-striped class-table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>NIT No</th>
                                
                                <th>Location</th>
                                <th>Department</th>
                                <th>Estimate Amount</th>
                                <th>EMD Amount</th>
                                <th>Instrument Type</th>
                                <th>Instrument Number</th>
                                <th>Instrument Date</th>
                                <th>Return</th>
                                <th>Save</th>
                                <th>Forfeited</th>
                                <th>Save</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($actives as $project)
                            @foreach($project->securityDeposits as $emd)
                                @if($emd->isReturned || $emd->isForfieted) @continue @endif
                                <tr>
                                    <td>{{ $project->id }}</td>

                                    <td>
                                        {!! implode('<br>', array_map(
                                            fn($chunk) => implode(' ', $chunk),
                                            array_chunk(explode(' ', $project->name), 10)
                                        )) !!}
                                    </td>

                                    <td>{{ $project->nit_number }}</td>
                                    <td>{{ $project->state->name ?? '-' }}</td>
                                    <td>{{ $project->departments->name ?? '-' }}</td>
                                    <td>{{ number_format($project->estimated_amount, 2) }}</td>

                                    <td>{{ number_format($emd->amount, 2) }}</td>
                                    <td>{{ $emd->instrument_type }}</td>
                                    <td>{{ $emd->instrument_number }}</td>
                                    <td>{{ date('d-m-Y', strtotime($emd->instrument_date)) }}</td>

                                    {{-- Returned --}}
                                    <td style="background:yellow;">
                                        <input type="checkbox"
                                            class="form-check-input isReturnedBox"
                                            data-id="{{ $emd->id }}"
                                            {{ $emd->isReturned ? 'checked' : '' }}>
                                    </td>

                                    <td style="background:yellow;">
                                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                            data-id="{{ $emd->id }}">
                                            Save
                                        </button>
                                    </td>

                                    {{-- Forfeited --}}
                                    <td style="background:yellow;">
                                        <input type="checkbox"
                                            class="form-check-input isForfietedBox"
                                            data-id="{{ $emd->id }}"
                                            {{ $emd->isForfieted ? 'checked' : '' }}>
                                    </td>

                                    <td style="background:yellow;">
                                        <button class="btn btn-sm btn-success saveisForfietedBtn"
                                            data-id="{{ $emd->id }}">
                                            Save
                                        </button>
                                    </td>

                                    {{-- <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td> --}}
                                </tr>

                            @endforeach
                        @empty
                            <tr>
                                <td colspan="15" class="text-center">No projects yet.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Data is not available.
                </div>
            @endif
        </div>

        <div class="content2 emd tab-returned">
            @if($returneds->count() > 0)
                <div class="table-responsive">
                    <table id="emdreturned" class="table table-striped class-table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>NIT No</th>
                                
                                <th>Location</th>
                                <th>Department</th>
                                <th>Estimate Amount</th>
                                <th>EMD Amount</th>
                                <th>Instrument Type</th>
                                <th>Instrument Number</th>
                                <th>Instrument Date</th>
                                <th>Returned</th>
                                <th>Save</th>
                            </tr>
                        </thead>
                        <tbody>

                        @php $i = 1; @endphp

                        @forelse($returneds as $project)
                            @foreach($project->securityDeposits as $emd)
                                @if($emd->isReturned)
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>
                                        {!! implode('<br>', array_map(
                                            fn($chunk) => implode(' ', $chunk),
                                            array_chunk(explode(' ', $project->name), 10)
                                        )) !!}
                                    </td>

                                    <td>{{ $project->nit_number }}</td>
                                    <td>{{ $project->state->name ?? '-' }}</td>
                                    <td>{{ $project->departments->name ?? '-' }}</td>
                                    <td>{{ number_format($project->estimated_amount, 2) }}</td>

                                    <td>{{ number_format($emd->amount, 2) }}</td>
                                    <td>{{ $emd->instrument_type }}</td>
                                    <td>{{ $emd->instrument_number }}</td>
                                    <td>{{ date('d-m-Y', strtotime($emd->instrument_date)) }}</td>

                                    <td style="background:yellow;">
                                        <input type="checkbox"
                                            class="form-check-input isReturnedBox"
                                            data-id="{{ $emd->id }}"
                                            checked>
                                    </td>

                                    <td style="background:yellow;">
                                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                            data-id="{{ $emd->id }}">
                                            Save
                                        </button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No returned EMDs found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Data is not available.
                </div>
            @endif
        </div>

        <div class="content2 emd tab-forfeited">
            @if($forfieteds->count() > 0)
                <div class="table-responsive">
                    <table id="emdforfieted" class="table table-striped class-table nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>NIT No</th>
                                <th>Location</th>
                                <th>Department</th>
                                <th>Estimate Amount</th>

                                <th>EMD Amount</th>
                                <th>Instrument Type</th>
                                <th>Instrument Number</th>
                                <th>Instrument Date</th>
                                <th>Forfeited</th>
                                <th>Save</th>
                            </tr>
                        </thead>
                        <tbody>

                        @php $i = 1; @endphp

                        @forelse($forfieteds as $project)
                            @foreach($project->securityDeposits as $emd)
                                @if($emd->isForfieted)
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>
                                        {!! implode('<br>', array_map(
                                            fn($chunk) => implode(' ', $chunk),
                                            array_chunk(explode(' ', $project->name), 10)
                                        )) !!}
                                    </td>

                                    <td>{{ $project->nit_number }}</td>
                                    <td>{{ $project->state->name ?? '-' }}</td>
                                    <td>{{ $project->departments->name ?? '-' }}</td>
                                    <td>{{ number_format($project->estimated_amount, 2) }}</td>

                                    <td>{{ number_format($emd->amount, 2) }}</td>
                                    <td>{{ $emd->instrument_type }}</td>
                                    <td>{{ $emd->instrument_number }}</td>
                                    <td>{{ date('d-m-Y', strtotime($emd->instrument_date)) }}</td>

                                    <td style="background:yellow;">
                                        <input type="checkbox"
                                            class="form-check-input isForfietedBox"
                                            data-id="{{ $emd->id }}"
                                            checked>
                                    </td>

                                    <td style="background:yellow;">
                                        <button class="btn btn-sm btn-success saveisForfietedBtn"
                                            data-id="{{ $emd->id }}">
                                            Save
                                        </button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No forfeited EMDs found.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Data is not available.
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .top-buttons {
        display: flex;
        gap: 10px;
    }

    .top-btn {
        padding: 10px 18px;
        border: 1px solid #ddd;
        background: #f8f9fa;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
    }

    .top-btn.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .tabs {
        display: flex;
        border-bottom: 1px solid #ddd;
    }

    .tab {
        padding: 12px 24px;
        cursor: pointer;
        background: transparent;
        border: 1px solid transparent;
        border-bottom: none;
    }

    .tab.active {
        background: #fff;
        border: 1px solid #ddd;
        border-bottom: 1px solid #fff;
        color: #0d6efd;
        font-weight: 600;
        border-radius: 6px 6px 0 0;
    }

    .tab-content {
        border: 1px solid #ddd;
        padding: 20px;
    }

    .content2 {
        display: none;
    }

    .content2.show {
        display: block;
    }
</style>

@endsection

@push('scripts')
    <script>
        let currentType = 'emd';
        let currentTab  = 'tab-active';

        function switchType(type, btn) {

            currentType = type;
            currentTab  = 'tab-active';

            document.querySelectorAll('.top-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelector('.tab').classList.add('active');

            showContent();
        }

        function switchTab(tab, btn) {
            currentTab = tab;

            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');

            showContent();
        }

        function showContent() {
            document.querySelectorAll('.content2').forEach(c => c.classList.remove('show'));

            const selector = `.content2.${currentType}.${currentTab}`;
            const el = document.querySelector(selector);

            if (el) el.classList.add('show');
        }

        document.addEventListener('DOMContentLoaded', showContent);
    </script>


    <script>

        $(document).on('click', '.saveisReturnedBtn', function () {
            let id = $(this).data('id');
            let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

            $.ajax({
                url: "/admin/projects/update-securityreturned/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    isReturned: isReturned,
                },
                success: function (response) {
                    alert("Updated Successfully");
                    location.reload();
                }
            });
        });

    </script>

    <script>
        $(document).on('click', '.saveisForfietedBtn', function () {

            let id = $(this).data('id');
            let isForfieted = $(this).closest('tr').find('.isForfietedBox').is(':checked') ? 1 : 0;

            $.ajax({
                url: "/admin/projects/update-securityforfieted/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    isForfieted: isForfieted,
                },
                success: function (response) {
                    alert("Updated Successfully");
                    location.reload();
                }
            });

        });

    </script>


    <script>
    let tableActive, tableReturned, tableForfeited;

    $(document).ready(function () {

        tableActive = new DataTable('#emdactive', commonDTConfig());
        tableReturned = new DataTable('#emdreturned', commonDTConfig());
        tableForfeited = new DataTable('#emdforfieted', commonDTConfig());

        // Project Name filter
        $('#filterProjectName').on('keyup', function () {
            applyFilter(1, this.value);
        });

        // NIT filter
        $('#filterNit').on('keyup', function () {
            applyFilter(2, this.value);
        });

        // Department filter
        $('#filterDepartment').on('keyup', function () {
            applyFilter(5, this.value);
        });

    });

    function applyFilter(columnIndex, value) {
        [tableActive, tableReturned, tableForfeited].forEach(table => {
            if (table) {
                table.column(columnIndex).search(value).draw();
            }
        });
    }

    function commonDTConfig() {
        return {
            scrollX: true,
            responsive: false,
            autoWidth: false,
            scrollCollapse: true,

            createdRow: function (row, data, index) {
                let bg = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';
                $('td', row).css('background-color', bg);
            },

            rowCallback: function (row, data, index) {
                let base = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';

                $(row).off('mouseenter mouseleave').hover(
                    () => $('td', row).css('background-color', '#e9ecff'),
                    () => $('td', row).css('background-color', base)
                );
            }
        };
    }
</script>
@endpush



