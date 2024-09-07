<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    public function toArray($request)
    {
        // Check if there's an 'error' key in the resource
        if (isset($this->resource['error'])) {
            // Directly return the error structure without 'data' wrapping
            return [
                'success' => false,
                'errors' => $this->resource['error'],
                'code' => $this->resource['code']
            ];
        }

        // Default success response without 'data' wrapping
        return [
            'success' => true,
            'data' => $this->resource
        ];
    }
}