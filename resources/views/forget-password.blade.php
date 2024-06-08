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
@if (Session::has('success'))
    <p style="color:green">{{ Session::get('success ')}}</p>
@endif
<form action="{{ route('forgetpassword')}}" method="POST">
    @csrf
<h1>Forget password</h1>
    
    <input type="email" name="email" placeholder="Enter the email"><br><br>
    
     <input type="submit" value="Login">
     <a href="/forget-password" >login  </a>
</form>


@endsection