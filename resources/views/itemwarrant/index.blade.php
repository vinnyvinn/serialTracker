@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <div>
                            {{--<button type="button" onclick="checkModalResultTable()" class="pull-right btn btn-sm btn-default btn-raised" data-toggle="modal" data-target="#searchSerial">--}}
                                 {{--View Warranties--}}
                            {{--</button>--}}
                            <a href="{{url('warrantysetup')}}" class="btn btn-sm btn-default btn-raised pull-right">View warranties</a>
                            <h3 class="text-center">Serials Warranties</h3>

                        </div>

                    </div>
                    <div class="panel-body">
{{--                            {{ csrf_field() }}--}}
                            <table id="example" width="100%" class="table table-striped table-hover table-responsive display dataTable alignVertical">
                                <thead>{{--                                    {{dd($det   ail)}}--}}
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Issued by</th>
                                    <th>Serial</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($warranties as $warranty)
                                    <tr data-toggle="modal" onclick="showDetails({{json_encode($warranty)}})" data-target="#myModal">
                                        <td>{{$warranty['code']}}</td>
                                        <td>{{ucwords($warranty['description'])}}</td>
                                        <td>{{ucwords($warranty['user'])}}</td>
                                        <td>{{$warranty['serial']}}</td>
                                        <td >
                                            {{--<button type="button" class="btn btn-primary btn-lg"  >--}}
                                                {{--Launch demo modal--}}
                                            {{--</button>--}}
                                            <i class="fa fa-eye fl" ></i>view
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Issued by</th>
                                    <th>Serial</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                            <hr />

                            {{--<button type="submit" class="pull-right btn btn-raised btn-success">Save</button>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- warranty -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mainThemeColor colorwhite">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Serial details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h4 id="desc" class="text-center"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-raised btn-primary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="searchSerial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="col-md-8" style="float: none; margin: 0 auto; margin-top: 110px" role="document">
            <div class="modal-content">
                <div class="modal-header btn-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Enter Serial</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h4 id="itemDesc"></h4>
                        </div>

                        <div class="col-md-6">
                            <h4 id="itemCode"></h4>
                        </div>
                    </div>
                </div>

                <div class="modal-body">


                    {{--{{ method_field('PUT') }}--}}

                        <div class="col-md-12">
                            <form id="allinputs" method="POST">
                                {{ csrf_field() }}
                            <div class="input-group">
                                <input required class="form-control" id="search" type="text" value="">
                                <span class="input-group-btn"><button class="btn btn-sm btn-primary btn-raised">
                                        <i class="fa fa-search fa-lg"></i> Search</button>
                    </form>
                    <button style="margin-left: 3px" id="dismiss" class="btn btn-danger btn-sm btn-raised" data-dismiss="modal">
                        <i class="fa fa-close fa-lg"></i> Close</button>
</span>
                            </div>
                        </div>

                    <table id="searchbody" width="100%" class="table table-striped table-hover table-responsive display dataTable alignVertical">

                    </table>

                    <hr />
                    <input type='hidden' id='wholeData' name='wholeData'/>
                    <div class="modal-footer">
                        {{--<button type="submit" class="btn btn-warning btn-raised">Close</button>--}}
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

        function showDetails(data) {
            if($('#desc table'))
            {
                $('#desc table').remove();
            }
            data = '<table class="table"><thead>' +
                    '<tr>' +
                    '<td class="text-capitalize" colspan="2">Description : ' + data.description +'</td>' +
                    '<td colspan="2">Serial : ' + data.serial+'</td>' +
                    '</tr><tr>' +
                    '<th>Warranty</th>' +
                    '<th>Status</th>' +
                    '<th>Start Date</th>' +
                    '<th>End Date</th>' +
                    '</tr></thead><tbody>' +
                    '<tr class="text-left"><td>Labour</td><td>'+data.labour_status+'</td><td>'+data.labour_start_date+'</td><td>'+data.labour_end_date+'</td></tr>' +
                    '<tr class="text-left"><td>Service</td><td>'+data.service_status+'</td><td>'+data.service_start_date+'</td><td>'+data.service_end_date+'</td></tr>' +
                    '<tr class="text-left"><td>Parts</td><td>'+data.parts_status+'</td><td>'+data.parts_start_date+'</td><td>'+data.parts_end_date+'</td></tr>' +
                    '</tbody>';
            $('#desc').append(data);
        }

        function checkModalResultTable() {
            if($('#searchbody thead').hasClass('result'))
            {
                $('#searchbody thead').remove();
                $('#searchbody tbody').remove();
            }
        }

        $('#allinputs').on('submit', function (e) {
            e.preventDefault();
            if($('#searchbody thead').hasClass('result'))
            {
                $('#searchbody thead').remove();
                $('#searchbody tbody').remove();
            }
             var formData = {};
                    formData['serial'] = $('#search').val();

                    $.ajax({
                        url: '{{ route('warranties.store') }}',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            if (response == 'Serial not found') {
                                errorMessage(response);
                            }
                       else {
                                head = '<thead class="result"><tr><th>Warranty</th>' +
                                        '<th>Code</th>' +
                                        '<th>Description</th>' +
                                        '<th>Serial</th>' +
                                        '<th>Status</th>' +
                                        '<th>Duration</th>' +
                                        '<th>Start Date</th>' +
                                        '<th>End Date</th></tr></thead>';
                                $('#searchbody').append(head);
                                $.each(response, function (index, value) {
                                    var duration = '';
                                    var desc = '';
                                    var start = '';
                                    var end = '';
                                    var serial = '';
                                    var status = '';
                                    var code = '';
                                    $.each(value, function (index_val, value_val) {
                                        duration = value_val.duration;
                                        code = value_val.code;
                                        start = value_val.starts;
                                        end = value_val.end_date;
                                        serial = value_val.serial;
                                        status = value_val.warrant_status;
                                        desc = value_val.Description;
                                    });
                                    console.log(desc);
                                    data = '<tbody class="result"><tr>' +
                                            '<td>' + index + '</td>' +
                                            '<td>' + code + '</td>' +
                                            '<td>' + desc + '</td>' +
                                            '<td>' + serial + '</td>' +
                                            '<td>' + status + '</td>' +
                                            '<td>' + duration + '</td>' +
                                            '<td>' + start + '</td>' +
                                            '<td>' + end + '</td></tr></tbody>'
                                    ;
                                    $('#searchbody').append(data);
                                });
                            }
//                            else if (response == 'Invalid' || response == 'Issued' || response == 'Item code does not match serial code') {
//                                errorMessaage(response + ' serial');
//                            }
                        },
                        error: function (response) {
//                        console.log(response);
                        }
                    });
        });

        function errorMessage(msg) {
            sflash({
                title: "Error",
                text: msg,
                type: "error",
                allowOutsideClick: true,
                confirmButtonText: "Got it",
                showConfirmButton: true
            });
        }
    </script>
@endsection