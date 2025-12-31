@extends('layouts.admin')

@section('title','Projects')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Projects (Materials)</h3>
</div>


{{-- ================= TABS ================= --}}
<div class="tabs-wrapper">
    <div class="tabs">
        <button class="tab active" onclick="switchTab('tab-stores', this)">MATERIAL</button>
        <button class="tab" onclick="switchTab('tab-measured', this)">TOOLS AND MACHINERY</button>
      
    </div>


    <div class="tab-content">

        {{-- ================= EMD ================= --}}

        {{-- <div class="content2 emd tab-stores"> --}}
            @include('admin.material.abc')
        {{-- </div> --}}


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
let currentTab  = 'tab-stores';

function switchType(type, btn) {
    currentType = type;
    currentTab  = 'tab-stores';

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

@endpush



