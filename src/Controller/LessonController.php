<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Part;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lesson", name="lesson_")
 */
class LessonController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="show")
     */
    public function index(Lesson $lesson): Response
    {
        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * @Route("/part/{id}", name="part")
     */
    public function part(Part $part)
    {
        return $this->render('lesson/part.html.twig', [
            'part'   => $part,
            'lesson' => $part->getContent()->getLesson(),
        ]);
    }

    /**
     * @Route("/final/{id}", name="final")
     */
    public function final(Lesson $lesson)
    {
        return $this->render('lesson/final.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
