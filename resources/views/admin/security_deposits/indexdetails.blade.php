@extends('layouts.admin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Security Deposit)</h3>
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
            @include('admin.security_deposits.active')
        </div>

        <div class="content2 emd tab-returned">
            @include('admin.security_deposits.index2')
        </div>

        <div class="content2 emd tab-forfeited">
            @include('admin.securitydeposite_forfieted.index2')
        </div>




        {{-- ================= SECURITY ================= --}}
        {{-- <div class="content2 security active">
            @include('admin.projects.tables.security-active')
        </div>

        <div class="content2 security returned">
            @include('admin.projects.tables.security-returned')
        </div>

        <div class="content2 security forfeited">
            @include('admin.projects.tables.security-forfeited')
        </div> --}}

        {{-- ================= WITHHELD ================= --}}
        {{-- <div class="content2 withheld active">
            @include('admin.projects.tables.withheld-active')
        </div>

        <div class="content2 withheld returned">
            @include('admin.projects.tables.withheld-returned')
        </div>

        <div class="content2 withheld forfeited">
            @include('admin.projects.tables.withheld-forfeited')
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
        url: "/admin/projects/update-pgreturned/" + id,
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
            url: "/admin/projects/update-returned/" + id,
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



