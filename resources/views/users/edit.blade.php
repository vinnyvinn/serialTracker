@extends('layouts.app')
@section('content')

    <div class="row">

        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-headding"><h3 class="text-center" style="padding-top: 1px">Edit User Details</h3></div>
                <div class="panel panel-body">

                    <form action="{{route('manage-users.update',$user->id)}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('put')}}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label for="type">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
