<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    use clientError, ServerError;

    protected static $instance;
    protected $code;
    protected $message;
    protected $result;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function resetInstance()
    {
        self::$instance = null;
    }

    protected function time()
    {
        return round((microtime(true) - LARAVEL_START) * 1000);
    }

    public function status($code)
    {
        $this->code = $code;

        return $this;
    }

    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    public function result($result)
    {
        $this->result = $result;

        return $this;
    }

    public function build()
    {
        return [
            'rc' => $this->code,
            'message' => $this->message,
            'result' => $this->result,
            'time' => static::time(),
        ];
    }

    public function create($code, $message, $result = null)
    {
        return $this->status($code)->message($message)->result($result)->build();
    }

    public function success($result = null)
    {
        $this->code = $this->code ?? StatusCode::SUCCESS;
        $this->message = $this->message ?? 'Successful.';
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_OK);
    }

    public function created($result = null)
    {
        $this->code = $this->code ?? StatusCode::CREATED;
        $this->message = $this->message ?? 'Successful.';
        $this->result = $result;

        return response()->json($this->build(), Response::HTTP_CREATED);
    }
}
