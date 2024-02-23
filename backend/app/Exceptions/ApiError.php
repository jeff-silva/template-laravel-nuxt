<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ApiError extends \Exception
{
  public function __construct($message='', $code=500, $fields=[], \Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
    $this->fields = $fields;
  }

  public function render(): Response
  {
    return response([
      'code' => $this->code,
      'message' => $this->message,
      'fields' => $this->fields,
    ], $this->code);
  }
}
