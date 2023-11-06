<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class GameJoin implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gamePin;
    public $playerName;

    public $playerID;

    /**
     * Create a new event instance.
     */
    public function __construct($gamePin, $playerName, $playerID)
    {
        $this->playerName = $playerName;
        $this->gamePin = $gamePin;
        $this->playerID = $playerID;
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

    public function broadcastWith()
    {
        return [
            "playerName" => $this->playerName,
            "playerID" => $this->playerID,
        ];
    }

}
