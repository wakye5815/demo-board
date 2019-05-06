<?php
namespace App\Http\Validators;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\ResponseBuilders\FailuerResponseBuilder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;

abstract class BaseValidator
{
    /**
     * Undocumented variable
     *
     * @var Validator
     */
    private $validator = null;

    function __construct(Request $request, ...$validateParamArray)
    {
        $validateParams = collect($validateParamArray);

        $validateParams->each(function ($param, $key) {
            if ($this->isUnvalidatableParam($param)) {
                throw new \Exception("${$param} is unvalidatable parametor");
            }
        });

        $this->validator = Validator::make(
            $request->all(),
            $this->extractNecessaryRules($validateParams),
            $this->extractNecessaryMessages($validateParams)
        );
    }

    public function fails()
    {
        return $this->validator->fails();
    }

    public function sendFailuerResponse()
    {
        if (!$this->fails()) throw new \Exception('not exists validation error');

        throw new HttpResponseException(
            (new FailuerResponseBuilder())
                ->setParamErrorList($this->validator->errors()->toArray())
                ->build()
        );
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    abstract protected  function validatableParams();

    /**
     * Undocumented function
     *
     * @param string $param
     * @return boolean
     */
    private function isUnvalidatableParam(string $param)
    {
        return !$this->validatableParams()
            ->contains(function ($value, $key) use ($param) {
                return $param == $value;
            });
    }

    /**
     * バリデートするパラメータのルールを抽出
     *
     * @param Collection $validateParams
     * @return void
     */
    private function extractNecessaryRules(Collection $validateParams)
    {
        return $this->rules()
            ->filter(function ($value, $ruleParamName) use ($validateParams) {
                return $validateParams->contains(function ($param, $key) use ($ruleParamName) {
                    return $ruleParamName == $param;
                });
            })
            ->toArray();
    }

    /**
     * バリデートするパラメータのエラーメッセージを抽出
     *
     * @param Collection $validateParams
     * @return void
     */
    private function extractNecessaryMessages(Collection $validateParams)
    {
        return $this->messages()
            ->filter(function ($value, $messageParamName) use ($validateParams) {
                return $validateParams->contains(function ($param, $key) use ($messageParamName) {
                    return $messageParamName == $param;
                });
            })
            ->mapWithKeys(function ($ruleAndMessageList, $paramName) {
                return collect($ruleAndMessageList)
                    ->mapWithKeys(function ($message, $rule) use ($paramName) {
                        return ["${paramName}.${rule}" => $message];
                    })
                    ->toArray();
            })
            ->toArray();
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    abstract protected  function rules();

    /**
     * 下記の形でエラーメッセージ登録
     *[
     *       'name' => [
     *           'required' => 'message',
     *           'max' => 'message'
     *       ],
     *       'email' => [
     *           'required' => 'message',
     *           'max' => 'message'
     *       ]
     *]
     *
     * @return Collection
     */
    abstract protected  function messages();
}
