<?php

namespace App\Http\Controllers\Report;

use App\Complain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Matrix\Builder;
use Yajra\DataTables\Facades\DataTables;

class ComplainReportController extends Controller
{
    public function index()
    {
        return view('architect.reports.complains');
    }

    public function report(Request $request)
    {
        if($request->ajax()) {
            $query = Complain::query();
            if($request->has("datetimes")) {
                $datetimes = explode(" - ", $request->datetimes);
                $from = Carbon::parse($datetimes[0])->format("Y-m-d H:i:s");
                $to = Carbon::parse($datetimes[1])->format("Y-m-d H:i:s");
                $query->whereBetween("created_at", [$from, $to]);
            }
            if($request->id !== null) {
                $query->where("id", ltrim($request->id, "0"));
            }
            /*if($request->customer_name !== null) {
                $query->with(["customers" => function(Builder $builder) use ($request) {
                    $builder->where("name", "like", "%$request->customer_name%");
                }]);
            }*/
            if($request->outlet_id !== null) {
                $query->whereIn("outlet_id", $request->outlet_id);
            }
            if($request->user_id !== null) {
                $query->whereIn("user_id", $request->user_id);
            }
            if($request->maintenance_user_id !== null) {
                $query->whereIn('maintenance_user_id', $request->maintenance_user_id);
            }
            if($request->informed_by !== null) {
                $query->where('informed_by', 'like', "%$request->informed_by%");
            }
            if($request->resolved_by !== null) {
                $query->where('resolved_by', 'like', "%$request->resolved_by%");
            }
            if($request->ticket_status_id !== null) {
                $query->whereIn('ticket_status_id', $request->ticket_status_id);
            }

            return DataTables::of($query->get())
                ->editColumn('id', function (Complain $complain) {
                    return "<a class='btn-link' href='" . route('complain.show', $complain->id) . "'>". $complain->getComplainNumber() ."</a>";
                })
                ->editColumn('outlet_id', function (Complain $complain) {
                    return $complain->outlet->name;
                })
                ->editColumn('informed_by', function (Complain $complain) {
                    return $complain->informed_by;
                })
                ->editColumn('resolved_by', function (Complain $complain) {
                    return $complain->resolved_by;
                })
                ->editColumn('user_id', function (Complain $complain) {
                    return $complain->created_by->name;
                })
                ->editColumn('maintenance_user_id', function (Complain $complain) {
                    return $complain->maintenance_user->name;
                })
                ->editColumn('ticket_status_id', function (Complain $complain) {
                    return view('architect.datatables.status', ['status' => $complain->ticket_status->name]);
                })
                ->editColumn('issue_id', function (Complain $complain) {
                    return view('architect.datatables.issues', ['issues' => $complain->issues]);
                })
                ->addColumn('time_taken', function (Complain $complain) {
                    return $complain->closure_time !== null ? Carbon::parse($complain->closure_time)->diffInHours($complain->created_at) : "";
                })
                ->rawColumns(['edit', 'ticket_status_id', 'issue_id', 'id'])
                ->toJson();
        } else {
            return response()->json([], 401);
        }
    }
}
