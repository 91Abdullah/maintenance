

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
            <form method="post" action="{{ route('complain.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="search_customer" class="col-form-label col-sm-2">Search Customer</label>
                    <div class="col-sm-10">
                        <select name="search_customer" class="form-control" type="text" id="search_customer">
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 offset-sm-6">
                        <h4 class="font-weight-bold"><i>OR</i></h4>
                    </div>
                </div>

                <input type="hidden" name="customer_id" id="customer_id">

                <div class="form-group">
                    <div class="row">
                        <label for="customer_name" class="col-form-label col-sm-2">Customer Name <sup style="color:red;">*</sup></label>
                        <div class="col-sm-4">
                            <input name="customer_name" type="text" id="customer_name" placeholder="Customer Name" value="{{ old('customer_name') }}" class="form-control @error('customer_name') is-invalid @enderror">
                            @error('customer_name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <label for="customer_number" class="col-form-label col-sm-2">Customer Number <sup style="color:red;">*</sup></label>
                        <div class="col-sm-4">
                            <input name="customer_number" type="text" id="customer_number" placeholder="Customer Number" value="{{ old('customer_number') }}" class="form-control @error('customer_number') is-invalid @enderror">
                            @error('customer_number')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-form-label col-sm-2">Complain Title</label>
                    <div class="col-sm-10">
                        <input name="title" type="text" id="title" placeholder="Title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="outlet_id" class="col-form-label col-sm-2">Outlet <sup style="color:red;">*</sup></label>
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
                    <label for="maintenance_user_id" class="col-form-label col-sm-2">Maintenance User <sup style="color:red;">*</sup></label>
                    <div class="col-sm-10">
                        <select class="form-control singleselect-dropdown @error('maintenance_user_id') is-invalid @enderror" style="width: 100%; height: 100%" name="maintenance_user_id" id="maintenance_user_id" required>
                            <option></option>
                            @foreach(\App\MaintenanceUser::pluck('name', 'id') as $index => $maintenanceUser)
                                <option {{ old('maintenance_user_id') == $index ? 'selected' : ''  }} value="{{ $index }}">{{ $maintenanceUser }}</option>
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

                <div class="form-group row">
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
                    <label for="desc" class="col-form-label col-sm-2">Description</label>
                    <div class="col-sm-10">
                        <textarea id="desc" rows="3" name="desc" id="name" placeholder="Description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') }}</textarea>
                        @error('desc')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let url = "{{ route('search.customer') }}";
        $("#search_customer").select2({
            ajax: {
                url: url,
                dataType: "JSON",
                processResults: (data) => {
                    return {
                        results: $.map(data, (item) => {
                            return {
                                text: item.name,
                                id: item.id,
                                number: item.number
                            }
                        })
                    }
                }
            },
            theme: "bootstrap4",
            placeholder: "Search Customer by Name or Number",
            minimumInputLength: 4,
            templateSelection: (data, container) => {
                $(data.element).attr("data-number", data.number);
                return data.text;
            }
        });

        $("#search_customer").on("select2:select", (e) => {
            let elem = $("#search_customer option:selected");
            let name = elem.text();
            let number = elem.data("number");
            let id = elem.val();

            $("#customer_name").val(name);
            $("#customer_number").val(number);
            $("#customer_id").val(id);
        });
    </script>
@endpush
