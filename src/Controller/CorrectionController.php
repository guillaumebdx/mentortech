<?php

namespace App\Controller;

use App\Entity\Correction;
use App\Entity\PostedSolution;
use App\Entity\User;
use App\Form\ContentFinalType;
use App\Form\CorrectionType;
use App\Form\MentorType;
use App\Form\PostedSolutionType;
use App\Repository\CorrectionRepository;
use App\Repository\PostedSolutionRepository;
use App\Repository\StatusLessonRepository;
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
            $this->addFlash('green', 'Votre correction a bien été prise en compte. Vous avez gagné 10 crédit !');
            return $this->redirectToRoute('home');
        }
        return $this->render('correction/apply.html.twig', [
            'postedSolution' => $postedSolution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mentor/{id}", name="mentor")
     */
    public function mentor(PostedSolution $postedSolution,
                           Request $request,
                           EntityManagerInterface $entityManager,
                           StatusLessonRepository $statusLessonRepository)
    {
        $form = $this->createForm(MentorType::class, $postedSolution);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postedSolution);
            if ($postedSolution->getIsValid()) {
                $statusLesson = $statusLessonRepository->findOneBy(['user' => $postedSolution->getUser(), 'lesson' => $postedSolution->getLesson()]);
                $statusLesson->setIsValid(true);
                $entityManager->persist($statusLesson);
            }
            $entityManager->flush();
            $this->addFlash('green', 'Correction réalisée');
            return $this->redirectToRoute('correction_todo');
        }
        return $this->render('correction/mentor.html.twig', [
            'form' => $form->createView(),
            'postedSolution' => $postedSolution,
        ]);;
    }

    /**
     * @Route("/self", name="self")
     */
    public function self()
    {
        return $this->render('correction/self.html.twig');
    }

    /**
     * @Route("/update-solution/{id}", name="update_solution")
     */
    public function updateSolution(PostedSolution $postedSolution,
                                   Request $request,
                                   EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PostedSolutionType::class, $postedSolution);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postedSolution);
            $entityManager->flush();
            return $this->redirectToRoute('correction_self');
        }
        return $this->render('correction/update_solution.html.twig', [
            'form' => $form->createView(),
            'posted_solution' => $postedSolution,
        ]);
    }
}
