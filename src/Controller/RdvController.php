<?php

namespace App\Controller;

use DateTime;
use App\Entity\Rdv;
use App\Form\RdvType;
use App\Entity\Dossier;
use App\Repository\RdvRepository;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('medecin/dossier/{id}/rdv')]
class RdvController extends AbstractController
{
    #[Route('/', name: 'app_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository, DossierRepository $dossierRepository): Response
    {
        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
            'dossiers' => $dossierRepository->findAll() // Récupération de tous les dossiers
        ]);
    }

    #[Route('/new', name: 'app_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Dossier $dossier): Response
    {
        $rdv = new Rdv();
        $rdv->setDate(new DateTime());
        $rdv->setUser($this->getUser());
        $rdv->setDossier($dossier);
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rdv);
            $entityManager->flush();

            $this->addFlash('success', 'Rendez-vous ajouter avec succes !!');
            return $this->redirectToRoute('app_medecin_dossier_show', [
                'id' => $dossier->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_rdv_show', methods: ['GET'])]
    // public function show(Rdv $rdv): Response
    // {
    //     $dossier = $rdv->getDossier();
    //     return $this->render('rdv/show.html.twig', [
    //         'rdv' => $rdv,
    //         'dossier' => $dossier
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_rdv_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(RdvType::class, $rdv);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('rdv/edit.html.twig', [
    //         'rdv' => $rdv,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_rdv_delete', methods: ['POST'])]
    // public function delete(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($rdv);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
    // }
}
