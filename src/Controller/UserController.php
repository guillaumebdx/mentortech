<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request,
                          EntityManagerInterface $entityManager,
                          ProgramRepository $programRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('green', 'Votre compte a bien été modifié');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'programs' => $programRepository->findAll(),
        ]);
    }
}
