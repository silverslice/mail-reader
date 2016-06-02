<?php

namespace Silverslice\MailReader\Tests;

use Silverslice\MailReader\Exception;
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

    public function testLastMessageHasAttachment()
    {
        $message = $this->reader->getLastMessage();

        $this->assertTrue($message->hasAttachment());
        $this->assertTrue($message->hasAttachmentWithName('file1.txt'));
        $this->assertTrue($message->hasAttachmentWithName('file2.txt'));
        $this->assertFalse($message->hasAttachmentWithName('test.txt'));

        $message2 = $this->reader->getLastMessageByIndex(1);
        $this->assertFalse($message2->hasAttachment());
    }

    /**
     * @expectedException Exception
     */
    public function testMessageNotFound()
    {
        $this->reader->getLastMessageByIndex(10);
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
