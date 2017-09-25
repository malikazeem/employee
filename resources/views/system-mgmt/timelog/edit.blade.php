@extends('system-mgmt.timelog.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Timelog Detail</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('timelog.update', ['id' => $timelog->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <div class="form-group">
                            <label class="col-md-4 control-label">Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{{ $timelog->workdate }}" name="hiredDate" class="form-control pull-right" id="hiredDate" required>
                                </div>
                            </div>
                        </div>
						     <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
                            <label for="hours" class="col-md-4 control-label">Hours</label>

                            <div class="col-md-6">
							<input type="text" value="{{ $timelog->hours }}" name="hours" class="form-control pull-right" id="hours" required>
                                
                                @if ($errors->has('hours'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hours') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          <div class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                            <label for="comments" class="col-md-4 control-label">Comments</label>

                            <div class="col-md-6">
                                <textarea id="comments" rows="5" class="form-control" name="comments" value="{{ $timelog->comments }}" ></textarea>

                                @if ($errors->has('comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comments') }}</strong>
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
