<?php
declare(strict_types=1);


namespace App\EventSauce\MessageDecorator;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use Illuminate\Http\Request;

class HowDecorator implements MessageDecorator
{
    public function __construct(
        private readonly Request $request,
    ) { }
    public function decorate(Message $message): Message
    {
        return $message->withHeader('server', [
                'IP' => $this->request->server('REMOTE_ADDR'),
                'PATH' => $this->request->server('PATH_INFO'),
                'METHOD' => $this->request->server('REQUEST_METHOD'),
                'REFERER' => $this->request->server('HTTP_REFERER'),
            ]);
    }
}
