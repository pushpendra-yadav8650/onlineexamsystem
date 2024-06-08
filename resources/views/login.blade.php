@extends('layout/layout_common')

@section('space-work')
@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{$error}}</p>
    @endforeach
@endif

@if (Session::has('error'))
    <p style="color:red">{{ Session::get('error')}}</p>
@endif
<!doctype html>
<html lang="en">
  <head>
  	<title>OES Admin </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/style.css')}}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </head>
  <body class="bg-info">

<form action="{{ route('userlogin')}}" method="POST">
    @csrf
    <h1 class="text-center text-warning">Online Exam System</h1>
<h4 class="text-danger text-center">Student Login</h4>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 border p-5">
    <input type="email" name="email" placeholder="Enter the email" class="form-control"><br><br>
    <input type="password" name="password" placeholder="Enter the Password" class="form-control"><br><br>
     <input type="submit" class="form-control" value="Login">
     <a href="/forget-password" class="text-danger">Forget password</a>
     </div>
     </div>
     <div class="col-sm-3"></div>
</form>
</body>

@endsection