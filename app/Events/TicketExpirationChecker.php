<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketExpirationChecker implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $expiredCount;
    public string $message;
    /**
     * Create a new event instance.
     */
    public function __construct(int $expiredCount , string $message)
    {
        $this->expiredCount = $expiredCount;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn():PrivateChannel
    {
        return new PrivateChannel('notifications');
    }

    public function broadcastAs()
    {
        return 'ticket.expiration';
    }
}
