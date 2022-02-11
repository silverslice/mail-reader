<?php

namespace Silverslice\MailReader;

class Message
{
    protected $message;
    
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
        return $this->message->getHtmlContent();
    }

    public function hasAttachment()
    {
        $parts = $this->message->getAllAttachmentParts();
        foreach ($parts as $part) {
            $filename = $part->getHeaderParameter('Content-Type', 'name');
            if ($filename !== null) {
                return true;
            }
        }
        
        return false;
    }

    public function hasAttachmentWithName($name)
    {
        $parts = $this->message->getAllAttachmentParts();
        foreach ($parts as $part) {
            $filename = $part->getHeaderParameter('Content-Type', 'name');
            if ($filename == $name) {
                return true;
            }
        }

        return false;
    }
}
