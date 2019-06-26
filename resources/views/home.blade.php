@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading mainThemeColor colorwhite">Select GRV</div>

                <div class="panel-body">
                            <form role="form" method="post" action="{{ url('/receive') }}">
                                    {{ csrf_field() }}
                                <div class="form-group label-floating">
                                    <label for="project_id" class="control-label">GRV</label>
                                    <select style="width: 100%" class="form-control checkin inputs" id="checkin" name="check" required>
                                        @foreach(\App\Grv::where('status','!=',\App\Grv::SERIALIZED_GRV)->get() as $grv)
                                            <option onclick="reciveGrv()"  value="{{$grv->autoindex_id}}" >{{$grv->GrvNumber}}</option>
                                        @endforeach
                                    </select>
                                    {{--<span class="help-block">Receive.</span>--}}
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn pull-right btn btn-raised mainThemeColor btn-primary">
                                        Receive
                                    </button>
                                </div>
                            </form>

                {{--</div>--}}
                {{--<div class="panel-footer">--}}
                    {{--<div class="row">--}}
                    {{--<button style="margin-right: 15px" class="btn btn-sm pull-right btn-raised mainThemeColor colorwhite fa fa-check fl">Receive</button>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function reciveGrv() {
            console.log($('.checkin').val());
        }
        $(".checkin").select2();
    </script>
@endsection
