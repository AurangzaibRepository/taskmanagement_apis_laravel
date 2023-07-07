<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

if (! function_exists('getResponse')) {
    function getResponse(
        bool $status,
        array $data = null,
        string $message = null,
    ): JsonResponse {
        $responseArray = [
            'status' => $status,
        ];

        if ($data !== null) {
            $responseArray['data'] = $data;
        }

        if ($message !== null) {
            $responseArray['message'] = $message;
        }

        return response()->json($responseArray);
    }
}

if (! function_exists('applyLimitOffset')) {
    function applyLimitOffset(
        Builder $query,
        int $limit,
        int $offset,
    ): Collection {

        return $query->limit($limit)
            ->offset($offset)
            ->get();
    }
}
