@extends('layouts.master')

@section('title')
    Role Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создать роль</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/roles/create" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="role_name">Роль</label>
                                    <input type="text" class="form-control" name="role_name" placeholder="Enter role name">
                                    <small id="emailHelp" class="form-text text-muted">Make sure entered roles is not in list of roles</small>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection