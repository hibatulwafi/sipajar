<html>
<head>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="col-sm-6 col-md-3">
    <h2 class="no-margin text-semibold">Current RAM Usage</h2>
    <div class="progress progress-micro mb-10">
      <div class="progress-bar bg-indigo-400" style="width: {{$memory}}">
        <span class="sr-only">{{$memory}}</span>
      </div>
    </div>
    <span class="pull-right">{{$usedmemInGB}} / {{$totalram}} ({{$memory}})</span>  

  </div>

  <div class="col-sm-6 col-md-3">
    <h2 class="no-margin text-semibold">Current CPU Usage</h2>
    <div class="progress progress-micro mb-10">
      <div class="progress-bar bg-indigo-400" style="width: {{$load}}">
        <span class="sr-only">{{$load}}</span>
      </div>
    </div>
    <span class="pull-right">{{$load}}</span>   
  </div>

</body>
</html>