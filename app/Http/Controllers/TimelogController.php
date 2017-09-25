<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Timelog;
use App\Employee;
class TimelogController extends Controller
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
         $hours = DB::table('time_log')
        ->leftJoin('employees', 'time_log.employee_id', '=', 'employees.id')
        ->leftJoin('company', 'employees.company_id', '=', 'company.id')
        ->select('time_log.*','employees.*','time_log.comments as log_comments', 'company.name as company_name', 'company.id as company_id','company.contact as contact')
        ->paginate(5);

        return view('system-mgmt/timelog/index', ['hours' => $hours]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response*/
     
    public function create()
    {
        $employees = Employee::all();
		
        return view('system-mgmt/timelog/create', ['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	
    public function store(Request $request)
    {
        
        $this->validateInput($request);
		$timelog = new Timelog;
        $timelog->employee_id = $request->employee_id;
		$timelog->workdate = $request->hiredDate;
		$timelog->hours = $request->hours;
		$timelog->comments = $request->comments;
		$timelog->save();
		
		

        return redirect()->intended('system-management/timelog');
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
        $timelog = Timelog::find($id);
        // Redirect to city list if updating city wasn't existed
        if ($timelog == null || count($timelog) == 0) {
            return redirect()->intended('/system-management/timelog');
        }

        //$states = State::all();
        return view('system-mgmt/timelog/edit', ['timelog' => $timelog]);
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
        $timelog = Timelog::findOrFail($id);
         $this->validate($request, [
        'hours' => 'required|numeric'
        ]);
        $input = [
            'workdate' => $request['hiredDate'],
			'hours' => $request['hours'],
			'comments' => $request['comments']
            
        ];
        Timelog::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/timelog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Timelog::where('id', $id)->delete();
         return redirect()->intended('system-management/timelog');
    }

    /**
     * Search city from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'workdate' => $request['hiredDate']
            ];

       $timelog = $this->doSearchingQuery($constraints);
       return view('system-mgmt/timelog/index', ['hours' => $timelog, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('time_log')
				->leftJoin('employees', 'time_log.employee_id', '=', 'employees.id')
				->select('employees.*','time_log.*')
				->where('workdate',$constraints['workdate']);
		/*
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], '=', '$constraint');
            }

            $index++;
        }*/
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'hours' => 'required|numeric'
    ]);
    }
}
