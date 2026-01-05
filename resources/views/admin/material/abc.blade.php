{{-- resources/views/user/vms/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Inventory')

@section('content')


<link rel="stylesheet" href="{{ asset('/frontend/css/vm-card.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<style>
    .kyc-status-card {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .kyc-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .kyc-icon-success {
        background: #d1fae5;
        color: #059669;
    }

    .kyc-icon-warning {
        background: #fef3c7;
        color: #d97706;
    }

    .kyc-checklist {
        list-style: none;
        padding-left: 0;
    }

    .kyc-checklist li {
        padding-left: 1.5rem;
        position: relative;
        margin-bottom: 0.375rem;
    }

    .kyc-checklist li:before {
        content: "○";
        position: absolute;
        left: 0;
        color: #9ca3af;
        font-weight: bold;
    }

    .btn-warning {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
        font-weight: 500;
    }

    .btn-warning:hover {
        background: #d97706;
        border-color: #d97706;
        color: #ffffff;
    }

    @media (max-width: 576px) {
        .kyc-status-card {
            padding: 1rem;
        }

        .kyc-icon {
            width: 40px;
            height: 40px;
        }
    }
</style>

<style>
    .dataTables_wrapper .dataTables_filter {
        float: right !important;
        text-align: right !important;
    }
    .dataTables_wrapper .dataTables_length {
        float: left !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        float: right !important;
    }
</style>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="vmTabs" role="tablist">



            <li class="nav-item" role="presentation">
                 <a class="nav-link active" data-bs-toggle="tab"
                            data-bs-target="#cloud-tab-pane" type="button" role="tab"
                            aria-controls="cloud-tab-pane" aria-selected="true">

                    Material
                </a>
            </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#purchase-tab-pane" type="button" role="tab"
                        aria-controls="purchase-tab-pane" aria-selected="false">
                    TOOLS AND MACHINERY
                </a>
            </li>

    </ul>

    <div class="tab-content" id="vmTabsContent">

        {{-- Cloud --}}
        <div class="tab-pane fade show active" id="cloud-tab-pane" role="tabpanel">

            <div class="table-responsive mt-4">

                <table id="quotes-table" class="table table-hover class-table align-middle" style="width:100%">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Stores</th>
                            <th class="text-center">Measured</th>
                            <th class="text-center">Dismantals</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center" width="">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if(!empty($items))
                            @foreach($items as $index => $i)

                                        <tr data-id="{{ $i->id }}">
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $i->description }}</td>

                                            <td>{{ $i->quantity }}</td>

                                            <td>{{$i->scheduleOfWorks->sum('measured_quantity')}}</td>
                                            <td>
                                                        <input type="number" step="0.01"
                                                            class="form-control form-control-sm dismantals"
                                                            value="{{ $i->dismantals }}" required>
                                            </td>

                                            <td>
                                                <input type="number" step="0.01"
                                                    class="form-control form-control-sm dismantal_rate"
                                                    value="{{ $i->dismantal_rate }}" required>
                                            </td>
                                            <td class="dismantal_amount">0.00</td>


                                            <td>
                                                        <button class="btn btn-sm btn-success saveDismantalBtn1"
                                                                data-id="{{ $i->id }}">
                                                            Save
                                                        </button>
                                            </td>
                                        </tr>

                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Data not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>

        {{-- purchase vms --}}
        <div class="tab-pane fade" id="purchase-tab-pane" role="tabpanel">
            <div class="table-responsive mt-4">
                <table id="quotes-table" class="table table-hover class-table align-middle" style="width:100%">
                    <thead class="table-light text-center">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">T&P</th>
                            <th class="text-center">Dismantals</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center" width="">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if(!empty($schedules))
                            @foreach($schedules as $index => $i)

                                <tr data-id="{{ $i->id }}">
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $i->description }}</td>

                                    <td>{{$i->scheduleOfWorks->sum('measured_quantity')}}</td>

                                    <td>
                                                <input type="number" step="0.01"
                                                    class="form-control form-control-sm dismantals"
                                                    value="{{ $i->dismantals }}" required>
                                    </td>

                                    <td>
                                                <input type="number" step="0.01"
                                                    class="form-control form-control-sm dismantal_rate"
                                                    value="{{ $i->dismantal_rate }}" required>
                                    </td>
                                    <td class="dismantal_amount">0.00</td>

                                    <td>
                                                <button class="btn btn-sm btn-success saveDismantalBtn2"
                                                        data-id="{{ $i->id }}">
                                                    Save
                                                </button>
                                    </td>
                                </tr>

                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var options = {
            responsive: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            stateSave: true,
            language: {
                searchPlaceholder: "Search records",
                search: ""
            }
        };

        $('#vms-table, #products-table, #example, #quotes-table').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable(options);

            }
        });

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust().responsive.recalc();
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Allow dropdown "My Invoices" / "My Quotes" to open the correct tab pane
        $(document).on('click', '.dropdown-item[data-bs-toggle="tab"]', function (e) {
            e.preventDefault();

            const target = $(this).attr('href'); // e.g. "#invoices-tab-pane"

            // Hide any open dropdown
            $(this).closest('.dropdown-menu').removeClass('show');
            $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');

            // Activate the tab using Bootstrap’s Tab API
            const tabTrigger = new bootstrap.Tab(document.querySelector('[data-bs-target="' + target + '"]'));
            tabTrigger.show();

            // Scroll to the tab content (optional, for better UX)
            $('html, body').animate({
                scrollTop: $(target).offset().top - 80
            }, 300);
        });
    });
