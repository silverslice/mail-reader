<?php

namespace Silverslice\MailReader\Tests;

use Silverslice\MailReader\MailReader;
use Symfony\Component\Filesystem\Filesystem;

class MailReaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  MailReader */
    protected $reader;
    
    public function setUp() 
    {
        $this->reader = new MailReader(__DIR__ . '/mails/');
    }
    
    public function testGetLastMessage() 
    {
        $message = $this->reader->getLastMessage();
        
        $this->assertEquals('fromemail@mail.dev', $message->getFrom());
        $this->assertEquals('toemail@mail.dev', $message->getTo());
        $this->assertEquals('Third email', $message->getSubject());
        $this->assertContains('This is the <strong>third</strong> email', $message->getBody());
    }

    public function testGetLastMessageByIndex()
    {
        $message = $this->reader->getLastMessageByIndex(2);

        $this->assertEquals('fromemail@mail.dev', $message->getFrom());
        $this->assertEquals('toemail@mail.dev', $message->getTo());
        $this->assertEquals('First email', $message->getSubject());
        $this->assertContains('This is the <strong>first</strong> email', $message->getBody());
    }

    public function testClearMessages()
    {
        $tmpPath = __DIR__ . '/mails_tmp/';
        $reader = new MailReader($tmpPath);

        $fs = new Filesystem();
        $fs->mirror(__DIR__ . '/mails/', $tmpPath);
        
        $this->assertEquals(3, $reader->getCountOfMessages());
        $reader->clearMessages();
        $this->assertEquals(0, $reader->getCountOfMessages());

        $fs->remove($tmpPath);
    }
}
