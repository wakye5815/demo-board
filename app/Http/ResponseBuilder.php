<?php

namespace App\Http;

class ResponseBuilder
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    private $status = "";

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $content = [];
    
    /**
     * Undocumented function
     *
     * @return App\Http\ResponseBuilder
     */
    public function setFailuerStatus()
    {
        this.$status = "failuer";
        return this;
    }

    /**
     * Undocumented function
     *
     * @param array $errorList
     * @return void
     */
    public function setParamErrorList(array $errorList)
    {
        this.$content["param_errror_list"] = $errorList;
        return this;
    }

    /**
     * Undocumented function
     *
     * @param array $errorList
     * @return void
     */
    public function setSystemErrorList(array $errorList)
    {
        this.$content["system_errror_list"] = $errorList;
        return this;
    }
}