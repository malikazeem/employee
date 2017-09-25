@extends('system-mgmt.timelog.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of Time log enteries</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('timelog.create') }}">Add new Time</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('timelog.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          <div class="form-group">
		  <div class="col-sm-6">
                            <label class="col-md-2 control-label">Work Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ old('workdate') }}" name="hiredDate" class="form-control pull-right" id="hiredDate">
                                </div>
                            </div>
                        </div>
						</div>
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Employee</th>
				<th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Emp. No.</th>
                <th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Work Date</th>
				<th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Hours</th>
				
				<th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Registered</th>
				<th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Percentage</th>
				<th  class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="project: activate to sort column ascending">Comments</th>
				<th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
            
            @foreach ($hours as $hour)
                <tr role="row" class="odd">
                  <td>{{ $hour->firstname.' '.$hour->lastname }}</td>
				  <td>{{ $hour->PNO }}</td>
				  <td>{{ $hour->workdate }}</td>
				  <td>{{ $hour->hours}}</td>
				  
				  <td>{{ $hour->date_hired }}</td>
				  <td>{{ $hour->percent }}</td>
				  <td>{{ $hour->log_comments }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('timelog.destroy', ['id' => $hour->id]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('timelog.edit', ['id' => $hour->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                        Update
                        </a>
                        <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                          Delete
                        </button>
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
            
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($hours)}} of {{count($hours)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $hours->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection