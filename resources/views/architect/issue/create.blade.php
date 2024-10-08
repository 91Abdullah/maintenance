

@extends('layouts.architect')

@section('title', 'Issues')
@section('desc', 'Create a new issue model.')
@section('icon', 'fas fa-question-circle')

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form method="post" action="{{ route('issue.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-form-label col-sm-2">Name</label>
                    <div class="col-sm-10">
                        <input name="name" type="text" id="name" placeholder="Name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="active" class="col-form-label col-sm-2">Active</label>
                    <div class="col-sm-10">
                        <input name="active" id="active" class="form-control @error('active') is-invalid @enderror" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" {{ old('active') ? 'checked' : '' }}>
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
                        <textarea rows="3" name="desc" id="name" placeholder="Description" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') }}</textarea>
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
