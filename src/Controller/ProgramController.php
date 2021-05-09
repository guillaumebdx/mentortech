<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/program", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();
            return $this->redirectToRoute('program_all');
        }
        return $this->render('program/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/all", name="all")
     */
    public function all(ProgramRepository $programRepository)
    {
        return $this->render('program/all.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Program $program, ProgramRepository $programRepository)
    {
        return $this->render('program/show.html.twig', [
            'program' => $programRepository->find($program),
        ]);
    }
}
