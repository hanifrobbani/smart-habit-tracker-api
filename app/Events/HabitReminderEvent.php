<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HabitReminderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $userId;
    public $habitName;
    public $message;


    /**
     * Create a new event instance.
     */
    public function __construct($userId, $habitName)
    {
        $this->userId = $userId;
        $this->habitName = $habitName;
        $this->message = "Don't forget to do your '{$habitName}'!";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [new PrivateChannel("user.{$this->userId}")];
    }


    public function broadcastAs()
    {
        return 'habit.reminder';
    }
}
