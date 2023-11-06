<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class GameReady implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gamePin;
    public $playerID;
    public $playerName;



    /**
     * @param $gamePin
     */

    /**
     * Create a new event instance.
     */

    public function __construct($gamePin, $playerID, $playerName)
    {
        $this->gamePin = $gamePin;
        $this->playerID = $playerID;
        $this->playerName = $playerName;
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
