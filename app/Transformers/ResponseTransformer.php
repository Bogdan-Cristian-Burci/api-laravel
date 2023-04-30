<?php

namespace App\Transformers;

use App\Models\Responses;
use League\Fractal\TransformerAbstract;

class ResponseTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Responses $response): array
    {
        return [
            'is_correct'=>$response->is_correct
        ];
    }
}
