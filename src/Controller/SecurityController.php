<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

class SecurityController extends AbstractController
{
    #[Route('/login_check', name: 'login_check')]
    public function check(): never
    {
        throw new \LogicException('This code should never be reached.');
    }

    #[Route('/login', name: 'login')]
    public function requestLoginLink(
        LoginLinkHandlerInterface $loginLinkHandler,
        UserRepository $userRepository,
        NotifierInterface $notifier,
        Request $request,
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);

            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

            $notification = new LoginLinkNotification(
                $loginLinkDetails,
                'Welcome to my website',
            );
            $recipient = new Recipient($user->getEmail());
            $notifier->send($notification, $recipient);

            return $this->render('security/login_link_sent.html.twig');
        }

        return $this->render('security/login.html.twig');
    }
}