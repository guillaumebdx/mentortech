<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\Lesson;
use App\Entity\Part;
use App\Entity\Screencast;
use App\Form\ContentFinalType;
use App\Form\ContentType;
use App\Form\LessonType;
use App\Form\PartType;
use App\Repository\CorrectionRepository;
use App\Repository\LessonRepository;
use App\Repository\PostedSolutionRepository;
use App\Repository\StatusLessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lesson", name="lesson_")
 * Route secured in security.yaml
 */
class LessonAdminController extends AbstractController
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
        return $this->render('lesson_admin/index.html.twig', [
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
        return $this->render('lesson_admin/content.html.twig', [
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
        $screencast = new Screencast();
        $screencast2 = new Screencast();
        $screencast3 = new Screencast();
        $part->addScreencast($screencast);
        $part->addScreencast($screencast2);
        $part->addScreencast($screencast3);
        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($part->getScreencasts() as $screencast) {
                if ($screencast->getTitle() === null) {
                    $part->removeScreencast($screencast);
                }
            }
            $entityManager->persist($part);
            $entityManager->flush();
            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'lesson_part_new'
                : 'lesson_final_admin';
            return $this->redirectToRoute($nextAction, ['id' => $content->getId()]);
        }
        return $this->render('lesson_admin/part.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/content/{id}/final", name="final_admin")
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
            $this->addFlash('green', 'La le??on a bien ??t?? post??e');
            return $this->redirectToRoute('home');
        }
        return $this->render('lesson_admin/final.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/solution/all", name="solution_all")
     */
    public function status(PostedSolutionRepository $postedSolutionRepository)
    {
        return $this->render('lesson_admin/status_all.html.twig', [
            'posted_solutions' => $postedSolutionRepository->findBy(['isValid' => false]),
        ]);
    }

    /**
     * @Route("/all", name="all")
     */
    public function all(LessonRepository $lessonRepository)
    {
        return $this->render('lesson_admin/all.html.twig', [
            'lessons' => $lessonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/update-intro/{id}", name="update_intro")
     */
    public function updateIntro(Content $content, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($content);
            $entityManager->flush();
            $this->addFlash('green', 'Intro mise ?? jour');
            return $this->redirectToRoute('lesson_all');
        }

        return $this->render('component/generic_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update-final/{id}", name="update_final")
     */
    public function updateFinal(Content $content, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ContentFinalType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($content);
            $entityManager->flush();
            $this->addFlash('green', 'Final mis ?? jour');
            return $this->redirectToRoute('lesson_all');
        }

        return $this->render('component/generic_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update-part/{id}", name="update_part")
     */
    public function updatePart(Part $part, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($part);
            $entityManager->flush();
            $this->addFlash('green', 'Partie mise ?? jour');
            return $this->redirectToRoute('lesson_all');
        }
        return $this->render('component/generic_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function news(CorrectionRepository $correctionRepository,
                         StatusLessonRepository $statusLessonRepository)
    {
        return $this->render('lesson_admin/news.html.twig', [
            'corrections' => $correctionRepository->findBy([], ['id' => 'desc']),
            'status_lessons' => $statusLessonRepository->findBy([], ['id' => 'desc']),

        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Lesson $lesson, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($lesson);
        $entityManager->flush();
        return $this->redirectToRoute('lesson_all');
    }
}
