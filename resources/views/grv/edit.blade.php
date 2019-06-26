@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-primary">
                    <div class="panel-heading mainThemeColor">
                        <div class="row">
                        <a href="{{route('grv.index')}}" class="col-sm-2">
                            <button class="btn-sm btn btn-default btn-raised">Back</button></a>
                        <h3 class="text-center col-sm-6">Goods Received Vouchers Items</h3>
                            <form class="col-sm-4" role="form" method="post" action="{{ url('/receive') }}">
                                {{ csrf_field() }}
                            <div class="input-group">
                            <select style="width: 100%;" class="form-control select inputs" id="select" name="check" required>
                                        @foreach(\App\Grv::where('status','!=',\App\Grv::SERIALIZED_GRV)->where('state',\App\Grv::PROCESSED_GRV)->get() as $grv)
                                            <option onclick="reciveGrv()"  value="{{$grv->autoindex_id}}" >{{$grv->GrvNumber}}</option>
                                        @endforeach
                                    </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-raised btn-sm" type="submit">Rcv</button>
                                 </span>
                            </div>
                           </form>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 text-left">
{{--                                <h5>GRV ID: {{$details->GrvID}}</h5>--}}
                                <h5>GRV NO: {{$details->GrvNumber}}</h5>
                                <h5>Description: {{$details->Description}}</h5>
                                <h5>Account Name: {{$details->cAccountName}}</h5>
                            </div>
                            <div class="col-md-6">
                                @if($details->OrderNum != 0)
                                <h5>Order No: {{$details->OrderNum}}</h5>
                                @endif
                                <h5 class="text-right">Invoice Date: {{\Carbon\Carbon::parse($details->InvDate)->format(\Serial\Helper::helper()->dateFormat())}}</h5>
                                <h5 class="text-right">Order Date: {{\Carbon\Carbon::parse($details->OrderDate)->format(\Serial\Helper::helper()->dateFormat())}}</h5>
                                <h5 class="text-right">Delivery Date: {{\Carbon\Carbon::parse($details->DeliveryDate)->format(\Serial\Helper::helper()->dateFormat())}}</h5>
                            </div>
                        </div>
                        <hr />
                        <div class="col-md-12">
                            <table id="example" class="table table-striped table-hover table-responsive display dataTable">
                                <thead>
                                <tr>
                                    <th>NO :</th>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th class="text-right">Ordered Qty</th>
                                    <th class="text-right">To be RCVD Qty</th>
                                    <th class="text-right">RCVD Qty</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($grvItems as $item)
                                    <tr class="{{$item['has_warranty'] == 'no'?'warrantyError':''}}">
                                        <td >{{$loop->iteration}}</td>
                                        <td>{{$item['code']}}</td>
                                        <td>{{ucwords($item['description'])}}</td>
                                        <td class="text-right globalmargin">{{$item['fQuantity']}}</td>
                                        <td id="qty_{{$item['grvlines_id']}}" class="text-right globalmargin">{{$item['qty_remaining'] }}</td>
                                        <td id="rcvd_{{$item['grvlines_id']}}" class="text-right globalmargin">{{$item['qty_serialized']}}</td>
                                        <td class="text-center">
                                          
                                            @if($item['qty_remaining'] != 0)
                                            <a href="#" id="{{$item['grvlines_id']}}"
                                               onclick="select_all({{ $item['grvlines_id']}},{{json_encode($item)}})"
                                               data-toggle="modal" data-target="#serialModal">
                                                 Receive
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="serialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="col-md-8" style="float: none; margin: 0 auto; margin-top: 110px" role="document">
            <div class="modal-content">
                <div class="modal-header btn-primary mainThemeColor">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">Serialize</h4>
                    <div class="row">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Code</th>
                                <th>Qty Ordered</th>
                                <th>Qty Received</th>
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
                <form id="allinputs" method="POST">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{--{{ method_field('PUT') }}--}}
                    <table class="table table-striped table-bordered table-hover table-responsive modalTable" border="1" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Select</th>
                            {{--<th>Item No</th>--}}
                            @for($i = 1;$i <= \App\Setting::where('title','Number of Serials')->first()->default_value;$i++)
                                 <th>S NO {{$i}}</th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody class="modalTableRow">
                        </tbody>
                    </table>
                        <div class="row">
                            <div class="col-md-12">
                                {{--<button type="button" onclick="addRow()" class="btn btn-sm btn-primary btn-raised pull-right">--}}
                                    {{--<i class="fa fa-plus fa-lg "></i> Add--}}
                                {{--</button>--}}
                            <button type="button" onclick="removeRow()" class="btn btn-sm btn-danger btn-raised pull-right">
                                <i class="fa fa-trash fa-lg "></i> Delete</button>
                                <p id="clearbtn" onclick="clearErrors()" class="btn btn-sm btn-danger btn-raised pull-right">
                                <i class="fa fa-trash fa-lg "></i> Clear errors</p>
                        </div>
                        </div>
                        <hr />
                        <input type='hidden' id='wholeData' name='wholeData'/>
                    <div class="modal-footer">
                        <button type="button" id="dismiss" class="btn btn-sm btn-danger btn-raised" data-dismiss="modal">
                            <i class="fa fa-close fa-lg "></i> Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success btn-raised">
                            <i class="fa fa-check fa-lg "></i> Receive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var numb = 1;
        var maxitemrow = 0;
        var validation_type = '{{\App\Setting::where('setting_id',6)->first()->default_value}}';
        var itemname = '';
        var autoindexid = '{{$autoindexid}}';
        var itemgrvlineid = 0;
        var coln_checker = '{{\Serial\Helper::helper()->assignColnChecker()}}';

        $(".select").select2({
            placeholder: "Select GRV to receive",
            allowClear: true
        });

        $(document).keydown( function(event) {
            if (event.which === 13) {
                addRow();
                if(validation_type == 1) {
                    serials_search_array = [];

                    $('.' + coln_checker).each(function (index, values) {
                        if ($(values).length > 0) {
                            serials_search_array.push($(values).val());
                        }
                    });
                    if (serials_search_array[0].length > 0) {
                        serialChecker(serials_search_array);
                    }
                }
            }
        });


        function generateFields(number) {
            var fields = "";
            for (var i = 0; i < number; i++)
            {
                fields += "<td>" +
                        "<input id='"+number+"' type='text' required value='' class='form-control inputs serialno_" + i +"' id='serialno_" + i + "' name='serialno_" + i + "'/></td>";
            }
            return fields;
        }

        function clearErrors() {
//            console.log('yeah')
            if($('td').hasClass('errorTd'))
            {
                $.each($('.errorTd'),function (ind, valu) {
                    $(valu).parent().remove()
                    numb--
                });
                showClearError();
                return false;
            }
            if($('td').hasClass('btn-danger'))
            {
                $.each($('.btn-danger'),function (ind, valu) {
                    $(valu).parent().remove()
                    numb--
                });
                showClearError();
                return false;
            }
        }
        function removeRow() {
            if(numb == 2)
                {
                    errorMassage('You need at least one row to add serial');
                }
            else
                {
                var checkbox_length = $('.modalTableRow tr').length;
                if($('.checkbox:checked').length > 0) {
//                    console.log('yes');
                    $('.checkbox:checked').each(function (index,values) {
                        if((index+1) == checkbox_length)
                            {
                                errorMassage('You need at least one row to add serial');
                            }
                        else
                            {
                            $(this).parent().parent().remove();
                             }
                        numb--
                    });
                }
            }
        }

        $('#allinputs').on('submit', function (e) {
            e.preventDefault();
            $(window).keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return false;
                }
            });
            if (! validateRepeat())
                {
                    showClearError();
                    return false;
                }
            sendForm($('#wholeData').val());
        });

        function validateRepeat() {
            if($('td').hasClass('errorTd'))
            {
                $.each($('.errorTd'),function(inde,valu)
                {
                    $(valu).removeClass('errorTd');
                    $(valu).parent().removeClass('error');
                });
            }

            var allValues = [];
            var allErrors = [];

            $.each($('.'+coln_checker), (i, v)=> {
                $(v).val($(v).val());
                var checker = $(v).val();

                if (allValues.indexOf(checker) >= 0)
                    {
                        $(v).parent().addClass('errorTd');
                        $(v).parent().parent().addClass('error');
                        allErrors.push(checker);
                    }
                allValues[i] = $(v).val();
            });

            if (allErrors.length > 0) {
                var errorstatement = '';
                $.each(allErrors, function (index, value) {
                    errorstatement += value + '\n'
                });
                errorMassage('Repeated serial(s) \n' + errorstatement);
                return false;
            }
            return true;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addRow() {
            if(numb > maxitemrow)
            {
                if(maxitemrow <= 0)
                {
                    closemodal();
                }
                errorMassage('You can not add more rows, you only have '+maxitemrow+' '+itemname+' remaining');
            }

            else
            {
                errorArray = [];

                if($('td').hasClass('errorTd')) {
                    $.each($('.errorTd'), function (inde, valu) {
                        $(valu).removeClass('errorTd');
                        $(valu).parent().removeClass('error');
                    });
                }

                $('.modalTableRow tr .inputs').each(function(index,values)
                {
                    if(($(values).val().length <= 0))
                    {
                        errorArray.push(index);
                        $(values).parent().addClass('errorTd');
                    }
                });

                if(errorArray.length <= 0) {
                    data = "<tr class='item'>" +
                            "<td><input name='checkbox' class='checkbox' type='checkbox' /></td>" +
//                        "<td>" + numb + "</td>" +
                            generateFields({{\App\Setting::where('setting_id',1)->first()->default_value}}) +
                            "</tr>";
                    $(".modalTableRow").append(data);

                    validateRepeat();
                    numb++;
                }
                else
                    {
                         errorMassage('Fil in the empty fields');
                    }
            }
        }

        function showClearError() {
            if(validation_type == 2) {
                if ($('.modalTableRow tr').length > 1 && ($('td').hasClass('errorTd') || $('td').hasClass('btn-danger'))) {
                    $('#clearbtn').show();
                }
                else {
                    $('#clearbtn').hide();
                }
            }
        }

        function select_all(invoiceline,itemDetails) {
            $('#clearbtn').hide();
            numb = 1;
            maxitemrow = parseInt($('#qty_'+invoiceline).html());
            itemname = itemDetails.description;
            itemgrvlineid = invoiceline
            $("#wholeData").val(JSON.stringify(itemDetails));

            $(".warrant").select2();
            $('#itemCode').text(itemDetails.code);
            $('#itemDesc').text(itemDetails.description);
            $('#qtyOrdered').text(itemDetails.fQuantity);
            $('#qtyReceived').text(itemDetails.qty_serialized);
            $('#qtyBal').text(itemDetails.qty_remaining);

            if ($('.modalTableRow tr').length != 0)
                {
                    $('.modalTableRow tr').remove();
                }

            addRow();
        }


        function sendForm(data)
        {
            var rows = $('.item');
            var formData = {};
            formData['serials'] = {};

            $.each(rows, function (index, value) {
                formData['serials']['item_' + index] = {};
                var inputs = $(value).children('td').children('.inputs');
                $.each(inputs, function (inputIndex, input) {
                    var item = $(input);
                    formData['serials']['item_' + index][item.attr('name')] = item.val();
                });
            });

            formData['waranty'] = $('#warrant').val();
            formData['wholedata'] = data;
            formData['autoindexid'] = autoindexid;

            $.ajax({
                url: '{{ route('grv.store') }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(_.has(response[0],"serials"))
                    {
                        var errorText = ' ';
                        $.each(response,function (index, values) {
                            $.each($('td .'+coln_checker), function (inputinde, inputval) {
                                if($(inputval).val() == values.serials)
                                {
                                    $(inputval).parent().addClass('btn-danger');
                                }
//
                            });
                            errorText += ' ' + values.serials;
                        });
                        showClearError();
                        errorMassage('The following serial(s) ' + errorText + ' exist');
                    }
                    else {
                        $("#qty_"+response.idInvoiceLines).html(parseInt($("#qty_"+response.idInvoiceLines).html()) - response.numb);
                        $("#rcvd_"+response.idInvoiceLines).html(parseInt($("#rcvd_"+response.idInvoiceLines).html()) + response.numb);

                        if(parseInt($("#qty_"+response.idInvoiceLines).html()) <= 0)
                            {
                                $("#"+response.idInvoiceLines).hide();
                            }

                        successmassage('Serialization successful')
                        closemodal();
                    }
                },
                error: function(response) {
                    console.log( response );
                }
            });
        }

        function errorMassage(massage) {
            sflash({
                title: "Error",
                text: massage,
                type: "error",
                allowOutsideClick: true,
                confirmButtonText: "Got it",
                showConfirmButton: true
            });
        }

        function successmassage(msg) {
            sflash({
                title: "Serialized",
                text: msg,
                type: "success",
                allowOutsideClick: true,
                showConfirmButton: false,
                timer: 2500
            });
        }

        function serialChecker(serials_search_array) {
            if($('td').hasClass('btn-danger')) {
                $.each($('.btn-danger'), function (inde, valu) {
                    $(valu).removeClass('btn-danger');
                });
            }
            var serials_to_search = {};
            serials_to_search['serials'] = serials_search_array;

            $.ajax({
                url:'{{route('serials.store')}}',
                type:'POST',
                data:serials_to_search,
                success: function (response) {
                    var error_message = '';
                    $.each(response,function (index,values) {
                        $.each($('td .'+coln_checker), function (inputinde, inputval) {
                            if($(inputval).val() == values)
                            {
                                $(inputval).parent().addClass('btn-danger');
                            }
                        });
//                        console.log(error_message,response)
                        error_message += ' ' + values;
                    });
                    if(response.length > 0) {
//                        $('.modalTableRow tr:last-child').remove();
                        errorMassage('The following serial(s) ' + error_message + ' exist');
                    }
                    },
                error:function (response) {
                    console.log(response);
                }
            })
        }

    </script>
    @endsection
