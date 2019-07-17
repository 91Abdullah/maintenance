

@extends('layouts.architect')

@section('title', 'Departments')
@section('desc', 'Edit Outlet: ' . $department->name)
@section('icon', 'fas fa-bank')

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">

            @if($errors)
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="post" action="{{ route('department.update', $department->id) }}">
                @method('patch')
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-form-label col-sm-2">Name</label>
                    <div class="col-sm-10">
                        <input name="name" type="text" id="name" placeholder="Name" value="{{ old('name') ?: $department->name }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-sm-2">

                    </div>
                    <div class="custom-checkbox custom-control col-sm-10">

                        <input {{ $department->active ? 'checked' : '' }} name="active" type="checkbox" id="active" class="custom-control-input">
                        <label class="custom-control-label" for="active">
                            Active?
                        </label>

                        @error('active')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>


                </div>

                <div class="form-group row">
                    <label for="desc" class="col-form-label col-sm-2">Description</label>
                    <div class="col-sm-10">
                        <textarea rows="3" name="desc" id="name" placeholder="Description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') ?: $department->desc }}</textarea>
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