</script>

<script>
$(document).on('click', '.saveDismantalBtn1', function () {

    let btn = $(this);
    let row = btn.closest('tr');

    let dismantals = row.find('.dismantals').val();


    if (!dismantals) {
        alert('Please fill all required fields');
        return;
    }

    let inventoryId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");

    formData.append(
        'dismantals',
        row.find('.dismantals').val()
    );

    formData.append(
        'dismantal_rate',
        row.find('.dismantal_rate').val()
    )

    formData.append(
        'dismantal_amount',
        row.find('.dismantal_amount').text()
    )



    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + inventoryId + "/inventory-update",
        type: "POST", // IMPORTANT
        data: formData,
        processData: false, // required for FormData
        contentType: false, // required for FormData
        success: function (response) {
            btn.prop('disabled', false).text('Save');

            if (response.success) {
                window.location.reload();
                alert(response.message);


            } else {
                alert('Update failed');
            }
        },
        error: function (xhr) {
            btn.prop('disabled', false).text('Save');
            alert('Server error');
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '.saveDismantalBtn2', function () {

    let btn = $(this);
    let row = btn.closest('tr');

    let dismantals = row.find('.dismantals').val();


    if (!dismantals) {
        alert('Please fill all required fields');
        return;
    }

    let inventoryId = btn.data('id');

    let formData = new FormData();
    formData.append('_method', 'PUT'); // spoof PUT
    formData.append('_token', "{{ csrf_token() }}");

    formData.append(
        'dismantals',
        row.find('.dismantals').val()
    );

    formData.append(
        'dismantal_rate',
        row.find('.dismantal_rate').val()
    )

    formData.append(
        'dismantal_amount',
        row.find('.dismantal_amount').text()
    )



    btn.prop('disabled', true).text('Saving...');

    $.ajax({
        url: "/admin/projects/" + inventoryId + "/inventory-update",
        type: "POST", // IMPORTANT
        data: formData,
        processData: false, // required for FormData
        contentType: false, // required for FormData
        success: function (response) {
            btn.prop('disabled', false).text('Save');

            if (response.success) {
                window.location.reload();
                alert(response.message);


            } else {
                alert('Update failed');
            }
        },
        error: function (xhr) {
            btn.prop('disabled', false).text('Save');
            alert('Server error');
            console.error(xhr.responseText);
        }
    });
});







</script>
<script>
function calculateRowAmount(row) {
    let dismantals = parseFloat(row.find('.dismantals').val()) || 0;
    let rate       = parseFloat(row.find('.dismantal_rate').val()) || 0;

    let amount = dismantals * rate;
    row.find('.dismantal_amount').text(amount.toFixed(2));
}
</script>
<script>
$(document).ready(function () {
    $('#quotes-table tbody tr').each(function () {
        calculateRowAmount($(this));
    });
});
</script>
<script>
$(document).on('input', '.dismantals, .dismantal_rate', function () {
    let row = $(this).closest('tr');
    calculateRowAmount(row);
});
</script>

@endsection
