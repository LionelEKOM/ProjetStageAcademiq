<?php

namespace App\Controller;

use App\Entity\Dossier;
use DateTime;
use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;
use App\Repository\DossierRepository;
use App\Repository\OrdonnanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/medecin/dossier/{id}/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/', name: 'app_ordonnance_index', methods: ['GET'])]
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findBy([], ['CreatedAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Dossier $dossier): Response
    {
        $ordonnance = new Ordonnance();
        $ordonnance->setCreatedAt(new \DateTimeImmutable());
        $ordonnance->setTitle("Ordonnance Médicale");
        $ordonnance->setDebut(new DateTime());
        $ordonnance->setUser($this->getUser());
        $ordonnance->setDossier($dossier);
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ordonnance);
            $entityManager->flush();

            $this->addFlash('success', 'Ordonnance crée avec succes !!');
            return $this->redirectToRoute('app_medecin_dossier_show', [
                'id' => $dossier->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }

    #[Route('/{ordonnance}', name: 'app_ordonnance_show', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_ordonnance_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Ordonnance $ordonnance, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(OrdonnanceType::class, $ordonnance);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('ordonnance/edit.html.twig', [
    //         'ordonnance' => $ordonnance,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_ordonnance_delete', methods: ['POST'])]
    // public function delete(Request $request, Ordonnance $ordonnance, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($ordonnance);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    // }
}
