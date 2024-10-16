<?php
declare(strict_types=1);


namespace App\EventSauce\MessageDecorator;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;

class WhoDecorator implements MessageDecorator
{

    public function decorate(Message $message): Message
    {
        return $message->withHeader('user', [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
        ]);
    }
}
