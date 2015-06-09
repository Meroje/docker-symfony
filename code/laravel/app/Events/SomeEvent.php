<?php

namespace App\Events;

use App\Foo;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SomeEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var Foo
     */
    public $foo;

    /**
     * Create a new event instance.
     *
     * @param Foo $foo
     *
     * @return void
     */
    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['foochannel'];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['uuid' => $this->foo->getUuid(), 'text' => $this->foo->getText()];
    }
}
