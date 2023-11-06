<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class GameStart implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gamePin;
    public $spotifyToken;
    public $refreshToken;

    /**
     * @param $gamePin
     * @param $spotifyToken
     * @param $refreshToken
     */
    public function __construct($gamePin, $spotifyToken, $refreshToken)
    {
        $this->gamePin = $gamePin;
        $this->spotifyToken = $spotifyToken;
        $this->refreshToken = $refreshToken;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('game.' . $this->gamePin),
        ];
    }


}
