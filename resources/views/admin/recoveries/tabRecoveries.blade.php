@extends('layouts.admin')
@section('title','Projects – Recoveries')
@section('content')

@php
$recoveryTabs = [
    'tab-security' => ['label' => 'Security (2.5%)', 'field' => 'security'],
    'tab-income'   => ['label' => 'Income Tax (2%)',  'field' => 'income_tax'],
    'tab-labour'   => ['label' => 'Labour Cess (1%)', 'field' => 'labour_cess'],
    'tab-water'    => ['label' => 'Water Charges',   'field' => 'water_charges'],
    'tab-license'  => ['label' => 'License Fee',     'field' => 'license_fee'],
    'tab-cgst'     => ['label' => 'CGST',            'field' => 'cgst'],
    'tab-sgst'     => ['label' => 'SGST',            'field' => 'sgst'],
    'tab-recovery' => ['label' => 'Recovery',        'field' => 'recovery'],
    'tab-total'    => ['label' => 'Total',           'field' => 'total'],
];
@endphp

<div class="d-flex justify-content-between mb-3">
    <h3>Projects – Recoveries</h3>
</div>

{{-- Filters --}}
<div class="row mb-3">
    <div class="col-md-4">
        <input id="filterProject" class="form-control" placeholder="Project name">
    </div>
    <div class="col-md-4">
        <input id="filterNit" class="form-control" placeholder="Agreement No">
    </div>
    <div class="col-md-4">
        <input id="filterDept" class="form-control" placeholder="Department">
    </div>
</div>

{{-- Tabs --}}
<div class="tabs">
@foreach($recoveryTabs as $key=>$tab)
    <button class="tab {{ $loop->first?'active':'' }}"
            onclick="switchTab('{{ $key }}',this)">
        {{ $tab['label'] }}
    </button>
@endforeach
</div>

<div class="tab-content">

@foreach($recoveryTabs as $tabKey=>$tab)
<div class="content2 emd {{ $tabKey }} {{ $loop->first?'show':'' }}">
    <table
            class="table table-bordered recovery-table class-table recoverytablee"
            data-tab="{{ $tabKey }}"
        >
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Project</th>
                <th class="text-center">Agreement</th>
                <th class="text-center">State</th>
                <th class="text-center">Department</th>
                <th class="text-center">Estimate</th>
                <th class="text-center">EMD</th>
                <th class="text-center">{{ $tab['label'] }}</th>
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
           @foreach($projects as $row)

                <tr>
                   <td class="text-center" class="text-center">{{ $i }}</td>
                    <td class="text-center" style="
                            text-align: justify;
                            text-align-last: justify;
                            text-justify: inter-word;
                            hyphens: auto;
                            word-break: break-word;
                        ">
                        {!! implode('<br>', array_map(
                            fn($chunk) => implode(' ', $chunk),
                            array_chunk(explode(' ', $row->project_name), 10)
                        )) !!}
                    </td>
                    <td class="text-center">{{ $row->agreement_no }}</td>
                    <td class="text-center">{{ $row->state_name ?? '-' }}</td>
                    <td class="text-center">{{ $row->department_name ?? '-' }}</td>
                    <td class="text-center">{{ number_format($row->estimated_amount,2) }}</td>
                    <td class="text-center">{{ number_format($row->emd_amount ?? 0,2) }}</td>
                    <td class="text-center">{{ number_format($row->{$tab['field']} ?? 0,2) }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach

        </tbody>
    </table>
</div>
@endforeach

</div>

<style>
    .tabs{display:flex;border-bottom:1px solid #ddd}
    .tab{padding:12px 20px;cursor:pointer;border:none;background:#f5f5f5}
    .tab.active{background:#fff;font-weight:bold;border-bottom:2px solid #0d6efd}
    .content2{display:none}
    .content2.show{display:block}
</style>

@endsection

@push('scripts')
<script>

    let currentTab='tab-security'

    let dataTables = {};

    $(document).ready(function () {

        $('.recoverytablee').each(function () {

            let tabKey = $(this).data('tab');

            // 🔥 FIX: destroy if already initialised
            if ($.fn.DataTable.isDataTable(this)) {
                $(this).DataTable().destroy();
            }

            dataTables[tabKey] = $(this).DataTable({
                scrollX: true,
                autoWidth: false,
                pageLength: 10,
                ordering: true,
                searching: true,
                 /* 🔥 GUARANTEED ROW COLOR FIX */
                createdRow: function (row, data, index) {
                    let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
                    $('td', row).css('background-color', bg);
                },

                rowCallback: function (row, data, index) {
                    let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

                    $(row).off('mouseenter mouseleave').hover(
                        () => $('td', row).css('background-color', '#e9ecff'),
                        () => $('td', row).css('background-color', base)
                    );
                }
            });

        });

    });

    function switchTab(tab, btn) {

        currentTab = tab;

        // Activate tab button
        document.querySelectorAll('.tab')
            .forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        // Show tab content
        document.querySelectorAll('.content2')
            .forEach(c => c.classList.remove('show'));
        document.querySelector('.' + tab).classList.add('show');

        // Adjust DataTable
        setTimeout(() => {
            if (dataTables[tab]) {
                dataTables[tab].columns.adjust().draw(false);
            }
        }, 20);
    }

    $('#filterProject').on('keyup',function(){
        $('.recovery-table tbody tr').show().filter(function(){
            return !$(this).find('td:eq(1)').text().toLowerCase().includes($('#filterProject').val().toLowerCase())
        }).hide()
    })

    $('#filterNit').on('keyup',function(){
        $('.recovery-table tbody tr').show().filter(function(){
            return !$(this).find('td:eq(2)').text().toLowerCase().includes($('#filterNit').val().toLowerCase())
        }).hide()
    })

    $('#filterDept').on('keyup',function(){
        $('.recovery-table tbody tr').show().filter(function(){
            return !$(this).find('td:eq(4)').text().toLowerCase().includes($('#filterDept').val().toLowerCase())
        }).hide()
    })
</script>
@endpush
