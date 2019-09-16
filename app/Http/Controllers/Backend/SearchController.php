<?php

namespace App\Http\Controllers\Backend;

use App\Customer;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function searchCustomer(Request $request)
    {
        $query = $request->q;
        $results = Customer::where("name", "like", "%$query%")->get();
        return response()->json($results);
    }

    public function getMainUser(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'department_id' => ['required', 'exists:departments,id']
            ]);

            $department = Department::findOrFail($request->department_id);
            $users = $department->maintenance_users;
            $response = [];
            foreach ($users as $user) {
                $response[] = ['id' => $user->id, 'text' => $user->name];
            }
            return response()->json($response);
        } else {
            return response()->json("Invalid Request", 401);
        }
    }
}
