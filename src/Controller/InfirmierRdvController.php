<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Form\Rdv1Type;
use App\Repository\RdvRepository;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/infirmier/rdv')]
class InfirmierRdvController extends AbstractController
{
    #[Route('/', name: 'app_infirmier_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository, DossierRepository $dossierRepository): Response
    {
        return $this->render('infirmier_rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
            'dossiers' => $dossierRepository->findAll() // Récupération de tous les dossiers
        ]);
    }

    // #[Route('/new', name: 'app_infirmier_rdv_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $rdv = new Rdv();
    //     $form = $this->createForm(Rdv1Type::class, $rdv);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($rdv);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_infirmier_rdv_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('infirmier_rdv/new.html.twig', [
    //         'rdv' => $rdv,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_infirmier_rdv_show', methods: ['GET'])]
    public function show(Rdv $rdv): Response
    {
        return $this->render('infirmier_rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_infirmier_rdv_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(Rdv1Type::class, $rdv);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_infirmier_rdv_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('infirmier_rdv/edit.html.twig', [
    //         'rdv' => $rdv,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_infirmier_rdv_delete', methods: ['POST'])]
    // public function delete(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($rdv);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_infirmier_rdv_index', [], Response::HTTP_SEE_OTHER);
    // }
}
