<?php

namespace App\Http\ResponseBuilders;

use App\Http\ResponseBuilders\BaseResponseBuilder;

class FailuerResponseBuilder extends BaseResponseBuilder
{
    protected $status = parent::STATUS_LIST['FAILUER'];

    /**
     * Undocumented function
     *
     * @param array $errorList
     * @return FailuerResponseBuilder
     */
    public function setParamErrorList(array $errorList)
    {
        $this->content["param_error_list"] = $errorList;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $errorList
     * @return FailuerResponseBuilder
     */
    public function setSystemErrorList(array $errorList)
    {
        $this->content["system_error_list"] = $errorList;
        return $this;
    }
}