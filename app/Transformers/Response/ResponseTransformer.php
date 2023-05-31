<?php

namespace App\Transformers\Response;

use App\Models\Response;
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
    public function transform(Response $response): array
    {
        return [
            'is_correct'=>$response->is_correct
        ];
    }
}
