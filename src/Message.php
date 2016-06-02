<?php

namespace Silverslice\MailReader;

class Message
{
    protected $message;
    
    protected $body;
    
    public function __construct(\ZBateson\MailMimeParser\Message $message) 
    {
        $this->message = $message;
    }

    public function getFrom() 
    {
        return $this->message->getHeaderValue('from');
    }

    public function getTo()
    {
        return $this->message->getHeaderValue('to');
    }

    public function getSubject()
    {
        return $this->message->getHeaderValue('subject');
    }

    public function getBody() 
    {
        if ($this->body === null) {
            $htmlHandle = $this->message->getHtmlStream();

            $this->body = stream_get_contents($htmlHandle);
        }
        
        return $this->body;
    }
}