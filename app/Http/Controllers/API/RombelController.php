<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Rombel;
use Validator;
use App\Http\Resources\Rombel as RombelResource;

class RombelController extends BaseController
{
    public function index()
    {
        $rombels = Rombel::all();
        return $this->sendResponse(RombelResource::collection($rombels), 'Data Rombel');
    }
}