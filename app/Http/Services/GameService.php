<?php

namespace App\Http\Services;

use App\Http\Interfaces\GameInterface;
use App\Models\Game;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class GameService implements GameInterface
{
    public function startGame(string $numbers): JsonResponse
    {
        $client = new Client(['base_uri' => 'http://bac_go_1:8070']);
        $userId = auth()->user()->id;

        $result = $client->request('POST', '/results', ['form_params' => [
            'numbers'       =>  $numbers,
            'userId'        =>  $userId
        ]])->getBody()
        ->getContents();

        $normal_result = json_decode($result, true);

        $game = Game::whereUserId($userId)
                ->whereIsEnded(false)
                ->first();

        if ($normal_result['bulls'] === GameInterface::MAX_COUNT_BULLS) {
            $game->is_ended = true;
            $game->save();

            return response()->json('Congratulations! You\'ve won!');
        } else {
            return response()->json([
                'bulls' =>  $normal_result['bulls'],
                'cows'  =>  $normal_result['cows']
            ]);
        }
    }
}
