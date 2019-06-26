@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="panel panel-info">
                        <div class="panel-heading mainThemeColor">

                            <div class="row">
                                <a href="{{route('issue.index')}}" class="col-sm-2">
                                    <button class="btn-sm btn btn-default btn-raised">Back</button></a>
                                <h3 class="text-center col-sm-6">Issue Goods</h3>
                                <form class="col-sm-4" role="form" method="post" action="{{ url('/receive-item') }}">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <select style="width: 100%;" class="form-control items" id="select" name="check" required>
                                            @foreach($items as $item)
                                                <option  value="{{$item->autoindex_id}}" >{{$item->InvNumber}}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                    <button class="btn btn-default btn-raised btn-sm" type="submit">DETAILS</button>
                                 </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    <h5 >INV NO: {{$details->InvNumber}}</h5>
                                    <h5 >Description: {{ucwords($details->Description)}}</h5>

                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-right">Client Name: {{ucwords($details->clientAccount)}}</h5>
                                    <h5 class="text-right">Status: {{$details->status}}</h5>
                                    <h5 class="text-right">Date: {{$details->created_at}}</h5>
                                </div>
                            </div>
                            <hr />
                            <div class="col-md-12">
                                <table id="example" class="table table-striped table-hover table-responsive">
                                    <thead>
                                    <tr>
                                        <th>NO :</th>
                                        <th>Item Code</th>
                                        <th>Description</th>
                                        <th class="text-center">Ordered Qty</th>
                                        <th class="text-center">Issued Qty</th>
                                        <th class="text-right">Remaining Qty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inlines as $invline)
                                        <tr>

                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$invline->code}}</td>
                                            <td>{{ ucwords($invline->cDescription)}}</td>
                                            <td class="text-right globalmargin" id="total_{{$invline->idInvoiceLines}}">{{($invline->previous_amount == 0 ? $invline ->remaining_amount + $invline->issued_amount : $invline ->previous_amount + $invline->remaining_amount)}}</td>
                                            <td class="text-right globalmargin" id="qtyr_{{$invline->idInvoiceLines}}">{{\App\GrvSerialized::where('autoindex_id',$invline->autoindex_id)->first() ? \App\GrvSerialized::where('autoindex_id',$invline->autoindex_id)->first()->qty_serialized : 0}}</td>
                                            <td class="text-right globalmargin" id="qty_{{$invline->idInvoiceLines}}">{{$invline->remaining_amount}}</td>
                                            <td class="text-center">
                                                @if($invline->remaining_amount != 0)
                                                       <a href="#" id="{{$invline->idInvoiceLines}}" onclick="issueItem({{ $invline->remaining_amount}},{{($invline->previous_amount == 0 ? $invline ->remaining_amount + $invline->issued_amount : $invline ->previous_amount + $invline->remaining_amount)}},{{\App\GrvSerialized::where('autoindex_id',$invline->autoindex_id)->first() ? \App\GrvSerialized::where('autoindex_id',$invline->autoindex_id)->first()->qty_serialized : 0}},{{json_encode($invline)}})" data-toggle="modal" data-target="#serialModal">
                                                       Add
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
                <div class="col-md-5">
                    <div id="dnote1" class="panel panel-success">
                            <div class="panel-heading">
                            <h3 class="panel-title text-center">Delivery Note</h3>
                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <table style="width: 100%" >
                                        <thead>
                                        <tr>
                                            <th class="pull-left">
                                                <h4>INV NO: {{$details->InvNumber}}</h4>
                                            </th>
                                            <th >
                                                <h5 class="pull-right">Dnote No : {{$dnote}}</h5>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><h4 class="pull-left">Client Name: {{ucwords($details->clientAccount)}}</h4></th>
                                            <th ><h5 class="pull-right">Date: {{$details->created_at}}</h5></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover table-responsive modalTable" border="1" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>NO:</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Serials</th>

                                </tr>
                                </thead>
                                <tbody  class="modalReceiveNote">
                                <?php $numb = 1;?>
                                @foreach($inlines as $inline)
                                @if(($inline->status == \App\Issuelines::ISSUED || $inline->status == \App\Issuelines::PARTIALLY_DELIVERED))
                                    <input type="hidden" value="{{$inline->id}}" name="id" id="sendId">
                                    <tr>
                                        <td>{{$numb ++}}</td>
                                        <td>{{$inline->cDescription}}</td>
                                        <td>{{$inline->previous_amount}}</td>
                                        <td>
                                            <ul class="list-group">
                                                @foreach($inline->serials as $serial)
                                                    <li class="list-group-item">
                                                        {{$serial->serial_one}}
                                                    </li>
                                                    @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach

                                </tbody>

                            </table>
                        </div>
                        <div class="panel-footer" style="background-color: #ffffff">
                            <div class="row">
                            <div id="dnotefooter" class="col-md-12">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td>Received the above goods in good order and condition</td>
                                    </tr>
                                <tr>
                                    <td style="padding-left: 6px; padding-top: 20px;">Received by ...............................................................</td>
                                    <td class="text-right" style="padding-left: 6px; padding-top: 20px;">Sign ...........................</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 6px; padding-top: 20px">Date .................. Time ..................</td>
                                    <td rowspan="2">Co. Rubber Stamp</td>
                                </tr>
                                    <td style="padding-left: 6px; padding-top: 20px">Company Tel:</td>
                                <tr>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                                <div id="issuebutton" class="pull-right">
                                    <a class="btn btn-danger btn-sm btn-raised" href="{{route('issue.index')}}">
                                        <i class="fa fa-close fa-lg "></i>
                                        Close
                                    </a>
                                    {{--                                    <a href="{{url('issuednote',['autoindexid'=>])}}">--}}
                                    <button type="submit" onclick="printContent('dnote1','{{$details->autoindex_id}}')" class="btn btn-success btn-sm btn-raised">
                                        <i class="fa fa-check fa-lg "></i> Issue </button>
                                </div>
                            </div>
                            </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{--<div><pre id="showerror"></pre></div>--}}

    <!-- Modal -->
    <div class="modal fade" id="serialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="col-md-8" style="float: none; margin: 0 auto; margin-top: 110px" role="document">
            <div class="modal-content">
                <div class="modal-header btn-primary mainThemeColor">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Select Serial no for items to be issued</h4>
                    <div class="row">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Code</th>
                                <th>Qty Ordered</th>
                                <th>Qty Issued</th>
                                <th>Qty Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="itemDesc"></td>
                                <td id="itemCode"></td>
                                <td id="qtyOrdered"></td>
                                <td id="qtyReceived"></td>
                                <td id="qtyBal"></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-body">

                    {{--{{ method_field('PUT') }}--}}
                    <form onsubmit="return eventListner()" id="allinputs" method="POST" action="{{route('issue.store')}}">
                        <input id="token" type="hidden" name="_token" value="{{csrf_token()}}" />
                        {{--                    {{ csrf_field() }}--}}
                        <div class="col-md-12">
                            <div class="input-group">
                                <select name="search" id="search" class="form-control search" style="width: 100%;">
                                    <option value="">--Choose Serial no--</option>
                                    @foreach($serials as $serial)
									  
                                        <option value="{{$serial->id}}">{{$serial->serial_one ? ($serial->serial_one ? $serial->serial_one:$serial->serial_two):($serial->serial_three ? $serial->serial_three : $serial->serial_four)}}</option>
                                    @endforeach
                                </select>

                                <span class="input-group-btn"><button type="submit" class="btn btn-primary btn-sm btn-raised">
                                        <i class="fa fa-plus fa-lg "></i> Add </button>
                    </form>
                    <button style="margin-left: 2px" type="button" id="dismiss" class="btn btn-sm btn-danger btn-raised" data-dismiss="modal">
                        <i class="fa fa-close fa-lg "></i>Close</button></span>
                </div>
            </div>
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
        $('.items,.search').select2();
        var numb = 1;
        var remainingqty = 0;
        var iTemidInvoiceLines = '';
        var itemCode = '';
        var item_description = '';
        var dnote_setting = '{{\App\Setting::where('setting_id',3)->first()->default_value}}'
        var itemname = '';
        var theTotalItem = 0;

        function printContent(el,autoindexid){
            if($(".modalTableRow tr").length) {
                var dataTosend = {'id': autoindexid};
                $.ajax({
                    url: '{{url('issuednote')}}',
                    type: 'get',
                    data: dataTosend,
                    success: function (response) {
                        var restorepage = document.body.innerHTML;
                        var printcontent = document.getElementById(el).innerHTML;
                        document.body.innerHTML = printcontent;
                        window.print();
                        document.body.innerHTML = restorepage;
                        $(".modalTableRow").empty();
                        successMessage(response);
//                        console.log(reponse);
                        location.reload();
                    },
                    error: function (response) {
//                        console.log(response);
                    }
                });

            }
            else{
                errorMessaage('Delivery note is empty');
            }
        }

        function eventListner() {
            sendForm();
            return false
        };


        function issueItem(itemAmount,ordered,received,itemDetails) {
            $('#search').val('');
            theTotalItem = itemAmount;
            itemCode = itemDetails.code;
            item_description = itemDetails.cDescription;
//            console.log(itemDetails);
            remainingqty = parseInt($('#total_'+itemDetails.idInvoiceLines).html())
            iTemidInvoiceLines = itemDetails.idInvoiceLines;
            $("#wholeData").val(JSON.stringify(itemDetails));
            $(".warrant").select2();
            $('#itemCode').text(itemDetails.code);
            $('#itemDesc').text(itemDetails.cDescription);
            $('#qtyOrdered').text(ordered);
            $('#qtyReceived').text(received);
            $('#qtyBal').text(itemAmount);

        }

        function addRow(descr,code,idInvoiceLines)  {
            if($(".modalTableRow tr").hasClass(code) && dnote_setting == 1)
                {
                    $(".modalTableRow ." + code + " td:nth-child(3)").html(parseInt($(".modalTableRow ." + code + " td:nth-child(3)").html()) + 1);
                    $("#qty_"+iTemidInvoiceLines).html(parseInt($("#qty_"+iTemidInvoiceLines).html())-1);
                    if(parseInt($("#qty_"+iTemidInvoiceLines).html()) <= 0)
                    {
                        $("#"+iTemidInvoiceLines).remove();
                        closemodal();
                    }
                }
            else
                {
                    var itemd = dnote_setting == 1 ? numb : $('#search').val();
                        data = "<tr class='" + code + "'>" +
                                "<td>" + itemd + "</td>" +
                                "<td class='text-capitalize'>" + descr + "</td>" +
                                "<td> 1 </td>" +
                                "</tr>";

                $(".modalTableRow").append(data);
                $('#qty_'+iTemidInvoiceLines).html(parseInt($('#qty_'+iTemidInvoiceLines).html())-1);
                if(parseInt($("#qty_"+iTemidInvoiceLines).html()) <= 0)
                    {
                        $("#"+iTemidInvoiceLines).remove();
                    }
                numb++;
            }
        }

        function sendForm()
        {
            if($(".modalTableRow tr").hasClass(itemCode) && parseInt($(".modalTableRow ."+itemCode+" td:nth-child(3)").html()) >= remainingqty)
                {
                    errorMessaage('You can not issue more than Ordered qty');
                    $('#'+iTemidInvoiceLines).hide();
                    closemodal();
                }
            else {
                var formData = {};
                formData['serial'] = $('#search').val();
                formData['code'] = itemCode;
                formData['idInvoiceLines'] = iTemidInvoiceLines;
                formData['_token'] = $('#token').val();

                $.ajax({
                    url: '{{ route('issue.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
//                        console.log(response);
                        if (response == 'Serial not found') {
                            errorMessaage(response);
                            $('#search').val('');
                        }

                        else if (response == 'Invalid' || response == 'Issued' || response == 'Item code does not match serial code') {
                            errorMessaage(response + ' serial');
                            $('#search').val('');
                        }

                        else {
                            successMessage()
                            addRow(response.cDescription, response.code, response.idInvoiceLines);
//                            closemodal()
                            $('#search').val('');
                        }
                    },
                    error: function (response) {
//                        console.log(response);
                    }
                });
            }
        }


        function errorMessaage(msg) {
            sflash({
                title: "Error",
                text: msg,
                type: "error",
                allowOutsideClick: true,
                confirmButtonText: "Got it",
                showConfirmButton: true
            });
        }

        function successMessage() {
            sflash({
                title: "Activation",
                text: "Serials Activated successfully",
                type: "success",
                allowOutsideClick: true,
                showConfirmButton: false,
                timer: 900
            });
        }

        var serials = '{{url('api/get-serials')}}';

       // var maxField = 10; //Input fields increment limitation
       //  var addButton = $('.add_button'); //Add button selector
       //  var wrapper = $('.field_wrapper'); //Input field wrapper
       //
       //
       //  var x = 1; //Initial field counter is 1
       //
       //  //Once add button is clicked
       //  $(addButton).click(function(){
       //      //Check maximum number of input fields
       //      if(x < maxField){
       //          x++; //Increment field counter
       //          $.getJSON(serials, function(data) {
       //              $.each(data,function (index, value) {
       //                  $(wrapper).append('<div><br><select name="search" id="search'+value.id+'" class="form-control search"><option value="'+value.serial_one+'">'+value.serial_one+'</option></select> <a href="javascript:void(0);" class="fa fa-trash-o remove_button"  style="font-size:26px"></a></div>');
       //
       //              })
       //          })
       //
       //          // $(wrapper).append(fieldHTML); //Add field html
       //
       //      }
       //  });
       //
        // //Once remove button is clicked
        // $(wrapper).on('click', '.remove_button', function(e){
        //     e.preventDefault();
        //     $(this).parent('div').remove(); //Remove field html
        //     x--; //Decrement field counter
        // });

    </script>
@endsection
