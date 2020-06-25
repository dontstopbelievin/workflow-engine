@extends('layouts.master')

@section('title')
    Field Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Создать поле</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/manual/create" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="field_name">Field Name</label>
                                    <input type="text" class="form-control" name="field_name" placeholder="Enter field name">
                                    <small id="emailHelp" class="form-text text-muted">Make sure entered fields is not in list of fields</small>
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