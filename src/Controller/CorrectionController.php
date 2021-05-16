<?php

namespace App\Controller;

use App\Entity\Correction;
use App\Entity\PostedSolution;
use App\Entity\User;
use App\Form\CorrectionType;
use App\Repository\CorrectionRepository;
use App\Repository\PostedSolutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/correction", name="correction_")
 */
class CorrectionController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function todo(CorrectionRepository $correctionRepository,
                         PostedSolutionRepository $postedSolutionRepository): Response
    {
        $postedSolutions = $postedSolutionRepository->findAll();
        $postedSolutionsToReview = [];
        foreach ($postedSolutions as $postedSolution) {
            if (
                $postedSolutionRepository->findBy(['user' => $this->getUser(), 'lesson' => $postedSolution->getLesson()])
                && $postedSolution->getUser() !== $this->getUser()
                && !$correctionRepository->findBy(['reviewer' => $this->getUser(), 'postedSolution' => $postedSolution])
                ) {
                $postedSolutionsToReview[] = $postedSolution;
            }
        }
        return $this->render('correction/index.html.twig', [
            'postedSolutions' => $this->isGranted(User::ADMIN) ? $postedSolutionRepository->findAll() : $postedSolutionsToReview,
        ]);
    }

    /**
     * @Route("/apply/{id}", name="apply")
     */
    public function apply(PostedSolution $postedSolution, Request $request, EntityManagerInterface $entityManager)
    {
        $correction = new Correction();
        $correction->setReviewer($this->getUser());
        $correction->setPostedSolution($postedSolution);
        $form = $this->createForm(CorrectionType::class, $correction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($correction);
            $this->getUser()->setCredit($this->getUser()->getCredit() + 10);
            $entityManager->flush();
            $this->addFlash('green', 'Votre correction a bien été prise en compte. Vous avez gagné 1 crédit !');
            return $this->redirectToRoute('home');
        }
        return $this->render('correction/apply.html.twig', [
            'postedSolution' => $postedSolution,
            'form' => $form->createView(),
        ]);
    }
}
