<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    protected function paginate($collection, $message = 'Success', $status = 200)
    {
        // Mặc định tự động build format pagination
        // $data = [
        //     'data' => ->items(),

        // ];

        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $collection,
            'meta' => [
                'current_page' => $collection->currentPage(),
                'per_page'     => $collection->perPage(),
                'total'        => $collection->total(),
                'last_page'    => $collection->lastPage(),
            ],
        ], $status);
    }

    protected function success($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function error($message = 'Error', $status = 400)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
        ], $status);
    }

    protected function created($data = null, $message = 'Created')
    {
        return $this->success($data, $message, 201);
    }

    protected function notFound($message = 'Not found')
    {
        return $this->error($message, null, 404);
    }

    protected function unauthorized($message = 'Unauthorized')
    {
        return $this->error($message, null, 401);
    }

    protected function forbidden($message = 'Forbidden')
    {
        return $this->error($message, null, 403);
    }
}
