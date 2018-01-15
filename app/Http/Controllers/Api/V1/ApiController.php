<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\TestException;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiValidationFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

abstract class ApiController extends Controller
{
    const STATUS_ERROR      = 'error';
    const STATUS_SUCCESS    = 'success';

    const CODE_SUCCESS      = 200;
    const CODE_BAD_REQUEST  = 400;
    const CODE_NOT_ALLOWED  = 403;
    const CODE_NOT_FOUND    = 404;

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            Log::error('Validation fails: '. $validator->errors());
            Log::error('request: '. print_r($request->all(), true));
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
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function response(array $data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @return mixed
     */
    protected function responseBadRequestWithMessage($message = 'Bad Request')
    {
        return $this->setStatusCode(self::CODE_BAD_REQUEST)
            ->response(
                [
                    'status' => self::STATUS_ERROR,
                    'message' => $message
                ]
            );
    }

    /**
     * @return mixed
     */
    protected function responseNotAllowedWithMessage($message = 'Not allowed')
    {
        return $this->setStatusCode(self::CODE_NOT_ALLOWED)
            ->response(
                [
                    'status' => self::STATUS_ERROR,
                    'message' => $message
                ]
            );
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

    protected function responseErrorWithMessage($message)
    {
        return $this->setStatusCode(self::CODE_SUCCESS)
            ->response([
                    'status' => self::STATUS_ERROR,
                    'message' => $message,
                ]
            );
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
