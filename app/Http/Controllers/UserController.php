<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Rules\IndianPhoneNumber;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::OrderById()->get();
        $roles = Role::pluck('name','id');
        return view('users.create' , compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{

            if($request->ajax() && $request->method('POST')){
                
                $this->validate($request,[
                    'name'=>'required|min:2|max:50',
                    'email'=>'required|email|unique:users,email',
                    'phone'=>['required',new IndianPhoneNumber()],
                    'role'=>'required',
                    'description'=>'required|min:10|max:200',
                    'image'=>'required|mimes:png,jpeg,jpg|max:5120',
                ]);

                $filename = $request->file('image')->getClientOriginalName();
                $image = $request->file('image')->storeAs( 'public/uploads/'.time() , $filename);

                $user = User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'description'=>$request->description,
                    'image'=>$image,
                ]);

                $users = User::OrderById()->get();

                if( $user ){
                    $role = Role::find($request->role);
                    $user->roles()->attach($role);
                    return response()->json([
                        'status'=>true,
                        'message'=>__('User created successfully...'),
                        'total_records'=>$user->count(),
                        'users'=>view('users.table' , compact('users'))->render(),
                    ],200);
                }

                return response()->json([
                    'status'=>false,
                    'message'=>__('Failed to create'),
                ],200);

            }

        }catch(\Exception $e){
            return response()->json(['errors'=>$e->getMessage()],500);
        }

        
        print_r($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
