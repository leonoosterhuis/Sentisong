<?php

namespace App\Events;

use App\Models\RoundFillForm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class GameNewRound implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gamePin;

    public RoundFillForm $roundFillForm;

    /**
     * @param $gamePin
     * @param RoundFillForm $roundFillForm
     */
    public function __construct($gamePin, RoundFillForm $roundFillForm)
    {
        $this->gamePin = $gamePin;
        $this->roundFillForm = $roundFillForm;
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
