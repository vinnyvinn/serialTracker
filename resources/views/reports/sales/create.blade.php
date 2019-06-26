@extends('layouts.app')
@section('content')

    <div class="row">

        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-headding"><h3 class="text-center" style="padding-top: 1px">Choose period</h3></div>
                <div class="panel panel-body">

                    <form action="{{url('sales-report-generate')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="form-control datepicker" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" class="form-control datepicker" name="end_date" required>
                        </div>
                       <button type="submit" class="btn btn-primary btn-block reports-button">Generate</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')

    <script src="{{asset('js/jquery-1.12.4.js')}}"></script>
    <script src="{{asset('/js/jquery-ui.js')}}"></script>
    <script type="text/javascript">
        $(function () {

        })
        $('.datepicker').datepicker();
    </script>


@endsection
