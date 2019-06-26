@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <a href="{{route('warrantysetup.create')}}" class="btn btn-sm btn-default btn-raised pull-right">
                            Set warranty
                        </a>
                        {{--<a href="{{url()->previous()}}" class="pull-left">--}}
                            {{--<button class="btn btn-sm btn-default btn-raised">Back</button>--}}
                        {{--</a>--}}
                        <h3 align="center">Setting</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('setting.store')}}" method="post">
                            {{ csrf_field() }}
                        <table width="100%" class="table table-striped table-hover table-responsive display dataTable ">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr>
                                    <td>{{$setting->title}}</td>
                                    <td>{{$setting->description}}</td>
                                    <td >
                                        @if($setting->setting_id == 3)
                                                <select style="width: 100%" class="form-control warrant inputs" id="warrant" name="{{$setting->title}}" required>
                                                        <option value="1" >Consolidated</option>
                                                        <option value="2" >Detailed</option>
                                                </select>
                                            @elseif($setting->setting_id == 6)
                                            <select style="width: 100%" class="form-control validate inputs" id="validate" name="validate" required>
                                                <option value="1" >Validation per serial</option>
                                                <option value="2" >Bulk validation</option>
                                            </select>
                                        @elseif($setting->default_value == 771)
                                            <input name="{{$setting->title}}" required type="text" class="form-control" value="D/N">

                                         @elseif($setting->title == 'Tracking linked to')
                                                 <span class="radio-inline1">
                                                <input type="radio" name="grv_po" value="1" {{ $setting->default_value ==1 ? 'checked' : '' }}>PO
                                            </span>
                                            <span class="radio-inline2">
                                                <input type="radio" name="grv_po" value="2" {{ $setting->default_value ==2 ? 'checked' : '' }}>GRV
                                            </span>

                                        @elseif($setting->title == 'Strict Serial Tracking')
                                                <span class="radio-inline1">
                                                <input type="radio" name="strict_tracking" value="2" {{ $setting->default_value ==2 ? 'checked' : '' }}>YES
                                            </span>
                                            <span class="radio-inline2">
                                                <input type="radio" name="strict_tracking" value="1" {{ $setting->default_value ==1 ? 'checked' : '' }}>NO
                                            </span>

                                        @elseif($setting->title == 'Serial Tracking Method')
                                                <span class="radio-inline1">
                                                <input type="radio" name="tracking_method" value="1" {{ $setting->default_value ==1 ? 'checked' : '' }}>FIFO
                                            </span>
                                            <span class="radio-inline2">
                                                <input type="radio" name="tracking_method" value="2" {{ $setting->default_value ==2 ? 'checked' : '' }}>LIFO
                                            </span>
                                                                                        @else
                                            <input name="{{$setting->title}}" required type="{{$setting->title == 'Delivery note Type'
                                            || $setting->title == 'Delivery note Number Prefix' ? 'text' : 'number'}}" class="form-control"
                                             max="{{$setting->title == 'Number of Serials' || $setting->title == 'Serials' ? 4 : 10}}"
                                              min="{{$setting->title == 'Number of Serials' || $setting->title == 'Primary Serial Column' ? 1: 1}}"
                                                   value="{{$setting->default_value}}">
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </table>
                            <hr />
                               <button type="submit" class="btn btn-sm pull-right btn-raised btn-primary">Accept default</button>
                               <button type="submit" class="btn btn-sm pull-right btn-raised btn-success">Save</button>
                                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(".warrant").select2();
    </script>
@endsection
