@extends('system-mgmt.report.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">Work History</h3>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
				<input type="hidden" value="{{$searchingVals['employee']}}" name="employee" />
                <!--button type="submit" class="btn btn-primary">
                  Export to Excel
                </button-->
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
				<input type="hidden" value="{{$searchingVals['employee']}}" name="employee" />
                <!--button type="submit" class="btn btn-info">
                  Export to PDF
                </button-->
            </form>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="GET" action="{{ route('report.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
          @endcomponent
		  
		 <div class="row">
		 <div class="col-md-6">
			<div class="form-group">
             <label class="col-md-3 control-label">Employee</label>
                <div class="col-md-7">
                    <select class="form-control" name="employee">
                                    @foreach ($employs as $emp)
                                        <option value="{{$emp->id}}" >{{ $emp->firstname.' '.$emp->lastname}}</option>
											
                                    @endforeach
                                </select>
                            </div>
                        </div>
						</div>
						</div>
						@endcomponent
      
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
		  @foreach ($employee as $employee)
             <tr role="row">
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="PNO: activate to sort column ascending">Employee No.</th>
				<td>@isset($employee->PNO ){{ $employee->PNO }}@endisset</td>
                </tr>
			 <tr role="row">
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Employee Name</th>
				<td>@isset($employee->firstname ){{ $employee->firstname }} {{ $employee->lastname }}@endisset</td>
			 </tr>
			 <tr role="row">
			   <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending">Company</th>
                <td>@isset($employee->company_name ){{ $employee->company_name }}@endisset</td>
				</tr>
			 <tr role="row">
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="City: activate to sort column ascending">City</th>
                <td>@isset($employee->city_name ){{ $employee->city_name }}@endisset</td>
			</tr>
			 <tr role="row">	
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Hired Day</th>
               <td>@isset($employee->date_hired ){{ $employee->date_hired }}@endisset</td>
                
             </tr>
			<tr role="row">	
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Percentage</th>
               <td>@isset($employee->percent ){{ $employee->percent }}@endisset</td>
                
             </tr>
           <tr role="row">	
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Comments</th>
               <td>@isset($employee->comments ){{ $employee->comments }}@endisset</td>
                
             </tr>
            @endforeach
            
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($employee)}} of {{count($employee)}} entries</div>
        </div>
      </div>
    </div>
	<!-- Time Log -->
	    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
		  <tr role="row">
                <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Work Date</th>
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending">Hours</th>
				<th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Comments: activate to sort column ascending">Comments</th>
			
			</tr>
		  @foreach ($logs as $log)
             
			 <tr role="row">
			   
                <td>@isset($log->workdate ){{ $log->workdate }}@endisset</td>
				<td>@isset($log->hours ){{ $log->hours }}@endisset</td>
				<td>@isset($log->comments ){{ $log->comments }}@endisset</td>
				</tr>
			 
            @endforeach
            
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($logs)}} of {{$logs->total()}} entries</div>
        </div>
		<div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $logs->appends(Request::except('page'))->links() }}
          </div>
        </div>
      </div>
    </div>
	</form>
	<!--end time log-->
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection