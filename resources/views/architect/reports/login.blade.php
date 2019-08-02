@extends('layouts.architect')

@section('title', 'Report - Login')
@section('icon', 'lnr-users')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fc-3.2.5/fh-3.1.4/r-2.2.2/sc-2.0.0/sl-1.3.0/datatables.min.css"/>
@endpush

@section('content')

    <div class="accordion-wrapper" id="accordionExample">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                    <span class="m-0 p-0 font-size-xlg">Select Filters</span>
                </button>
            </div>
            <div class="card-body collapse show" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                <form method="post" id="submitReport" action="{{ route('report.login.post') }}">

                    <input id="from_datetime" type="hidden" value="{{ old('from_datetime') }}" name="from_datetime">
                    <input id="to_datetime" type="hidden" value="{{ old('to_datetime') }}" name="to_datetime">

                    <div class="form-group row">
                        <label for="datetimes" class="col-form-label col-sm-2">Date Range</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="datetimes" type="text" name="datetimes" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_id" class="col-form-label col-sm-2">User(s)</label>
                        <div class="col-sm-10">
                            <select multiple class="multiselect-dropdown form-control" id="user_id" name="user_id[]">
                                @foreach(\App\User::whereNotIn('username', ['nimda', 'admin'])->pluck('name', 'id') as $index => $name)
                                    <option value="{{ $index }}">{{ $name }}</option>
                                @endforeach
                            </select>
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
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Session</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    <th>Duration (mins)</th>
                    <th>User</th>
                </tr>
                </thead>
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
                {'data' : 'ip_address', 'title' : 'IP Address'},
                {'data' : 'user_agent', 'title' : 'User Agent'},
                {'data' : 'session_id', 'title' : 'Session'},
                {'data' : 'login_time', 'title' : 'Login Time'},
                {'data' : 'logout_time', 'title' : 'Logout Time'},
                {'data' : 'duration', 'title' : 'Duration (mins)'},
                {'data' : 'user_id', 'title' : 'User'}
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
                        url: "{!! route('report.login.post') !!}",
                        method: "post",
                        data: {
                            datetimes: document.getElementById('datetimes').value,
                            paginate: document.getElementById("paginate").value,
                            user_id: $("#user_id").val(),
                        }
                        /*success: (result, response, xhr) => {
                            console.log(result, response, xhr);
                        }*/
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'colvis', 'pageLength','copy', 'csv', 'excel', 'pdf', 'print',
                    ],
                    order: [[0, 'desc']],
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


