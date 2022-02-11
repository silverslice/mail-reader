<?php

namespace Silverslice\MailReader;

use ZBateson\MailMimeParser\MailMimeParser;

class MailReader
{
    protected $mailPath;

    public function __construct($mailPath)
    {
        $this->mailPath = rtrim($mailPath, '/');
    }

    public function getLastMessageByIndex($index): Message
    {
        $file = $this->getLastFileByIndex($index);
        if (!$file) {
            throw new MailReaderException('Message not found');
        }

        $parser = new MailMimeParser();
        $handle = fopen($this->mailPath . '/' . $file, 'r');
        $message = $parser->parse($handle, true);

        return new Message($message);
    }

    public function getLastMessage()
    {
        return $this->getLastMessageByIndex(0);
    }

    public function getCountOfMessages()
    {
        return count(glob($this->mailPath . '/*.eml'));
    }

    public function clearMessages()
    {
        foreach (glob($this->mailPath . '/*.eml') as $filename) {
            unlink($filename);
        }
    }

    protected function getLastFileByIndex($index)
    {
        $files = scandir($this->mailPath, SCANDIR_SORT_DESCENDING);

        return $files[$index] ?? false;
    }
}
