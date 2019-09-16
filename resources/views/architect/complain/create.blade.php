

@extends('layouts.architect')

@section('title', 'Complains')
@section('desc', 'Create a new complain / ticket.')
@section('icon', 'pe-7s-comment')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@6.1.0/dist/css/autoComplete.min.css">
@endpush

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form id="form" method="post" action="{{ route('complain.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="outlet_id" class="col-form-label col-sm-2">Location <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('outlet_id') is-invalid @enderror" style="width: 100%; height: 100%" name="outlet_id" id="outlet_id" required>
                            <option></option>
                            @foreach(\App\Outlet::pluck('name', 'id') as $index => $outlet)
                                <option {{ old('outlet_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $outlet }}</option>
                            @endforeach
                        </select>
                        @error('outlet_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="issue_id" class="col-form-label col-sm-2">Complaint Type <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control multiselect-dropdown @error('issue_id') is-invalid @enderror" style="width: 100%;" name="issue_id[]" multiple id="issue_id" required>
                            <option></option>
                            @foreach(\App\Issue::pluck('name', 'id') as $index => $issue)
                                <option {{ collect(old('issue_id'))->contains($index) ? 'selected' : ''  }} value="{{ $index }}">{{ $issue }}</option>
                            @endforeach
                        </select>
                        @error('issue_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ticket_status_id" class="col-form-label col-sm-2">Status <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('ticket_status_id') is-invalid @enderror" name="ticket_status_id" id="ticket_status_id" required style="width: 100%;">
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
                    <label for="informed_by" class="col-form-label col-sm-2">Informed By <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <input name="informed_by" type="text" id="informed_by" placeholder="Informed By" value="{{ old('informed_by') }}" class="form-control @error('informed_by') is-invalid @enderror" required>
                        @error('informed_by')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="department_id" class="col-form-label col-sm-2">Department <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('department_id') is-invalid @enderror" style="width: 100%; height: 100%" name="department_id" id="department_id" required>
                            <option></option>
                            @foreach(\App\Department::pluck('name', 'id') as $index => $department)
                                <option {{ old('department_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $department }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="maintenance_user_id" class="col-form-label col-sm-2">Informed To <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('maintenance_user_id') is-invalid @enderror" style="width: 100%; height: 100%" name="maintenance_user_id" id="maintenance_user_id" required>
                            <option></option>
                        </select>
                        @error('maintenance_user_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="message_recipient_id" class="col-form-label col-sm-2">SMS Recipients</label>
                    <div class="col-sm-10">
                        <select class="form-control multiselect-dropdown @error('message_recipient_id') is-invalid @enderror" style="width: 100%; height: 100%" name="message_recipient_id[]" id="message_recipient_id" multiple>
                            <option></option>
                            @foreach(\App\MessageRecipient::pluck('name', 'id') as $index => $messageRecipient)
                                <option {{ old('message_recipient_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $messageRecipient }}</option>
                            @endforeach
                        </select>
                        @error('message_recipient_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

            {{--<div style="display: none;" id="parent" class="form-group row">
                <label for="desc" class="col-form-label col-sm-2">Description</label>
                <div class="col-sm-3">
                    <textarea id="desc" rows="2" name="desc" id="name" placeholder="Description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') }}</textarea>
                    @error('desc')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>--}}

                <div id="insertBefore" class="form-group row">
                    <label for="remarks" class="col-form-label col-sm-2">Remarks / Feedback</label>
                    <div class="col-sm-10">
                        <textarea rows="3" name="remarks" id="remarks" placeholder="Remarks / Feedback" class="form-control @error('desc') is-invalid @enderror">{{ old('remarks') }}</textarea>
                        @error('remarks')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-cog"></i> SUBMIT</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>

        let url = "{{ route('get.mainUser') }}";
        let _token = "{{ csrf_token() }}";

        $("#department_id").on("select2:select", (e) => {
            let elem = $("#department_id option:selected");
            let id = elem.val();

            $("#maintenance_user_id").select2({
                ajax: {
                    url: url,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            department_id: id,
                            _token: _token
                        }
                    },
                    processResults: function(data, params) {
                        console.log(data);
                        return {
                            results: data
                        };
                    }
                }
            });
        });

        $('#issue_id')
            .on('select2:select', (e) => {
                let elem = $('#issue_id option:selected');
                let text = e.params.data.text;
                let id = e.params.data.id;
                // let __parent = $('#parent');
                let __form = $('#form');
                let __parent = $('<div id="desc_'+ id +'" class="form-group row"><label class="control-label col-sm-2">Description for ' +  text +'</label></div>');

                let newDiv = $('<div class="col-sm-10"><textarea class="form-control" name="desc_'+ id +'" placeholder="Description" rows="3"></textarea></div>');
                __parent.append(newDiv);
                // __form.append(__parent);
               __parent.insertBefore($('#insertBefore'));

            })
            .on('select2:unselect', (e) => {
                let text = e.params.data.text;
                let id = e.params.data.id;

                let elem = $('#desc_' + id);
                elem.remove();
            });

    </script>
@endpush
