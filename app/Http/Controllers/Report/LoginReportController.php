<?php

namespace App\Http\Controllers\Report;

use App\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class LoginReportController extends Controller
{
    public function index()
    {
        return view('architect.reports.login');
    }

    public function report(Request $request)
    {
        if($request->ajax()) {
            $query = UserLogin::with('user')->whereHas('user', function ($q) {
                $q->with('roles')->whereHas('roles', function ($q) {
                    $q->whereNotIn('name', ['superadmin']);
                });
            });
            if($request->has("datetimes")) {
                $datetimes = explode(" - ", $request->datetimes);
                $from = Carbon::parse($datetimes[0])->format("Y-m-d H:i:s");
                $to = Carbon::parse($datetimes[1])->format("Y-m-d H:i:s");
                $query->whereBetween("created_at", [$from, $to]);
            }
            if($request->user_id !== null) {
                $query->whereIn("user_id", $request->user_id);
            }

            return DataTables::of($query->get())
                ->editColumn('user_id', function (UserLogin $userLogin) {
                    return $userLogin->user->name;
                })
                ->addColumn('duration', function (UserLogin $userLogin) {
                    if ($userLogin->logout_time !== null) {
                        $logout = Carbon::parse($userLogin->login_time);
                        return Carbon::parse($userLogin->logout_time)->diffInMinutes($logout);
                    }

                })
                ->toJson();
        } else {
            return response()->json([], 401);
        }
    }
}
