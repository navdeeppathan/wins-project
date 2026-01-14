
<div class="mt-4">
    <h3 class="mb-3">Activities</h3>
    @if(isset($allactivities) && $allactivities->count() > 0)
        <div class="table-responsive">
                <table id="activitiesTable" class="table class-table table-bordered" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Activity Name *</th>
                            <th>From Date *</th>
                            <th>To Date *</th>
                            <th>Target *</th>
                            <th>Progress *</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allactivities as $index => $activity)
                        <tr >
                            <td>{{ $index+1 }}</td>
                            <td>{{ $activity->activity_name }}</td>
                            <td>{{ $activity->from_date->format('Y-m-d') }}</td>
                            <td>{{ $activity->to_date->format('Y-m-d') }}</td>
                            <td>
                                {{ $activity->weightage }}
                            </td>
                            
                            <td>
                                {{  $activity->progress }}
                                
                            </td>

                        </tr>
                    
                        @endforeach
                    </tbody>
                </table>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No data found.
        </div>
    @endif
</div>

@push('scripts')
<script>
        new DataTable('#activitiesTable', {
            scrollX: true,
            scrollCollapse: true,
            responsive: false,
            autoWidth: false,

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
</script>   
 @endpush   