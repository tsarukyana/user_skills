<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Retrieve a paginated list of users, 3 users per page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::paginate(3); // Paginate with 3 users per page
        return response()->json($users);
    }

    /**
     * Create a new user based on the provided UserStoreRequest data.
     *
     * @param UserStoreRequest $request The request containing user data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        // TODO we can get below or other lists from request also
        $skills = ['php', 'js', 'golang', 'java'];
        $randomSkills = array_rand(array_flip($skills), rand(3, count($skills)));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(12)),
            'description' => implode(', ', (array) $randomSkills),
        ]);

        return response()->json($user, 201);
    }
}
