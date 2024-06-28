<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController
{
    public function index(IndexUserRequest $request): JsonResponse
    {
        $subordinates = User::where(
            'superior_id',
            $request->validated('superior_id')
        )->paginate(
            perPage: $request->validated('per_page'),
            page: $request->validated('page'),
        );

        return (new UserCollection($subordinates))->response();
    }

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

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->input());

        return (new UserResource($user))->response();
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
