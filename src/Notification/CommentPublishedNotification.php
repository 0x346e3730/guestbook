<?php

namespace App\Notification;

use App\Entity\Comment;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class CommentPublishedNotification extends Notification implements EmailNotificationInterface
{
	private $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;

		parent::__construct('Your comment has been published');
	}

	public function asEmailMessage(Recipient $recipient, string $transport = null): ?EmailMessage
	{
		$message = EmailMessage::fromNotification($this, $recipient, $transport);
		$message->getMessage()
			->htmlTemplate('emails/comment_published.html.twig')
			->context(['comment' => $this->comment]);

		return $message;
	}
}