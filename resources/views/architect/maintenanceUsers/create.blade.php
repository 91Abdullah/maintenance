

@extends('layouts.architect')

@section('title', 'Maintenance Users')
@section('desc', 'Create a new maintenance user model.')
@section('icon', 'fas fa-users-cog')

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form method="post" action="{{ route('maintenanceUsers.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-form-label col-sm-2">Name</label>
                    <div class="col-sm-10">
                        <input name="name" type="text" id="name" placeholder="Name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="number" class="col-form-label col-sm-2">Number</label>
                    <div class="col-sm-10">
                        <input name="number" type="text" id="number" placeholder="Number" value="{{ old('number') }}" class="form-control @error('number') is-invalid @enderror" required>
                        @error('number')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="city" class="col-form-label col-sm-2">City</label>
                    <div class="col-sm-10">
                        <select name="city" type="text" id="city" class="form-control city-select @error('city') is-invalid @enderror" required>
                            <option></option>
                        </select>
                        @error('city')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="department" class="col-form-label col-sm-2">Department</label>
                    <div class="col-sm-10">
                        <select name="department" id="department" class="form-control singleselect-dropdown @error('department') is-invalid @enderror" required>
                            @foreach(\App\Department::all() as $department)
                                <option {{ old('department') == $department->id ? 'selected' : ''  }} value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-wrench"></i> Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/scripts/cities.js') }}"></script>
    <script>
        let selected = "{{ old('city') }}";
        $(document).ready(function () {
            $('.city-select').select2({
                placeholder: 'Select City',
                theme: 'bootstrap4',
                data: data,
                selected: selected
            });
            $('.city-select').val(selected).trigger("change");
        });
    </script>
@endpush
