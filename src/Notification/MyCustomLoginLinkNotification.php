<?php

declare(strict_types=1);

namespace App\Notification;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkDetails;

class MyCustomLoginLinkNotification extends Notification implements EmailNotificationInterface
{
    public function __construct(
        private readonly LoginLinkDetails $loginLinkDetails,
    ) {
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        return new EmailMessage((new TemplatedEmail())
            ->to($recipient->getEmail())
            ->from('no_reply@localhost')
            ->subject('hello')
            ->context([
                'url' => $this->loginLinkDetails->getUrl(),
                'expiresAt' => $this->loginLinkDetails->getExpiresAt(),
            ])
            ->textTemplate('security/mail.txt.twig'))
        ;
    }
}