<?php

namespace App\Http\Controllers\Backend;

use App\Complain;
use App\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $query = Issue::all();
        if(request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('edit', function (Issue $issue) {
                    $route = route('issue.edit', $issue->id);
                    return "<a href='$route' class='mb-2 mr-2 btn-icon btn btn-primary'><i class='pe-7s-tools btn-icon-wrapper'></i> Edit</a>";
                })
                ->editColumn('active', function (Issue $issue) {
                    $outletText = $issue->active == true ? "Active" : "Inactive";
                    $badge = $issue->active  == true ? "success" : "danger";
                    return "<a href='javascript:void(0);' class='mb-2 mr-2 badge badge-$badge ? success : danger'>$outletText</a>";
                })
                ->editColumn('created_at', function (Issue $issue) {
                    return Carbon::parse($issue->created_at)->diffForHumans();
                })
                ->rawColumns(['edit', 'active'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'active', 'title' => 'Status'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'edit', 'title' => '']
        ]);
        return view('architect.issue.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('architect.issue.create');
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
            'name' => 'required', 'string', 'unique:issues,name',
            'active' => 'in:on'
        ]);

        $outlet = Issue::create([
            'name' => $request->name,
            'active' => $request->has('active') && $request->active == "on" ? true : false,
            'desc' => $request->desc ?: null
        ]);
        return redirect()->route('issue.index')->with('status', 'Issue has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        return view('architect.issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'name' => 'required', 'string', 'unique:issues,name',
            'active' => 'in:on'
        ]);

        $issue->update([
            'name' => $request->name,
            'active' => $request->has('active') && $request->active == "on" ? true : false,
            'desc' => $request->desc ?: null
        ]);
        return redirect()->route('issue.index')->with('status', 'Issue has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        if($issue->complains()->count() > 0) {
            $complains = $issue->complains->map(function (Complain $complain) {
                return $complain->getComplainNumber();
            });
            return redirect()->route('issue.index')->with('failure', "This complaint type has following complains associated with it. Please disassociate them before deleting. $complains")->with('links', $complains);
        }

        try {
            $issue->delete();
        } catch (\Exception $e) {
            return redirect()->route('issue.index')->with('failure', "Failed: " . $e->getMessage());
        }

        return redirect()->route('issue.index')->with('status', 'Issue has been deleted');
    }
}
