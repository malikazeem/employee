<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Excel;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class ReportController extends Controller
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

    public function index() {
        date_default_timezone_set('Europe/Stockholm');
        $format = 'Y/m/d';
        $now = date($format);
        $to = date($format, strtotime("+30 days"));
		$employs= Employee::all();
        $constraints = [
            'from' => $now,
            'to' => $to,
			'employee'=>1
        ];

        $employee = $this->getHiredEmployees($constraints);
		$logs	=	$this->getTimelog($constraints);
        return view('system-mgmt/report/index', ['employee' => $employee, 'logs' => $logs,'employs' => $employs,'searchingVals' => $constraints]);
    }

    public function exportExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report');
    }

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $employees = $this->getExportingData($constraints);
        $pdf = PDF::loadView('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
    }
    
    private function prepareExportingData($request) {
        $author = Auth::user()->username;
        $employees = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], function($excel) use($employees, $request, $author) {

        // Set the title
        $excel->setTitle('List of hired employees from '. $request['from'].' to '. $request['to']);

        // Chain the setters
        $excel->setCreator($author)
            ->setCompany('First TO Know');

        // Call them separately
        $excel->setDescription('The list of hired employees');

        $excel->sheet('Hired_Employees', function($sheet) use($employees) {

        $sheet->fromArray($employees);
            });
        });
    }

    public function search(Request $request) {
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to'],
			'employee' => $request['employee']
        ];
		$employs= Employee::all();
        $employee = $this->getHiredEmployees($constraints);
		$logs	=	$this->getTimelog($constraints);
		//$logs->appends([$constraints])->render();
        return view('system-mgmt/report/index', ['employee' => $employee,'logs' => $logs,'employs' => $employs,'searchingVals' => $constraints]);
    }

    private function getHiredEmployees($constraints) {
        $employees = DB::table('employees')
					->leftJoin('city', 'employees.city_id', '=', 'city.id')
					->leftJoin('company', 'employees.company_id', '=', 'company.id')
					
					->select('employees.*','company.name as company_name', 'company.id as company_id','city.name as city_name', 'city.id as city_id')
						
						->where('employees.id','=', $constraints['employee'])
						
                        ->get();
						
        return $employees;
    }
	
	private function getTimelog($constraints) {
        $timelog = DB::table('time_log')
					
					->select('time_log.*')
					
						->where('workdate', '>=', $constraints['from'])
                        ->where('workdate', '<=', $constraints['to'])
						->where('time_log.employee_id','=', $constraints['employee']);
						
                       // ->get();
						
						
        return $timelog->paginate(5);
    }
	
    private function getExportingData($constraints) {
        return DB::table('employees')
        ->leftJoin('city', 'employees.city_id', '=', 'city.id')
        ->leftJoin('company', 'employees.company_id', '=', 'company.id')
        ->select('employees.firstname as First Name', 'employees.middlename as Middle Name', 'employees.lastname as Last Name', 
        'employees.PNO','city.name as City', 'employees.zip as Zip', 'employees.date_hired as Hired Date',
        'company.name as Company Name')
        ->where('date_hired', '>=', $constraints['from'])
        ->where('date_hired', '<=', $constraints['to'])
        ->get()
        ->map(function ($item, $key) {
        return (array) $item;
        })
        ->all();
    }
}
