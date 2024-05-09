@extends('layout')
@section('title','editProfile')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/editProfile.css') }}"/>
@endsection


@section('content')
    <div class="container editProfile_deg p-5">
        <form action="{{ route('runEditProfile') }}" method="post" class="item-form" enctype="multipart/form-data">
            @method('put')
            @csrf
            <h1 class="mb-1 mt-5 fw-bold">Edit Profile</h1>
            <div class="form-group" style="margin-top: 25px">
                <input type="text" class="form-control" id="username" name="username" placeholder="New Username" value="{{$user->username}}">
              </div>
            <div class="form-group" style="margin-top: 25px">
              <input type="text" class="form-control" id="email" name="email" placeholder="New Email" value="{{$user->email}}">
            </div>
            <div class="button mb-3">
              <button type="submit" class="btn btn-primary" style="margin-top: 25px">Save</button>
            </div>
            @if($errors->any())
              <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
              </div>
            @elseif (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
          </form>
          <br>
    </div>
@endsection
