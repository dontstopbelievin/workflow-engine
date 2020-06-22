@extends('layouts.master')

@section('title')
   View Role
@endsection

@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users with Role {{$role->role_name}}</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                              <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td> 
                              </tr>   
                              @endforeach                             
                            </tbody>
                        </tablе>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection