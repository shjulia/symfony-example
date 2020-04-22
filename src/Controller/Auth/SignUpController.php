<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\User\UseCase\Signup;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/signup", name="auth.signup")
     * @param Request $request
     * @param Signup\Request\Handler $handler
     * @return Response
     */
    public function request(Request $request, Signup\Request\Handler $handler): Response
    {
        $command = new Signup\Request\Command();

        $form = $this->createForm(Signup\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email.');
                return $this->redirectToRoute('home');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/auth/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/signup/{token}", name="auth.signup.confirm")
     * @param string $token
     * @param Signup\Confirm\ByToken\Handler $handler
     * @return Response
     */
    public function confirm(string $token, Signup\Confirm\ByToken\Handler $handler): Response
    {
        $command = new Signup\Confirm\ByToken\Command($token);

        try {
            $handler->handle($command);
            $this->addFlash('success', 'Email is successfully confirmed');
            return $this->redirectToRoute('home');
        } catch (\DomainException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('home');
        }
    }
}