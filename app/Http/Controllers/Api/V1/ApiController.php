<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\TestException;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiValidationFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

abstract class ApiController extends Controller
{
    const STATUS_ERROR      = 'error';
    const STATUS_SUCCESS    = 'success';

    const CODE_SUCCESS   = 200;
    const CODE_NOT_FOUND = 404;

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new ApiValidationFailedException($validator);
        }
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return ApiController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string $message
     * @return mixed
     */
    protected function responseNotFoundWithMessage($message = 'Not found')
    {
        return $this->setStatusCode(self::CODE_NOT_FOUND)
            ->response(
                [
                'status' => self::STATUS_ERROR,
                'message' => $message
                ]
            );
    }

    /**
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function response(array $data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseSuccessWithMessage($message = 'Success')
    {
        return $this->setStatusCode(self::CODE_SUCCESS)
            ->response([
                    'status'  => self::STATUS_SUCCESS,
                    'message' => $message,
                ]);
    }


    protected function responseSuccess()
    {
        return $this->setStatusCode(self::CODE_SUCCESS)
            ->response(['status' => self::STATUS_SUCCESS]
            );
    }

    protected function responseSuccessWithExtrasAndMessage(array $extras = [], $message = null)
    {
        $result = [
            'status' => self::STATUS_SUCCESS,
        ];
        if (isset($message)) {
            $result['message'] = $message;
        }

        return $this->setStatusCode(self::CODE_SUCCESS)
            ->response($result + $extras);
    }
}
