<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestedController extends AbstractController
{
    /**
     * @Route("/tested", name="app_tested")
     */
    public function index(UserRepository $userRepository): Response
    {

        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('title')
            ->add('submit',SubmitType::class)
        ;
        $form = $formBuilder->getForm();

        $users = $userRepository->findAll();

        return $this->render('tested/index.html.twig', [
            'controller_name' => 'TestedController',
            'form' => $form->createView(),
            'recipeList' => $users
        ]);
    }
}
