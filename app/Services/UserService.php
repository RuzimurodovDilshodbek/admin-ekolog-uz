<?php
namespace App\Services;

use app\models\User;
use App\Repositories\UserRepository;

class UserService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function store($request)
    {
        $validator = $this->repository->toValidate($request->all());
        $msg = "";
        if (!$validator->fails()) {

            $user = $this->repository->store($request);
            return response()->successJson(['Users' => $user]);

        } else {

            $errors = $validator->failed();
            return response()->errorJson($msg, 400, $errors);

        }
    }
}
