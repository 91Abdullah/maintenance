@extends('layouts.architect')

@section('title', 'Report - Complains')
@section('icon', 'lnr-database')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fc-3.2.5/fh-3.1.4/r-2.2.2/sc-2.0.0/sl-1.3.0/datatables.min.css"/>
@endpush

@section('content')

    <div class="accordion-wrapper" id="accordionExample">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                    <h5 class="m-0 p-0">Select Filters</h5>
                </button>
            </div>
            <div class="card-body collapse show" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                <form method="post" id="submitReport" action="{{ route('report.complain.post') }}">

                    <input id="from_datetime" type="hidden" value="{{ old('from_datetime') }}" name="from_datetime">
                    <input id="to_datetime" type="hidden" value="{{ old('to_datetime') }}" name="to_datetime">

                    <div class="form-group row">
                        <label for="datetimes" class="col-form-label col-sm-2">Date Range</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="datetimes" type="text" name="datetimes" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id" class="col-form-label col-sm-2">Complain ID</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="id" type="text" name="id" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="outlet_id" class="col-form-label col-sm-2">Location</label>
                        <div class="col-sm-10">
                            <select class="multiselect-dropdown form-control" id="outlet_id" name="outlet_id[]" multiple>
                                @foreach(\App\Outlet::pluck('name', 'id') as $index => $name)
                                    <option {{ old('outlet_id') == $index ? 'selected' : '' }} value="{{ $index }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_id" class="col-form-label col-sm-2">Created By</label>
                        <div class="col-sm-10">
                            <select multiple class="multiselect-dropdown form-control" id="user_id" name="user_id[]">
                                @foreach(\App\User::pluck('name', 'id') as $index => $name)
                                    <option value="{{ $index }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ticket_status_id" class="col-form-label col-sm-2">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control multiselect-dropdown @error('ticket_status_id') is-invalid @enderror" name="ticket_status_id[]" id="ticket_status_id" style="width: 100%;" multiple>
                                <option></option>
                                @foreach(\App\TicketStatus::pluck('name', 'id') as $index => $status)
                                    <option {{ old('ticket_status_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('ticket_status_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="maintenance_user_id" class="col-form-label col-sm-2">Informed To</label>
                        <div class="col-sm-10">
                            <select class="form-control multiselect-dropdown @error('maintenance_user_id') is-invalid @enderror" style="width: 100%; height: 100%" name="maintenance_user_id[]" id="maintenance_user_id" multiple>
                                <option></option>
                                @foreach(\App\MaintenanceUser::pluck('name', 'id') as $index => $maintenanceUser)
                                    <option {{ collect(old('maintenance_user_id'))->contains($index) ? 'selected' : ''  }} value="{{ $index }}">{{ $maintenanceUser }}</option>
                                @endforeach
                            </select>
                            @error('maintenance_user_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="informed_by" class="col-form-label col-sm-2">Informed By</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="informed_by" name="informed_by" value="{{ old('informed_by') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="resolved_by" class="col-form-label col-sm-2">Resolved By</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="resolved_by" name="resolved_by" value="{{ old('resolved_by') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="paginate" class="col-form-label col-sm-2">Paginate</label>
                        <div class="col-sm-10">
                            <select class="singleselect-dropdown form-control" name="paginate" id="paginate">
                                @foreach(['10', '25', '50', '100', 'All'] as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form row">
                        <div class="col-sm-10 offset-2">
                            <button class="mb-2 mr-2 btn-icon btn btn-success">
                                <i class="pe-7s-tools btn-icon-wrapper"></i>Apply
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body table-responsive">
            <table id="datatable" style="width: 100%;" class="table table-borderless table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Location</th>
                    <th>Informed By</th>
                    <th>Resolved By</th>
                    <th>Informed To</th>
                    <th>Status</th>
                    <th>Issue</th>
                    <th>Created</th>
                    <th>By</th>
                    <th>Closed</th>
                    <th>Dur.</th>
                </tr>
                </thead>
                {{--<tbody>
                <tr>
                    <td colspan="10" class="font-size-lg font-weight-bold text-center">
                        Apply filters to display data.
                    </td>
                </tr>
                </tbody>--}}
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fc-3.2.5/fh-3.1.4/r-2.2.2/sc-2.0.0/sl-1.3.0/datatables.min.js"></script>
    <script>
        $(function() {
            let submit = document.getElementById('submitReport');
            let table = undefined;
            $.fn.dataTable.ext.errMode = 'none';
            let columns = [
                {'data' : 'id', 'title' : '#'},
                {'data' : 'outlet_id', 'title' : 'Location'},
                {'data' : 'informed_by', 'title' : 'Informed By'},
                {'data' : 'resolved_by', 'title' : 'Resolved By'},
                {'data' : 'maintenance_user_id', 'title' : 'Informed To'},
                {'data' : 'ticket_status_id', 'title' : 'Status'},
                {'data' : 'issue_id', 'title' : 'Issue'},
                {'data' : 'created_at', 'title' : 'Created'},
                {'data' : 'user_id', 'title' : 'By'},
                {'data' : 'closure_time', 'title' : 'Closed'},
                {'data' : 'time_taken', 'title' : 'Dur.'}
            ];

            let start = moment().startOf('day');
            let end = moment().endOf('day');
            $("#from_datetime").val(start.format("YYYY-MM-DD HH:mm"));
            $("#to_datetime").val(end.format("YYYY-MM-DD HH:mm"));

            var datetime = $('input[name="datetimes"]');
            datetime.daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                startDate: moment().startOf('day'),
                endDate: moment().endOf('day'),
                locale: {
                    format: 'YYYY-MM-DD HH:mm'
                }
            });

            datetime.on("apply.daterangepicker", (ev, picker) => {
                //console.log(ev, picker);
                $("#from_datetime").val(picker.startDate.format("YYYY-MM-DD HH:mm"));
                $("#to_datetime").val(picker.endDate.format("YYYY-MM-DD HH:mm"));
            });

            submit.onsubmit = (e) => {
                e.preventDefault();
                $("#collapseOne").removeClass('show');
                let paginate = document.getElementById("paginate").value;
                table = $("#datatable").DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: "{!! route('report.complain.post') !!}",
                        method: "post",
                        data: {
                            datetimes: document.getElementById('datetimes').value,
                            id: document.getElementById("id").value,
                            outlet_id: $("#outlet_id").val(),
                            user_id: $("#user_id").val(),
                            maintenance_user_id: $("#maintenance_user_id").val(),
                            informed_by: $("#informed_by").val(),
                            resolved_by: $("#resolved_by").val(),
                            ticket_status_id: $("#ticket_status_id").val(),
                        }
                        /*success: (result, response, xhr) => {
                            console.log(result, response, xhr);
                        }*/
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'colvis', 'pageLength','copy', 'csv', 'excel', 'pdf', 'print',
                    ],
                    order: [[8, 'desc']],
                    columns: columns,
                    responsive: true,
                    pageLength: paginate === "All" ? -1 : parseInt(document.getElementById("paginate").value),
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
                });

                table.on("error.dt", (e, settings, techNote, message) => {
                    toastr.error(message);
                });
            }
        });
    </script>
@endpush


