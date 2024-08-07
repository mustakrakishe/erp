<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SignInRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function signIn(SignInRequest $request): JsonResponse
    {
        $user = User::firstWhere('login', $request->validated('login'));

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return response()->json([
            'data' => [
                'user'  => new UserResource($user),
                'token' => $user->createToken('On Sign In')->plainTextToken,
            ],
        ]);
    }

    public function signOut(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
