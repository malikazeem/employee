<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;

class CompanyController extends Controller
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
        $companies = Company::paginate(5);

        return view('system-mgmt/company/index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/company/create');
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
		$company = new Company;
		$company->orgno = $request->orgno;
        $company->name = $request->name;
		$company->contact = $request->contact;
		$company->phone = $request->phone;
		$company->email = $request->email;
		$company->save();
       
        return redirect()->intended('system-management/company');
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
        $company = Company::find($id);
        // Redirect to company list if updating company wasn't existed
        if ($company == null || count($company) == 0) {
            return redirect()->intended('/system-management/company');
        }

        return view('system-mgmt/company/edit', ['company' => $company]);
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
        $company = Company::findOrFail($id);
        //$this->validateInput($request);
		$this->validate($request, [
        'orgno' => 'required|max:255',
		'name' => 'required|max:255',
		'contact' => 'required|max:255',
		'phone' => 'required|max:255',
		'email' => 'required|max:255|email'
    ]);
        $input = [
			'orgno' => $request['orgno'],
            'name' => $request['name'],
			'contact' => $request['contact'],
			'phone' => $request['phone'],
			'email' => $request['email']
        ];
        Company::where('id', $id)
            ->update($input);
        
        return redirect()->intended('system-management/company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::where('id', $id)->delete();
         return redirect()->intended('system-management/company');
    }

    /**
     * Search company from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $companies = $this->doSearchingQuery($constraints);
       return view('system-mgmt/company/index', ['companies' => $companies, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = company::query();
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
    private function validateInput($request) {
        $this->validate($request, [
        'orgno' => 'required|max:255|unique:company',
		'name' => 'required|max:255|unique:company',
		'contact' => 'required|max:255',
		'phone' => 'required|max:255',
		'email' => 'required|max:255|email'
    ]);
    }
}
