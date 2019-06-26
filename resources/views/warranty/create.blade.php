@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">

                        <div>
                            <a href="{{route('warrantysetup.index')}}" class="btn btn-sm btn-default btn-raised pull-right">
                                All Warranties
                                </a>
                            <h3 align="center">Set Items Warranty</h3>

                        </div>

                    </div>
                    <div class="panel-body">
                        <form action="{{route('warrantysetup.store')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="codes">Select item codes</label>
                                <select style="width: 100%" class="form-control warrant inputs" id="codes" name="codes[]" multiple required>
                                    @foreach($codes as $code)
                                        <?php
                                            echo '<option value="'.$code->code.'">'.$code->code.'</option>';
                                        ?>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="globalmargin col-md-12">Set Warranties Duration(years)</div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="service" class="col-sm-4">Service Warranty</label>
                                        <div class="col-sm-8">
                                            <input type="number" required max="50" min="0" class="form-control" id="service" name="service">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="labour" class="col-sm-4">Labour Warranty</label>
                                        <div class="col-sm-8">
                                            <input type="number" required max="50" min="0" class="form-control" id="labour" name="labour">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="parts" class="col-sm-4">Parts Warranty</label>
                                        <div class="col-sm-8">
                                            <input type="number" required max="50" min="0" class="form-control" id="parts" name="parts">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn pull-right btn-raised btn-primary">Save</button>
                        </form>
                        {{--<button type="submit" class="pull-right btn btn-raised btn-success">Save</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var msg = '{{$success}}';
        if(msg == 'success')
        {
            sflash({
                title: "Success",
                text: "Warranty added successfully",
                type: "success",
                allowOutsideClick: true,
                showConfirmButton: false,
                timer: 2500
            });
        }
        $(".warrant").select2({
            placeholder : "Select item codes"
        });
    </script>
@endsection
