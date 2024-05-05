<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\GameInterface;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    protected GameInterface $service;
    public function __construct(GameInterface $service)
    {
        $this->service = $service;
    }

    public function start(GameRequest $request)
    {
        $numbers = $request->numbers;
        return $this->service->startGame($numbers);
    }
}
