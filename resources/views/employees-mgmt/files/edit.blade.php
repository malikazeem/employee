@extends('employees-mgmt.files.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update file</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('files.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
						<div class="form-group">
							<label class="col-md-4 control-label">Employee</label>
								<div class="col-md-6">
									<select class="form-control" name="employee">
                                    @foreach ($employs as $emp)
                                        <option value="{{$emp->id}}" >{{ $emp->firstname.' '.$emp->lastname}}</option>
											
                                    @endforeach
									</select>
								</div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">File Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                       <div class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                            <label for="comments" class="col-md-4 control-label">Comments</label>

                            <div class="col-md-6">
                                <textarea id="comments" rows="5" class="form-control" name="comments" value="{{ old('comments') }}" required></textarea>

                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comments') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >File</label>
                            <div class="col-md-6">
                                <input type="file" id="userfile" name="userfile">
								@if ($errors->has('path'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('path') }}</strong>
                                    </span>
                                @endif
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
