<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController
{
    public function create(CreateUserRequest $request): JsonResponse
    {
        $user = User::create($request->input());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user): JsonResponse
    {
        return (new UserResource($user))->response();
    }
}
