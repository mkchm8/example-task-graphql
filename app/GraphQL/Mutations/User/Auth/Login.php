<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\User\Auth;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class Login
{
    /**
     * @param null $root
     * @param array{} $args
     * @return array|void
     * @throws AuthenticationException
     */
    public function __invoke($root, array $args)
    {
        /** @var array $sanctumGuards */
        $sanctumGuards = config('sanctum.guard');

        /** @var string $sanctumGuard */
        $sanctumGuard = Arr::first($sanctumGuards);

        $guard = Auth::guard($sanctumGuard);
        if (!$guard->attempt($args)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $user = $guard->user();
        assert($user instanceof User);

        return [
            // Sanctumトークンを生成
            'token' => $user->createToken('graphql')->plainTextToken,
            'user' => $user,
        ];
    }
}
