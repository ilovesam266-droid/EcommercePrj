<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
