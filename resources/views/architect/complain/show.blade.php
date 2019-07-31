

@extends('layouts.architect')

@section('title', 'Complains')
@section('desc', 'Showing Complain# ' . $complain->getComplainNumber())
@section('icon', 'pe-7s-comment')

@section('content')

    <div class="main-card mb-3 card">
        <div class="card-body">

            <ul class="list-group">
                <li class="list-group-item">
                    <span>Complain# </span>
                    <span class="font-weight-bold">{{ $complain->getComplainNumber() }}</span>
                </li>
                <li class="list-group-item">
                    <span>Customer Name </span>
                    <span class="font-weight-bold">{{ $complain->customer->name }}</span>
                </li>
                <li class="list-group-item">
                    <span>Outlet </span>
                    <span class="font-weight-bold">{{ $complain->outlet->name }}</span>
                </li>
                <li class="list-group-item">
                    <span>Complaint Type </span>
                    @foreach($complain->issues as $issue)
                        <div class="badge badge-{{ \Illuminate\Support\Arr::random(['success', 'primary', 'secondary', 'info', 'warning']) }}">{{ $issue->name }}</div>
                    @endforeach
                </li>
                <li class="list-group-item">
                    <span>Status </span>
                    @include('architect.datatables.status', ['status' => $complain->ticket_status->name])
                </li>
                <li class="list-group-item">
                    <span>Description </span>
                    <span class="font-weight-bold">{{ $complain->desc }}</span>
                </li>
                <li class="list-group-item">
                    <span>Remarks </span>
                    <span class="font-weight-bold">{{ $complain->remarks }}</span>
                </li>
                <li class="list-group-item">
                    <span>Informed To </span>
                    <span class="font-weight-bold">{{ $complain->maintenance_user->name }}</span>
                </li>
                <li class="list-group-item">
                    <span>Informed by </span>
                    <span class="font-weight-bold">{{ $complain->informed_by }}</span>
                </li>
                <li class="list-group-item">
                    <span>Resolved By </span>
                    <span class="font-weight-bold">{{ $complain->resolved_by == null ?: "Unresolved" }}</span>
                </li>
            </ul>

        </div>
    </div>

@endsection
