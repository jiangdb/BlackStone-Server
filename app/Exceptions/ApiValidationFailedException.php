<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;

class ApiValidationFailedException extends Exception
{
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function response()
    {
        return Response::json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $this->validator->errors(),
        ], 400);
    }
}
