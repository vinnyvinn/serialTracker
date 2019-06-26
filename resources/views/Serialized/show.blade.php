@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <a href="{{url()->previous()}}" class="pull-left"><button class="btn btn-sm btn-default btn-raised">Back</button></a>
                        <h3 align="center">Serialized Goods Received Vouchers Items</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
{{--                                <h5>GRV ID: {{$details->first()->GrvID}}</h5>--}}
                                <h5>GRV NO: {{$details->first()->GrvNumber}}</h5>
                                <h5>GRV Description: {{ucwords($details->first()->Description)}}</h5>
                                <h5>GRV Account Name: {{ucwords($details->first()->cAccountName)}}</h5>
                            </div>
                            <div class="col-md-6">
                                @if($details->first()->OrderNum != 0)
                                <h5>GRV Order No: {{$details->first()->OrderNum}}</h5>
                                @endif
                                <h5>GRV Invoice Date: {{$details->first()->InvDate}}</h5>
                                <h5>GRV Order Date: {{\Carbon\Carbon::parse($details->first()->OrderDate)->format(\Serial\Helper::helper()->dateFormat())}}</h5>
                                <h5>GRV Delivery Date: {{\Carbon\Carbon::parse($details->first()->DeliveryDate)->format(\Serial\Helper::helper()->dateFormat())}}</h5>
                            </div>
                        </div>
                        <hr />
                        <div class="col-md-12">
                            <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable">
                                <thead>
                                <tr>
                                    <th>No :</th>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th class="text-right">Ordered Qty</th>
                                    <th class="text-right">To be RCVD Qty</th>
                                    <th class="text-right">RCVD Qty</th>
                                    {{--<th>Date RCVD</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($grvItems as $item)
                                    <tr class="{{$item['has_warranty'] == 'no'?'errorTd':''}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td class="globalmargin"> {{$item['code']}}</td>
                                        <td class="globalmargin">{{ucwords($item['description'])}}</td>
                                        <td class="text-right globalmargin">{{$item['fQuantity']}}</td>
                                        <td class="text-right globalmargin">{{$item['qty_remaining']}}</td>
                                        <td class="text-right globalmargin">{{$item['qty_serialized']}}</td>
{{--                                        <td>{{\Carbon\Carbon::parse($item['created_at'])->format(\Serial\Helper::helper()->dateFormat())}}</td>--}}
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
