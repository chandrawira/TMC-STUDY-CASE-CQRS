<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;

trait ServerError
{
    public function serverError($result = null, $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->code = $this->code ?? $httpStatus;
        $this->message = $this->message ?? Response::$statusTexts[$this->code];
        $this->result = $result;

        return response()->json($this->build(), $httpStatus);
    }

    public function internalServerError($result = null)
    {
        $this->code = $this->code ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $this->message = $this->message ?? Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function serviceUnavailable($result = null)
    {
        $this->code = $this->code ?? StatusCode::SERVICE_UNAVAILABLE;
        $this->message = $this->message ?? __('Oops! Something went wrong, please try again later.');
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
