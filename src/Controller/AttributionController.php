<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Form\AttributionType;
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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $attribution = new Attribution();
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($attribution);
            $entityManager->flush();
        }
        return $this->render('attribution/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
