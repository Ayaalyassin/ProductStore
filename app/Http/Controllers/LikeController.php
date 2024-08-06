<?php

namespace App\Http\Controllers;

use App\Services\LikeService;

class LikeController extends Controller
{

    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService=$likeService;
    }

    public function store($id)
    {
        $this->likeService->store($id);

        return response()->json('done');

    }



}
