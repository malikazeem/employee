<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Employee;
use App\City;
use App\Company;


class EmployeeManagementController extends Controller
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
        $employees = DB::table('employees')
        ->leftJoin('city', 'employees.city_id', '=', 'city.id')
        ->leftJoin('company', 'employees.company_id', '=', 'company.id')
        ->select('employees.*', 'company.name as company_name', 'company.id as company_id', 'city.name as city_name', 'city.id as city_id')
        ->paginate(5);

        return view('employees-mgmt/index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        
       $companies = Company::all();
        
        return view('employees-mgmt/create', ['cities' => $cities], ['companies' => $companies]);
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
        // Upload image
        $path = $request->file('picture')->store('avatars');
        $keys = ['PNO', 'firstname','lastname', 'email', 'phone','percent','address', 'city_id', 'company_id', 'zip',
        'comments', 'date_hired'];
        $input = $this->createQueryInput($keys, $request);
        $input['picture'] = $path;
        // Not implement yet
        //$input['company_id'] = 0;
        Employee::create($input);
		

        return redirect()->intended('/employee-management');
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
        $employee = Employee::find($id);
        // Redirect to state list if updating state wasn't existed
        if ($employee == null || count($employee) == 0) {
            return redirect()->intended('/employee-management');
        }
        $cities = City::all();
        $companies = Company::all();
       
        return view('employees-mgmt/edit', ['employee' => $employee, 'cities' => $cities, 'companies' => $companies]);
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
        $employee = Employee::findOrFail($id);
        $this->validate($request, [
			'PNO' => 'required|max:60',
            'lastname' => 'required|max:60',
            'firstname' => 'required|max:60',
            'email' => 'required|max:255|email',
			'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'percent' => 'required',
           'picture' => 'mimes:jpeg,jpg,png | max:1000',
            'zip' => 'required|numeric',
           
            'date_hired' => 'required'
           
        ]);
        // Upload image
        $keys = ['PNO', 'firstname','lastname', 'email', 'phone','percent','address', 'city_id', 'company_id', 'zip',
        'comments', 'date_hired'];
        $input = $this->createQueryInput($keys, $request);
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('avatars');
            $input['picture'] = $path;
        }

        Employee::where('id', $id)
            ->update($input);

        return redirect()->intended('/employee-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Employee::where('id', $id)->delete();
         return redirect()->intended('/employee-management');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'firstname' => $request['firstname'],
            'company.name' => $request['company_name']
            ];
        $employees = $this->doSearchingQuery($constraints);
        $constraints['company_name'] = $request['company_name'];
        return view('employees-mgmt/index', ['employees' => $employees, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('employees')
		->leftJoin('city', 'employees.city_id', '=', 'city.id')
        ->leftJoin('company', 'employees.company_id', '=', 'company.id')
        ->select('employees.firstname as employee_name', 'employees.*','company.name as company_name', 'company.id as company_id','city.name as city_name', 'city.id as city_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint!= null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

     /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function load($name) {
         $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    private function validateInput($request) {
        $this->validate($request, [
			'PNO' => 'required|max:60|unique:employees',
            'lastname' => 'required|max:60',
            'firstname' => 'required|max:60',
            'email' => 'required|max:255|email',
			'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'percent' => 'required',
			'picture' => 'mimes:jpeg,jpg,png | max:1000',
            'zip' => 'required|numeric',
           
            'date_hired' => 'required'
           
        ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }
}
