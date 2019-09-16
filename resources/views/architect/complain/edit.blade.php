

@extends('layouts.architect')

@section('title', 'Complains')
@section('desc', 'Edit Complain / Ticket# ' . $complain->getComplainNumber())
@section('icon', 'pe-7s-comment')

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form method="post" action="{{ route('complain.update', $complain->id) }}">
                @method('patch')
                @csrf

                <div class="form-group row">
                    <label for="outlet_id" class="col-form-label col-sm-2">Location <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('outlet_id') is-invalid @enderror" style="width: 100%; height: 100%" name="outlet_id" id="outlet_id" required>
                            <option></option>
                            @foreach(\App\Outlet::pluck('name', 'id') as $index => $outlet)
                                <option {{ old('outlet_id')  == $index || $complain->outlet->id == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $outlet }}</option>
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
                        <select class="form-control singleselect-dropdown @error('issue_id') is-invalid @enderror" style="width: 100%;" name="issue_id" id="issue_id" required>
                            @foreach(\App\Issue::pluck('name', 'id') as $index => $issue)
                                <option value="{{ $index }}" {{ $complain->issues()->get()->contains('id', $index) ? 'selected' : '' }}>{{ $issue }}</option>
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
                                <option {{ old('ticket_status_id') == $index || $complain->ticket_status->id == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $status }}</option>
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
                    <label for="resolved_by" class="col-form-label col-sm-2">Resolved By</label>
                    <div class="col-sm-10">
                        <input name="resolved_by" type="text" id="resolved_by" placeholder="Resolved By" value="{{ old('resolved_by') ?? $complain->resolved_by }}" class="form-control @error('resolved_by') is-invalid @enderror" disabled>
                        @error('resolved_by')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="maintenance_user_id" class="col-form-label col-sm-2">informed To <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('maintenance_user_id') is-invalid @enderror" style="width: 100%; height: 100%" name="maintenance_user_id" id="maintenance_user_id" required>
                            <option></option>
                            @foreach(\App\MaintenanceUser::pluck('name', 'id') as $index => $maintenanceUser)
                                <option {{ $complain->maintenance_user->id == $index || old('maintenance_user_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $maintenanceUser }}</option>
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
                    <label for="message_recipient_id" class="col-form-label col-sm-2">SMS Recipients</label>
                    <div class="col-sm-10">
                        <select class="form-control multiselect-dropdown @error('message_recipient_id') is-invalid @enderror" style="width: 100%; height: 100%" name="message_recipient_id[]" id="message_recipient_id" multiple>
                            <option></option>
                            @foreach(\App\MessageRecipient::pluck('name', 'id') as $index => $messageRecipient)
                                <option {{ $complain->message_recipients->contains($index) || $complain->message_recipients->contains(old('message_recipient_id')) ? 'selected' : ''  }} value="{{ $index }}">{{ $messageRecipient }}</option>
                            @endforeach
                        </select>
                        @error('message_recipient_id')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="desc" class="col-form-label col-sm-2">Description</label>
                    <div class="col-sm-10">
                        <textarea rows="3" name="desc" id="desc" placeholder="Description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') ?: $complain->desc }}</textarea>
                        @error('desc')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="remarks" class="col-form-label col-sm-2">Remarks / Feedback</label>
                    <div class="col-sm-10">
                        <textarea rows="3" name="remarks" id="remarks" placeholder="Remarks / Feedback" class="form-control @error('desc') is-invalid @enderror">{{ old('remarks') ?: $complain->remarks }}</textarea>
                        @error('remarks')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-cogs"></i> UPDATE</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>

        $("#ticket_status_id").on("select2:select", (e) => {
            let elem = $("#ticket_status_id option:selected");
            if(elem.text() === "Closed")
            {
                $("#resolved_by").attr("disabled", false);
                $("#resolved_by").attr("required", true);
            } else {
                $("#resolved_by").attr("disabled", true);
                $("#resolved_by").attr("required", false);
            }
        });

        $('#issue_id').prop('disabled', true);
        $('#maintenance_user_id').prop('disabled', true);
        $('#outlet_id').prop('disabled', true);
        $('#message_recipient_id').prop('disabled', true);

    </script>
@endpush
