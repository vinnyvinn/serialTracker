@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <h3 align="center">Serialized Goods Received Vouchers</h3>
                    </div>
                    <div class="panel-body">
                        <table id="example" width="100%" class="table table-striped able-hover table-responsive display dataTable">
                            <thead>
                            <tr>
                                <th>NO :</th>
                                <th>ORDER NUMBER</th>
                                <th>Description</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grvlines as $grvline)
                                <tr class="<?php if($grvline->status == \App\Grv::UNSERIALIZED_GRV)
                                {
                                    echo 'notSerialized';
                                }

                                elseif($grvline->status == \App\Grv::PARTIALLY_SERIALIZED_GRV)
                                {
                                    echo 'partSerialized';
                                }
                                else{
                                    echo 'fullySerialized';
                                }
                                ?>">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$grvline->OrderNum}}</td>
                                    <td>{{ucwords($grvline->Description)}}</td>
                                    <td>{{ucwords($grvline->cAccountName)}}</td>
                                    <td>{{$grvline->status}}</td>
                                    <td>{{\Carbon\Carbon::parse($grvline->DeliveryDate)->format(\Serial\Helper::helper()->dateFormat())}}</td>
                                    <td >
                                        {{--<a href="{{route('grv.edit',['id'=>$grvline->autoindex_id])}}"><p class="pull-right btn btn-raised btn-success">Receive</p></a>--}}
                                        <a class="issuecolor linkstyle" href="{{url('show-unprocessed',['id'=>$grvline->autoindex_id])}}">
                                            <i class="fa fa-eye fa-lg"></i> View
                                        </a>
                                        @if($grvline->status != \App\Grv::SERIALIZED_GRV)
                                            <a class="viewcolor linkstyle" href="{{url('edit-unprocessed',['autoindex_id'=>$grvline->autoindex_id])}}">
                                                <i class="fa fa-check-square-o"></i> Receive Fully
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

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
