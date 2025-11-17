<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ImageUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Resources\UserTransformer;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepository;
    protected $perPage;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->perPage = config('app.per_page');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = $request->query('per_page', $this->perPage);
        $users = $this->userRepository->all([], ['created_at' => 'asc'], $this->perPage, ['*'], [], false);
        return response()->json([
            'data' => UserTransformer::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ]
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        if ($validated['avatar']) {
            $avatarPath = ImageUpload::upload($validated['avatar'], 'avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        $user = $this->userRepository->create($validated);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userRepository->find($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $validated = $request->validated();
        if ($request->hasFile('avatar')) {
            $avatarPath = ImageUpload::upload($validated['avatar'], 'avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        $user = $this->userRepository->update($id, $validated);
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = $this->userRepository->delete($id);
        return response()->json($user, 200);
    }
}
