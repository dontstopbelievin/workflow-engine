@extends('layouts.master')

@section('title')
    Process Creation
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Please, create a process</h4>
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
                                    <label for="role_name">Наименование</label>
                                    <input type="text" class="form-control" name="role_name" placeholder="Enter role name">
                                    <label for="duration">Срок(количество дней)</label>
                                    <input type="number" class="form-control" name="duration" placeholder="Enter limitation">
                                    <label for="fields">Состав полей</label>
                                    <div class="container">
                                        <!-- Trigger the modal with a button -->
                                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" role="dialog">
                                            <div class="modal-dialog">
                                            
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Modal Header</h4>
                                                </div>
                                                <div class="modal-body">
                                                <p>Some text in the modal.</p>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            
                                            </div>
                                        </div>
                                        
                                        </div>
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