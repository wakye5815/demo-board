<?php

namespace App\Http\ResponseBuilders;
use \Illuminate\Http\JsonResponse;

abstract class BaseResponseBuilder
{
    protected const STATUS_LIST = [
        'ERROR' => 0,
        'FAILUER' => 1,
        'SUCCESS' => 2
    ];

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $status = "";

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $content = [];


    /**
     * Undocumented function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function build()
    {
        return response()->json(
            [
                'status' => $this->status,
                'content' => $this->content
            ]
        );
    }
}
