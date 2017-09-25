@extends('employees-mgmt.files.base')
@section('action-content')
<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-4">
                    <h3 class="box-title">User Files</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="{{ route('files.create') }}">Add new file</a>
                </div>

            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <form method="POST" action="{{ route('files.search') }}">
                {{ csrf_field() }}
                @component('layouts.search', ['title' => 'Search'])

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
            </form>
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                @isset($employee)
                                @foreach ($employee as $employee)
                                <tr role="row">
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="PNO: activate to sort column ascending">Employee No.</th>
                                    <td>@isset($employee->PNO ){{ $employee->PNO }}@endisset</td>
                                </tr>
                                <tr role="row">
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Employee Name</th>
                                    <td>@isset($employee->firstname ){{ $employee->firstname }} {{ $employee->lastname }}@endisset</td>
                                </tr>


                                @endforeach
                                @endisset
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"></div>
                        </div>
                    </div>
                </div>
                <!-- Time Log -->
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <tr role="row">
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">File Name</th>
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="File: activate to sort column ascending">File</th>
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Uploaded: activate to sort column ascending">Uploaded on</th>
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="comments: activate to sort column ascending">Comments</th>
                                    <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>

                                </tr>
                                @isset($files)
                                @foreach ($files as $file)

                                <tr role="row">

                                    <td>@isset($file->name ){{ $file->name }}@endisset</td>
                                    <td>@isset($file->path )<a href={{ env('APP_URL').'/storage/app/'.$file->path }}> Download </a>@endisset</td>
                                    <td>@isset($file->created_at ){{ $file->created_at }}@endisset</td>
                                    <td>@isset($file->comments ){{ $file->comments }}@endisset</td>
                                    <td>

                                        <form class="row" method="POST" action="{{ route('files.destroy', ['id' => $file->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <button type="submit" class="btn btn-danger col-sm-5 col-xs-5 btn-margin">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                @endforeach
                                @endisset
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">@isset($files) Showing 1 to {{count($files)}} of {{count($files)}} entries @endisset</div>
                        </div>
                        <div class="col-sm-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">

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