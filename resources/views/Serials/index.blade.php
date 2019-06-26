@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <h3 align="center">Serials</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('setting.store')}}" method="post">
                            {{ csrf_field() }}
                            <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable alignVertical">
                                <thead>
                                     <tr>
                                    <th>NO :</th>
                                    <th>Code</th>
                                    <th>Inv NO</th>
                                    <th>Order NO</th>
                                    <th>Description</th>
                                    <th>Serial</th>
                                    <th>Status</th>
                                     </tr>
                                </thead>
                                <tbody>
                                @foreach($serials as $serial)
                                    <tr class="{{$serial->status == \App\Sageitemsserial::INVALID_SERIAL ? 'erroTd':''}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$serial->code}}</td>
                                        <th>{{\App\Grv::where('id',$serial->grv_id)->first()->InvNumber}}</th>
                                        <th>{{\App\Grv::where('id',$serial->grv_id)->first()->OrderNum}}</th>
                                        <td>{{ucwords($serial->cDescription)}}</td>
                                        <td>{{$serial->$serialcoln}}</td>
                                       <td>{{$serial->status}}</td>
                                    </tr>
                                @endforeach

                            </table>
                            <hr />

                            {{--<button type="submit" class="pull-right btn btn-raised btn-success">Save</button>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
