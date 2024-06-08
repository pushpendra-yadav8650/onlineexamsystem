@extends('layout/layout_common')

@section('space-work')
@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{$error}}</p>
    @endforeach
@endif
<form action="{{ route('StudentRegister')}}" method="POST">
    @csrf
<h1>Student Registration form</h1>
    <input type="text" name="name" placeholder="Enter the student name"><br><br>
    <input type="email" name="email" placeholder="Enter the email"><br><br>
    <input type="password" name="password" placeholder="Enter the Password"><br><br>
    <input type="password" name="password_confirmation" placeholder="Enter Confirm passeword"><br><br>
    <input type="submit" value="Register">
</form>

@if (Session::has('success'))
    <p style="color:green">{{ Session::get('success')}}</p>
@endif
@endsection