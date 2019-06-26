@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{url()->previous()}}" class="pull-left">
                            <button class="btn btn-sm btn-default btn-raised">Back</button>
                        </a>
                        <h3 align="center">Sale Order Invoices</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>GRV ID: {{$details->sagegrv_id}}</h5>
                                <h5>INV NO: {{$details->InvNumber}}</h5>
                                <h5>INV Description: {{$details->Description}}</h5>

                            </div>
                            <div class="col-md-6">
                                <h5>Client Name: {{$details->clientAccount}}</h5>
                                <h5>Status: {{$details->status}}</h5>
                                <h5>Date: {{$details->created_at}}</h5>
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
                                    <th>Remaining Qty</th>
                                    <th>Delivered Qty</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($inlines as $inline)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$inline->code}}</td>
                                        <td>{{$inline->cDescription}}</td>
                                        <td>{{$inline->issued_amount + $inline->remaining_amount}}</td>
                                        <td>{{$inline->remaining_amount}}</td>
                                        <td>{{$inline->issued_amount}}</td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                <tr>
                                    <th>NO :</th>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th>Ordered Qty</th>
                                    <th>Remaining Qty</th>
                                    <th>Delivered Qty</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection