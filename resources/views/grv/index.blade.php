@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <h3 class="text-center">Goods Received Vouchers</h3>

                    </div>
                    <div class="panel-body">
                        <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable">
                            <thead>
                            <tr>
                                <th>NO :</th>
                                <th>GRV NUMBER</th>
                                <th>Description</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($grvs as $grv)
                                     <tr class="<?php if($grv->status == \App\Grv::UNSERIALIZED_GRV)
                                            {
                                                echo 'notSerialized';
                                            }

                                    elseif($grv->status == \App\Grv::PARTIALLY_SERIALIZED_GRV)
                                        {
                                            echo 'partSerialized';
                                        }
                                        else{
                                            echo 'fullySerialized';
                                        }
                                    ?>">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$grv->GrvNumber}}</td>
                                    <td>{{$grv->Description}}</td>
                                    <td>{{$grv->cAccountName}}</td>
                                    <td>{{$grv->status}}</td>
                                    <td>{{\Carbon\Carbon::parse($grv->DeliveryDate)->format(\Serial\Helper::helper()->dateFormat())}}</td>
                                    <td>
{{--                                        @if($grv->status != \App\Grv::SERIALIZED_GRV)--}}
                                            <a class="issuecolor linkstyle" href="{{route('grv.edit',['id'=>$grv->autoindex_id])}}">
                                                <i class="fa fa-eye fa-lg "></i> View
                                            </a>
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

@endsection
