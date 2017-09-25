<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\Company;
class ProjectController extends Controller
{
    
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		 $projects = DB::table('projects')
        ->leftJoin('company', 'projects.company_id', '=', 'company.id')
        ->select('projects.*', 'company.name as company_name', 'company.id as company_id')
		->paginate(5);
		return view('system-mgmt/project/index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$companies = Company::all();
        return view('system-mgmt/project/create', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		//$this->validateInput($request);
		$project = new Project;
        $project->name = $request->name;
		$project->detail = $request->detail;
		$project->company_id = $request->company_id;
		$project->save();

        return redirect()->intended('system-management/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$project = project::find($id);
		$companies = Company::all();
        // Redirect to city list if updating city wasn't existed
        if ($project == null || count($project) == 0) {
            return redirect()->intended('/system-management/project');
        }

        //$states = State::all();
        return view('system-mgmt/project/edit', ['project' => $project,'companies'=>$companies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$project = Project::findOrFail($id);
         $this->validate($request, [
        'name' => 'required|max:60',
		'detail' => 'required|max:300'
        ]);
        $input = [
            'name' => $request['name'],
			'detail' => $request['detail'],
			'company_id' => $request['company_id']
            
        ];
        Project::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		Project::where('id', $id)->delete();
         return redirect()->intended('system-management/project');
    }
	/**
     * Search city from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];
		
       $projects = $this->doSearchingQuery($constraints);
       return view('system-mgmt/project/index', ['projects' => $projects, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = Project::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
}
