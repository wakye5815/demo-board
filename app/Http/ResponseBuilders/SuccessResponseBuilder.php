<?php

namespace App\Http\ResponseBuilders;

use App\Http\ResponseBuilders\BaseResponseBuilder;

class SuccessResponseBuilder extends BaseResponseBuilder
{
    protected $status = parent::STATUS_LIST['SUCCESS'];

    /**
     * Undocumented function
     *
     * @param array $content
     * @return SuccessResponseBuilder
     */
    public function setContent(array $content)
    {
        $this->content = $content;
        return $this;
    }
}