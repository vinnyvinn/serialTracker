@extends('layouts.app')
@section('content')

    <div class="row">

        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-headding"><h3 class="text-center" style="padding-top: 1px">Users</h3>
                    <a href="{{route('manage-users.create')}}" class="btn btn-default pull-right"><i class="fa fa-plus mb-5">Add new user</i></a>
                </div>
                <div class="panel panel-body">

                   <table class="table-bordered table-responsive table-striped" id="example" width="100%">
                       <thead>
                       <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Action</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($users as $user)
                       <tr>

                           <td>{{$user->name}}</td>
                           <td>{{$user->email}}</td>
                           <td>
                               <a href="{{url('manage-users/'.$user->id.'/edit')}}" class="btn btn-info pull-left"><i class="fa fa-edit" title="Edit"></i></a>
                               <form action="{{route('manage-users.destroy',$user->id)}}" method="post">
                                   {{csrf_field()}}
                                   {{method_field('delete')}}
                                   <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                               </form>
                           </td>
                       </tr>
                           @endforeach
                       </tbody>
                   </table>
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
    </script>
@endsection
