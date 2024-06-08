@extends('layout/layout_common')

@section('space-work')
@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{$error}}</p>
    @endforeach
@endif
 
<form action="{{ route('resetpassword')}}" method="POST">
    @csrf
<h1>reset password</h1>
    
<input type="hidden" name="id" value="{{ $user[0]['id']}}">
    <input type="password" name="password" placeholder="Enter the password"><br><br>
    <input type="password" name="password_confirmation" placeholder="Enter the password_confirmation"><br><br>
    
     <input type="submit" value="Reset password">
     
</form>


@endsection 