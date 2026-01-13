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

<table class="table table-bordered recovery-table">
<thead>
<tr>
    <th>#</th>
    <th>Project</th>
    <th>Agreement</th>
    <th>State</th>
    <th>Department</th>
    <th>Estimate</th>
    <th>EMD</th>
    <th>{{ $tab['label'] }}</th>
</tr>
</thead>
<tbody>

    
@foreach($projects as $project)



    @foreach($project->billings as $billing)
    
   
        @php
            $recs = $billing->recoveries ?? collect();
            
        @endphp

        @if($recs->isEmpty())
            @continue
        @endif

        @foreach($recs as $rec)

        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->agreement_no }}</td>
            <td>{{ $project->state->name ?? '-' }}</td>
            <td>{{ $project->departments->name ?? '-' }}</td>
            <td>{{ number_format($project->estimated_amount,2) }}</td>
            <td>{{ number_format($project->emd_amount ?? 0,2) }}</td>


            {{-- dynamic recovery --}}
            <td>{{ number_format($rec->{$tab['field']} ?? 0,2) }}</td>
        </tr>
        @endforeach
    @endforeach
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

    function switchTab(tab,btn){
        currentTab=tab
        document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'))
        btn.classList.add('active')
        document.querySelectorAll('.content2').forEach(c=>c.classList.remove('show'))
        document.querySelector('.'+tab).classList.add('show')
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
