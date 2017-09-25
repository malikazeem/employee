@extends('system-mgmt.project.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Project Detail</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('project.update', ['id' => $project->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Project Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $project->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         	     <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Project Detail</label>

                            <div class="col-md-6">
							<textarea class="form-control" rows="5" name="detail" required>{{ $project->detail }}</textarea>
                                
                                @if ($errors->has('detail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('detail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Company</label>
                            <div class="col-md-6">
                                <select class="form-control" name="company_id">
                                    @foreach ($companies as $company)
									
									@if ($company->id == $project->company_id)
                                        <option value="{{$company->id}}" selected>{{$company->name}}</option>
									
									@endif
									<option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
