<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    protected $perPage;
    protected $sort;
    protected $search;
    protected $filter;

    public function __construct()
    {
        $this->perPage = config('app.per_page');
        $this->sort = config('app.sort');
    }

    protected function searchFilterPerpage(Request $request)
    {
        $this->search = $request->get('search');
        $this->filter = $request->get('filter');
        $this->perPage = max(min($request->get('perPage'), 50), $this->perPage);
    }

    public function paginate($collection, $message = 'Success', $status = 200)
    {
        return response()->json([
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
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function error($message = 'Error', $status = 400)
    {
        return response()->json([
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
