<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Form\AttributionType;
use App\Repository\AttributionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttributionController extends AbstractController
{
    /**
     * @Route("/admin/attribution", name="attribution")
     */
    public function index(Request $request,
                          EntityManagerInterface $entityManager,
                          AttributionRepository $attributionRepository): Response
    {
        $attribution = new Attribution();
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hasProgram = $attributionRepository->findOneBy(['user' => $attribution->getUser(), 'program' => $attribution->getProgram()]);
            if (!$hasProgram) {
                $entityManager->persist($attribution);
                $entityManager->flush();
                $this->addFlash('green', 'Le programe a bien été attribué');
            } else {
                $this->addFlash('red', 'Cet utilisateur a déjà ce programe');
            }
        }
        return $this->render('attribution/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
