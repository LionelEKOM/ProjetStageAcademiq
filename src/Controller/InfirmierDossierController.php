<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\Dossier2Type;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/infirmier/dossier')]
class InfirmierDossierController extends AbstractController
{
    #[Route('/', name: 'app_infirmier_dossier_index', methods: ['GET'])]
    public function index(DossierRepository $dossierRepository): Response
    {
        return $this->render('infirmier_dossier/index.html.twig', [
            'dossiers' => $dossierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_infirmier_dossier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dossier = new Dossier();
        $dossier->setCreatedAt(new \DateTimeImmutable());
        $dossier->setClinique('Clinique le CEDICLIM');
        $dossier->setUsers($this->getUser());
        $form = $this->createForm(Dossier2Type::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossier);
            $entityManager->flush();
            
            $this->addFlash('success', 'Dossier créer avec succes !!');
            return $this->redirectToRoute('app_infirmier_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infirmier_dossier/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_infirmier_dossier_show', methods: ['GET'])]
    public function show(Dossier $dossier): Response
    {
        $rdvs = $dossier->getRdv();
        $consultations = $dossier->getConsultations();
        $examens = $dossier->getExamens();
        $antecedents = $dossier->getAntecedents();
        $ordonnances = $dossier->getOrdonnances();
        return $this->render('infirmier_dossier/show.html.twig', [
            'dossier' => $dossier,
            'rdvs' => $rdvs,
            'consultations' => $consultations,
            'examens' => $examens,
            'antecedents' => $antecedents,
            'ordonnances' => $ordonnances

        ]);
    }

    #[Route('/{id}/edit', name: 'app_infirmier_dossier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Dossier2Type::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('info', 'Dossier édité avec succes !!');
            return $this->redirectToRoute('app_infirmier_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infirmier_dossier/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_infirmier_dossier_delete', methods: ['POST'])]
    public function delete(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dossier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_infirmier_dossier_index', [], Response::HTTP_SEE_OTHER);
    }
}
