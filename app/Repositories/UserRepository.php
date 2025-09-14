<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }
    public function store($request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'region_id'=>$request->region_id,
            'city_id'=>$request->city_id,
            'password'=>Hash::make($request->password),
            'reset_password'=>Hash::make($request->password)
        ]);
        $data['user'] = $user;
        return $data;
    }
    public function toValidate($array, $status = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable','string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:9','max:9'],
            'password' => ['required', 'string', 'min:6'],
            'reset_password' => ['required', 'string', 'min:6','same:password'],
            'region_id'=>'required',
            'city_id'=>'required',
        ];

        $validator = Validator::make($array, $rules);

        return $validator;
    }

}
