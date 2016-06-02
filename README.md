Test emails easily in php
============================================================

Without mailcatcher headache:)

**MailReader** stores your emails in local directory and provides convenient way to test them.

## Install

`composer require silverslice/mail-reader`

## Usage

- Copy `bin/smtp_catcher.php` to convenient folder.
- Specify folder for e-mails in `bin/smtp_catcher.php` (optional).
- Set in php.ini: `sendmail_path = /path/to/smtp_catcher.php`
- Write test:

```php

use Silverslice\MailReader\MailReader;

...

public function testGetLastMessage()
{
    $reader = new MailReader('/path/to/mails/');

    // get last sent message
    $message = $reader->getLastMessage();

    $this->assertEquals('fromemail@mail.dev', $message->getFrom());
    $this->assertEquals('toemail@mail.dev', $message->getTo());
    $this->assertEquals('Third email', $message->getSubject());
    $this->assertContains('This is the last email', $message->getBody());

    $this->assertTrue($message->hasAttachment());
    $this->assertTrue($message->hasAttachmentWithName('file1.txt'));

    // get total count of messages
    $reader->getCountOfMessages();

    // get next to the last message
    $reader->getLastMessageByIndex(1);

    // clear all messages
    $reader->clearMessages();
}
```