@extends('layouts.app')
@section('title','Create & List User')
@section('content')

<div class="container">
        <div class="row">
            <h4 class="text-center"> Create New User</h4>

            <div class="col-lg-6 offset-lg-3">
                {{Form::open( ['route'=>'users.store','class'=>'form-control','id'=>'createUserForm','enctype'=>'multipart/form-data' ])}}

                    <div class="row">
                        <div class="form-group mb-3 col-lg-6">
                            <label for="cname">Name <sup class="text-danger">*</sup></label>
                            {{Form::text('name' , null , ['class'=>'form-control','id'=>'cname','placeholder'=>__('Enter your name'),'required'])}}
                        </div>

                        <div class="form-group mb-3 col-lg-6">
                            <label for="email">Email <sup class="text-danger">*</sup></label>
                            {{Form::email('email' , null , ['class'=>'form-control','id'=>'email','placeholder'=>__('Enter your email'),'required'])}}
                        </div>

                        <div class="form-group mb-3 col-lg-6">
                            <label for="phone">Phone <sup class="text-danger">*</sup></label>
                            {{Form::text('phone' , null , ['class'=>'form-control','id'=>'phone','placeholder'=>__('Enter your phone'),'required'])}}
                        </div>

                        <div class="form-group mb-3 col-lg-6">
                            <label for="image">Profile <sup class="text-danger">*</sup></label>
                            {{Form::file('image' , ['class'=>'form-control','id'=>'image','accept'=>'image/*','required'])}}
                        </div>


                        <div class="form-group mb-3 col-lg-12">
                            <label for="description">Description <sup class="text-danger">*</sup></label>
                            {{Form::textarea('description' , null , ['class'=>'form-control','id'=>'description','placeholder'=>__('Enter about you') ,'required' , 'rows'=>2])}}
                        </div>

                        <div class="form-group mb-3">
                            <label for="role">Role <sup class="text-danger">*</sup></label>
                            {{Form::select('role',$roles , null , ['class'=>'form-control','id'=>'role','required','placeholder'=>__('Select Role')])}}
                        </div>

                        

                        <div>
                            <button class="btn btn-primary createUser" type="button">
                                {{__('Create User')}}
                                <i class="fa fa-spin fa-spinner d-none"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="text-success mt-3" id="successMessage"></div>

                    <div class="error-message mt-3" id="errorMessage"></div>


                {{Form::close()}}

                
            </div>

            <div class="col-lg-12">
                <h4 class="border-bottom d-flex justify-content-between">
                    
                    Users 
                    <span style="font-size:15px;">
                        {{__('Total Records')}}: <span class="total_records">{{$users->count()}}</span>
                    </span>
                </h4>
                <table id="user-list" class="table tabler-borderd table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Role</th>
                        </tr>    
                    </thead>
                    <tbody>
                        @include('users.table')
                    </tbody>    
                </table>

                @if( $users->isEmpty() )
                    <p class="text-center">No users found</p>
                @endif

            </div>

        </div>
    </div>
@endsection