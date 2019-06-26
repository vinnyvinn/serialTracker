@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <h3 align="center">Issue Goods</h3>
                    </div>
                    <div class="panel-body">
                        <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable alignVertical">
                            <thead>
                            <tr>
                                <th>NO :</th>
                                <th>INV NUMBER</th>
                                <th>Description</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice as $inv)
                                <tr class="
                                <?php if($inv->status == \App\Issue::NOT_ISSUED)
                                {
                                    echo 'notSerialized';
                                }

                                elseif($inv->status == \App\Issue::PARTIALLY_ISSUED ||
                                        $inv->status == \App\Issue::PARTIALLY_DELIVERED)
                                {
                                    echo 'partSerialized';
                                }
                                elseif($inv->status == \App\Issue::DELIVERED ||
                                        $inv->status == \App\Issue::FULLY_ISSUED ){
                                    echo 'fullySerialized';
                                }
                                ?>">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$inv->InvNumber}}</td>
                                    <td>{{ucwords($inv->Description)}}</td>
                                    <td>{{ucwords($inv->clientAccount)}}</td>
                                    <td>{{$inv->status}}</td>
                                    <td>{{\Carbon\Carbon::parse($inv->DeliveryDate)->format(\Serial\Helper::helper()->dateFormat())}}</td>
                                    <td >
                                        <a class="issuecolor linkstyle" href="{{route('issue.edit',['id'=>$inv->autoindex_id])}}">
                                          <i class="fa fa-eye fa-lg "></i> View
                                        </a>
                                        {{--<a class="issuecolor linkstyle" href="{{route('issue.show',['id'=>$inv->autoindex_id])}}">--}}
                                            {{--<i class="fa fa-eye fa-lg"></i> View--}}
                                        {{--</a>--}}
                                    </td>

                                </tr>
                            @endforeach
                            <tfoot>
                            <tr>
                                <th>NO :</th>
                                <th>INV NUMBER</th>
                                <th>Description</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </tfoot>
                        </table>
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
