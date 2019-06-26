<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Serial Tracker</title>
</head>
<body>
<div class="row">
    <div class="col-md-6" style="float: none; margin: 0 auto">

        @foreach($grv as $key => $gv)
        <p>{{$key}}</p>
<!--            --><?php
//            foreach ($gv as $value){
//                echo  $value->cDescription . '<br />';
//            }
//            ?>
            @endforeach
    </div>
</div>
</body>
</html>