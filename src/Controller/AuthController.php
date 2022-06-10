<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * Class AuthController
 *
 * @package App\Controller
 *
 * @Route("/auth", name="auth_")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param Request $request
     *
     */
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface      $entityManager,
        UserAuthenticatorInterface  $userAuthenticator,
        AppCustomAuthenticator      $appCustomAuthenticator
    )
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            try {
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $exception) {
                dd($exception);
            }
        } else {
            return new JsonResponse($form->getErrors(true, true)->current()->getMessage(), 400);
        }

        $userAuthenticator->authenticateUser($user, $appCustomAuthenticator, $request);

        return new JsonResponse('AAvdsagsdgs');
    }
//
//    /**
//     * @Route("/logout", name="app_logout")
//     */
//    public function logout(): void
//    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//    }
}