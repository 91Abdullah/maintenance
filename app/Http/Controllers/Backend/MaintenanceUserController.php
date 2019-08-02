<?php

namespace App\Http\Controllers\Backend;

use App\Complain;
use App\Department;
use App\MaintenanceUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class MaintenanceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $query = MaintenanceUser::query();
        if(request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('edit', function (MaintenanceUser $maintenanceUser) {
                    return view('architect.datatables.form-edit', ['model' => $maintenanceUser, 'route' => 'maintenanceUsers']);
                })
                ->addColumn('delete', function (MaintenanceUser $maintenanceUser) {
                    return view('architect.datatables.form-delete', ['model' => $maintenanceUser, 'route' => 'maintenanceUsers']);
                })
                ->addColumn('department', function (MaintenanceUser $maintenanceUser) {
                    return $maintenanceUser->department->name;
                })
                ->rawColumns(['edit', 'delete'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'number', 'title' => 'Number'],
            ['data' => 'department', 'title' => 'Department'],
            ['data' => 'created_at', 'title' => 'Created'],
            ['data' => 'updated_at', 'title' => 'Updated'],
            ['data' => 'edit', 'title' => ''],
            ['data' => 'delete', 'title' => ''],
        ]);

        return view('architect.maintenanceUsers.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('architect.maintenanceUsers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'number' => ['required', 'digits:11', 'starts_with:03'],
            'city' => ['required', 'string'],
            'department' => ['required', 'exists:departments,id']
        ]);

        $depart = Department::findOrFail($request->department)->first();
        $depart->maintenance_users()->create($request->all());
        return redirect()->route('maintenanceUsers.index')->with('status', 'Maintenance User has been created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaintenanceUser  $maintenanceUser
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceUser $maintenanceUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceUser  $maintenanceUser
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenanceUser $maintenanceUser)
    {
        return view('architect.maintenanceUsers.edit', compact('maintenanceUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceUser  $maintenanceUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceUser $maintenanceUser)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'number' => ['required', 'digits:11', 'starts_with:03'],
            'city' => ['required', 'string'],
            'department' => ['required', 'exists:departments,id']
        ]);

        if($maintenanceUser->department->id !== $request->department) {
            $maintenanceUser->department_id = $request->department;
            $maintenanceUser->save();
        }

        $maintenanceUser->update($request->all());
        return redirect()->route('maintenanceUsers.index')->with('status', 'Maintenance User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceUser  $maintenanceUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceUser $maintenanceUser)
    {
        if($maintenanceUser->complains()->count() > 0) {
            $complains = $maintenanceUser->complains->map(function (Complain $complain) {
                return $complain->getComplainNumber();
            });
            return redirect()->route('maintenanceUsers.index')->with('failure', "This user has following complains associated with them. Please disassociate them before deleting.")->with('links', $complains);
        }

        try {
            $maintenanceUser->delete();
            return redirect()->route('maintenanceUsers.index')->with('status', "User $maintenanceUser->name has been deleted.");
        } catch (\Exception $e) {
            return redirect()->route('maintenanceUsers.index')->with('failure', "User deletion failed: " . $e->getMessage());
        }
    }
}
