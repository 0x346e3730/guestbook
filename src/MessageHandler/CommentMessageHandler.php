<?php

namespace App\MessageHandler;

use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CommentMessageHandler implements MessageHandlerInterface
{
	private $entityManager;
	private $commentRepository;

	public function __construct(EntityManagerInterface $entityManager, CommentRepository $commentRepository)
	{
		$this->entityManager = $entityManager;
		$this->commentRepository = $commentRepository;
	}

	public function __invoke(CommentMessage $message)
	{
		$comment = $this->commentRepository->find($message->getId());
		if (!$comment) {
			return;
		}

		if (1 === $randomInt = random_int(0, 1)) {
			$comment->setState('spam');
		} else {
			$comment->setState('published');
		}

		$this->entityManager->flush();
	}
}