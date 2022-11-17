<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;

trait ClientError
{
    public function clientError($result = null, $httpStatus = Response::HTTP_BAD_REQUEST)
    {
        $this->code = $this->code ?? $httpStatus;
        $this->message = $this->message ?? Response::$statusTexts[$this->code];
        $this->result = $result;

        return response()->json($this->build(), $httpStatus);
    }

    public function badRequest($result = null)
    {
        $this->code = $this->code ?? Response::HTTP_BAD_REQUEST;
        $this->message = $this->message ?? Response::$statusTexts[Response::HTTP_BAD_REQUEST];
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_BAD_REQUEST);
    }

    public function unauthorized($result = null)
    {
        $this->code = $this->code ?? Response::HTTP_UNAUTHORIZED;
        $this->message = $this->message ?? Response::$statusTexts[Response::HTTP_UNAUTHORIZED];
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_UNAUTHORIZED);
    }

    public function forbidden($result = null)
    {
        $this->code = $this->code ?? Response::HTTP_FORBIDDEN;
        $this->message = $this->message ?? Response::$statusTexts[Response::HTTP_FORBIDDEN];
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_FORBIDDEN);
    }

    public function notFound($result = null)
    {
        $this->code = $this->code ?? Response::HTTP_NOT_FOUND;
        $this->message = $this->message ?? Response::$statusTexts[Response::HTTP_NOT_FOUND];
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_NOT_FOUND);
    }
    
}
