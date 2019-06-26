@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9" style="float: none; margin: 0 auto">
                <div class="panel panel-info">
                    <div class="panel-heading mainThemeColor">
                        <a href="{{route('warrantysetup.create')}}" class="btn btn-sm pull-right btn-raised btn-default">Create</a>
                        <h3 class="text-center">All Warranties</h3>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($warranties as $warranty)
                                <div class="col-sm-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading text-center">
                                            <h4>Warranty Details</h4>
                                            <h5>Labour : {{$warranty->labour}} year{{$warranty->labour>1 ? 's' : ''}}</h5>
                                            <h5>Service : {{$warranty->service}} year{{$warranty->service>1 ? 's' : ''}}</h5>
                                            <h5>Labour : {{$warranty->parts}} year{{$warranty->parts>1 ? 's' : ''}}</h5>

                                        </div>
                                        <div class="panel-body">
                                            <h5>Item codes</h5>
                                            <?php
                                            foreach (json_decode($warranty->item_codes) as $item_code)
                                            {
                                                echo '<button class="btn btn-success btn-xs mainThemeColor" style="color: #ffffff">'.$item_code.'</button>';
                                            }
                                            ?>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <form action="{{url('warrantysetup/'.$warranty->id)}}" method="post">
                                                    <input type="hidden" name="_method" value="DELETE"/>
                                                    {{csrf_field()}}
                                                    <button type="submit" class="fa btn btn-sm btn-danger btn-raised colorwhite pull-right fa-trash fl"></button>
                                                </form>
                                                <a href="{{route('warrantysetup.edit',['id'=>$warranty->id])}}" class="fa btn btn-sm btn-success btn-raised colorwhite pull-right fa-pencil fl"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection