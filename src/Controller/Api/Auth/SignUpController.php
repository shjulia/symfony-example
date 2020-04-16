<?php

declare(strict_types=1);

namespace App\Controller\Api\Auth;

use App\Model\User\UseCase\Signup;
use Monolog\ErrorHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignUpController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $errors;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, LoggerInterface $error)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->errors = $error;
    }

    /**
     * @Route("/auth/signup", name="auth.signup", methods={"POST"})
     * @param Request $request
     * @param Signup\Request\Handler $handler
     * @return Response
     */
    public function request(Request $request, Signup\Request\Handler $handler): Response
    {
        $command = $this->serializer->deserialize($request->getContent(),  Signup\Request\Command::class, 'json');

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $handler->handle($command);

        return $this->json([], 201);
    }
}