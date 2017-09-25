<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Files;
use App\Employee;

class FilesController extends Controller
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
		
		$employees = Employee::all();
		
		return view('employees-mgmt/files/index',['employs'=>$employees]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response*/
     
    public function create()
    {
        $employees = Employee::all();
		
		return view('employees-mgmt/files/create',['employs'=>$employees]);
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
		$file = new Files;
		$file->employee_id = $request->employee;
                $file->name = $request->name;
		$file->comments=$request->comments;
		$file->path=$request->file('userfile')->store('files');
		$file->save();

        return redirect()->intended('files');
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
        $city = city::find($id);
        // Redirect to city list if updating city wasn't existed
        if ($city == null || count($city) == 0) {
            return redirect()->intended('/system-management/city');
        }

        //$states = State::all();
        return view('system-mgmt/city/edit', ['city' => $city]);
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
        $city = City::findOrFail($id);
         $this->validate($request, [
        'name' => 'required|max:60'
        ]);
        $input = [
            'name' => $request['name']
            
        ];
        City::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "You are in delete methods".$id;
		
       /* Files::where('id', $id)->delete();
        return redirect()->intended('files');*/
    }

    /**
     * Search city from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'employee_id' => $request['employee']
            ];
		$employees=Employee::all();
       $files = $this->doSearchingQuery($constraints);
		//print_r($files);
      return view('employees-mgmt/files/index', ['files' => $files, 'employs' => $employees]);
    }

    private function doSearchingQuery($constraints) {
        $query = Files::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], '=', $constraint);
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'name' => 'required|max:255',
		'userfile' => 'required|mimes:pdf,doc,docx|max:1000'
    ]);
    }
}
