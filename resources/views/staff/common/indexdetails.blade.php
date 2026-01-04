@extends('layouts.staff')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects</h3>
</div>

{{-- ================= TOP BUTTONS ================= --}}
<div class="top-buttons mb-3">
    <button class="top-btn active" onclick="switchType('emd', this)">EMD</button>
    <button class="top-btn" onclick="switchType('security', this)">SECURITY</button>
    <button class="top-btn" onclick="switchType('withheld', this)">WITHHELD</button>
</div>

{{-- ================= TABS ================= --}}
<div class="tabs-wrapper">
    <div class="tabs">
        <button class="tab active" onclick="switchTab('tab-active', this)">Active</button>
        <button class="tab" onclick="switchTab('tab-returned', this)">Returned</button>
        <button class="tab" onclick="switchTab('tab-forfeited', this)">Forfeited</button>
    </div>


    <div class="tab-content">

        {{-- ================= EMD ================= --}}

        <div class="content2 emd tab-active">
            @include('staff.common.tables.emd-active')
        </div>

        <div class="content2 emd tab-returned">
            @if($emdDetails->count() > 0)
<div class="table-responsive">
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead >
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>NIT No</th>
                <th>Estimate Amt</th>
                {{-- <th>Date of Opening</th> --}}
                <th>Location</th>
                <th>Department</th>
                <th>EMD Amt</th>
                <th>Instrument Type</th>
                <th>Instrument Number</th>
                <th>Instrument Date</th>



                <!-- NEW COLUMNS -->
                <th>Return</th>
                <th>Save</th>
                {{-- <th>Status</th> --}}

                {{-- <th width="160">Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($emdDetails as $emd)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{  $project->name }}</td>
                    <td>{{  $project->nit_number }}</td>
                    <td>{{ number_format( $project->estimated_amount,2) }}</td>
                    {{-- <td>{{ $p->date_of_opening }}</td> --}}
                    <td>{{  $project->state->name ?? '-' }}</td>
                    <td>{{  $project->department->name ?? '-' }}</td>
                    <td>{{  number_format( $emd->amount,2) }}</td>
                <td>

                            {{ $emd->instrument_type }}<br>

                    </td>

                    <td>

                            {{ $emd->instrument_number }}<br>

                    </td>

                    <td>

                            {{ $emd->instrument_date }}<br>

                    </td>

                    <td style="background:yellow;">
                            <input type="checkbox"
                                class="form-check-input isReturnedBox"
                                data-id="{{ $emd->id }}"
                                {{ $emd->isReturned ? 'checked' : '' }}>
                        </td>

                    <!-- SAVE BUTTON -->
                    <td style="background:yellow;">
                        <button class="btn btn-sm btn-success saveisReturnedBtn"
                                data-id="{{ $emd->id }}">
                            Save
                        </button>
                    </td>

                    <td><span class="badge bg-info">{{ ucfirst($project->status) }}</span></td>

                </tr>
            @empty
                <tr><td colspan="8" class="text-center">No projects yet.</td></tr>
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
            @include('staff.common.tables.emd-forfeited')
        </div>




        {{-- ================= SECURITY ================= --}}
        {{-- <div class="content2 security active">
            @include('staff.projects.tables.security-active')
        </div>

        <div class="content2 security returned">
            @include('staff.projects.tables.security-returned')
        </div>

        <div class="content2 security forfeited">
            @include('staff.projects.tables.security-forfeited')
        </div> --}}

        {{-- ================= WITHHELD ================= --}}
        {{-- <div class="content2 withheld active">
            @include('staff.projects.tables.withheld-active')
        </div>

        <div class="content2 withheld returned">
            @include('staff.projects.tables.withheld-returned')
        </div>

        <div class="content2 withheld forfeited">
            @include('staff.projects.tables.withheld-forfeited')
        </div> --}}

    </div>
</div>

{{-- ================= STYLES ================= --}}
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


{{-- ================= AJAX SAVE ================= --}}
{{-- <script>
$(document).on('click', '.saveisReturnedBtn', function () {

    let id = $(this).data('id');
    let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

    $.ajax({
        url: "/staff/projects/update-pgreturned/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            isReturned: isReturned,
        },
        success: function () {
            alert("Updated Successfully");
        }
    });
});
</script> --}}


<script>
    $(document).on('click', '.saveisReturnedBtn', function () {

        let id = $(this).data('id');
        let isReturned = $(this).closest('tr').find('.isReturnedBox').is(':checked') ? 1 : 0;

        $.ajax({
            url: "/staff/projects/update-returned/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                isReturned: isReturned,
            },
            success: function (response) {
                alert("Updated Successfully");
            }
        });

    });
</script>
@endpush



