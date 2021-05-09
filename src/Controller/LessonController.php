<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Lesson;
use App\Entity\Part;
use App\Form\ContentFinalType;
use App\Form\ContentType;
use App\Form\LessonType;
use App\Form\PartType;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lesson", name="lesson_")
 */
class LessonController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($lesson->getPrograms() as $program) {
                $program->addLesson($lesson);
                $entityManager->persist($program);
            }
            $entityManager->persist($lesson);
            $entityManager->flush();
            return $this->redirectToRoute('lesson_content_new', ['id' => $lesson->getId()]);
        }
        return $this->render('lesson/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/content/new", name="content_new")
     */
    public function newContent(Lesson $lesson,
                            Request $request,
                            EntityManagerInterface $entityManager): Response
    {
        $content = new Content();
        $content->setLesson($lesson);
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($content);
            $entityManager->flush();
            return $this->redirectToRoute('lesson_part_new', ['id' => $content->getId()]);
        }
        return $this->render('lesson/content.html.twig', [
            'form' => $form->createView(),
            'lesson' => $lesson,
        ]);
    }

    /**
     * @Route("/content/{id}/part/new", name="part_new")
     */
    public function newPart(Content $content,
                            Request $request,
                            EntityManagerInterface $entityManager)
    {
        $part = new Part();
        $part->setContent($content);
        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($part);
            $entityManager->flush();
            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'lesson_part_new'
                : 'lesson_final';
            return $this->redirectToRoute($nextAction, ['id' => $content->getId()]);
        }
        return $this->render('lesson/part.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/content/{id}/final", name="final")
     */
    public function final(Content $content,
                          Request $request,
                          EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ContentFinalType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($content);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('lesson/final.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/all", name="all")
     */
    public function all(LessonRepository $lessonRepository)
    {
        dd($lessonRepository->findAll());
    }
}
