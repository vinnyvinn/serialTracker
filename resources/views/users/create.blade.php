@extends('layouts.app')
@section('content')

    <div class="row">

        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-headding"><h3 class="text-center" style="padding-top: 1px">New User Details</h3></div>
                <div class="panel panel-body">

                    <form action="{{route('manage-users.store')}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Save</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
