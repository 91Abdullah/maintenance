<?php

namespace App\Http\Controllers\Backend;

use App\Department;
use App\Outlet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $query = Department::all();
        if(request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('edit', function (Department $department) {
                    return view('architect.datatables.form-edit', ['route' => 'department', 'model' => $department]);
                })
                ->addColumn('delete', function (Department $department) {
                    return view('architect.datatables.form-delete', ['route' => 'department', 'model' => $department]);
                })
                ->addColumn('active', function (Department $department) {
                    return view('architect.datatables.form-active', ['active' => $department->active]);
                })
                ->editColumn('created_at', function (Department $department) {
                    return Carbon::parse($department->created_at)->diffForHumans();
                })
                ->rawColumns(['edit', 'active', 'delete'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'active', 'title' => 'Status'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'edit', 'title' => ''],
            ['data' => 'delete', 'title' => '']
        ]);
        return view('architect.department.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('architect.department.create');
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
            'name' => ['required', 'string', 'unique:departments,name'],
            'city' => ['required', 'string'],
            'active' => ['in:on']
        ]);

        $depart = Department::create([
            'name' => $request->name,
            'active' => $request->has('active') && $request->active == "on" ? true : false,
            'desc' => $request->desc ?: null,
            'city' => $request->city
        ]);
        return redirect()->route('department.index')->with('status', 'Department has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('architect.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('departments', 'name')->ignore($department->id)],
            'city' => ['required', 'string'],
            'active' => ['in:on']
        ]);

        $department->update([
            'name' => $request->name,
            'city' => $request->city,
            'active' => $request->active == "on" ? true : false,
            'desc' => $request->desc
        ]);

        return redirect()->route('department.index')->with('status', 'Department has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        if($department->has('maintenance_users')) {
            $users = $department->maintenance_users()->pluck('name');
            return redirect()->route('department.index')->with('failure', "This department has following users associated with it. Please remove them before deleting this department. $users");
        }

        try {
            $department->delete();
            return redirect()->route('department.index')->with('status', "Department $department->name has been deleted.");
        } catch (\Exception $e) {
            return redirect()->route('department.index')->with('failure', "Department deletion failied: " . $e->getMessage());
        }
    }
}
