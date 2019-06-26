@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{url()->previous()}}" class="pull-left">
                            <button class="btn btn-sm btn-default btn-raised">Back</button></a>
                        <h3 class="text-center">Goods Received Vouchers Items</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>GRV ID: {{$details->GrvID}}</h5>
                                <h5>GRV NO: {{$details->GrvNumber}}</h5>
                                <h5>GRV Description: {{$details->Description}}</h5>
                                <h5>GRV Account Name: {{$details->cAccountName}}</h5>
                            </div>
                            <div class="col-md-6">
                                    <h5>GRV Order No: {{$details->OrderNum}}</h5>
                                    <h5>GRV Invoice Date: {{\Carbon\Carbon::parse($details->InvDate)->format('d-m-y')}}</h5>
                                    <h5>GRV Order Date: {{\Carbon\Carbon::parse($details->OrderDate)->format('d-m-y')}}</h5>
                                    <h5>GRV Delivery Date: {{\Carbon\Carbon::parse($details->DeliveryDate)->format('d-m-y')}}</h5>
                            </div>
                        </div>
                        <hr />
                        <div class="col-md-12">
                            <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable">
                                <thead>
                                <tr>
                                    <th>NO :</th>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th>Ordered Qty</th>
                                    <th>To be RCVD Qty</th>
                                    <th>RCVD Qty</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($grvItems as $item)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{$item->code}}</td>
                                        <td class="text-center">{{$item->description}}</td>
                                        <td class="text-center">{{$item->fQuantity}}</td>
                                        <td class="text-center">{{$item->qty_remaining}}</td>
                                        <td class="text-center">{{$item->qty_serialized}}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
