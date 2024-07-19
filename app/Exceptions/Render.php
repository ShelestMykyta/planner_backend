<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait Render
{
    public function render(Request $request): Response
    {
        return response([
            "message" => $this->getMessage(),
        ], $this->getCode());
    }
}
