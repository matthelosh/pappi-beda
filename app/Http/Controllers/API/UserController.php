<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Validator;
use App\Http\Resources\User as UserResource;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'Data USer');
    }
}