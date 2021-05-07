<?php

namespace App\Controller;

use App\Entity\Technology;
use App\Form\TechnologyType;
use App\Repository\TechnologyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologyController extends AbstractController
{
    /**
     * @Route("/technology", name="technology")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $technology = new Technology();
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($technology);
            $entityManager->flush();
            return $this->redirectToRoute('technology_all');
        }
        return $this->render('technology/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/technology/all", name="technology_all")
     */
    public function all(TechnologyRepository $technologyRepository)
    {
        dd($technologyRepository->findAll());
    }
}
