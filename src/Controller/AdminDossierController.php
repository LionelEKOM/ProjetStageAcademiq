<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\DossierType;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dossier')]
class AdminDossierController extends AbstractController
{
    #[Route('/', name: 'app_admin_dossier_index', methods: ['GET'])]
    public function index(DossierRepository $dossierRepository): Response
    {
        return $this->render('admin_dossier/index.html.twig', [
            'dossiers' => $dossierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_dossier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dossier = new Dossier();
        $dossier->setClinique("Centre de Santé CEDICLIM");
        $dossier->setCreatedAt(new \DateTimeImmutable());
        $dossier->setUsers($this->getUser());
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dossier);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_dossier/new.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dossier_show', methods: ['GET'])]
    public function show(Dossier $dossier): Response
    {
        return $this->render('admin_dossier/show.html.twig', [
            'dossier' => $dossier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_dossier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_dossier/edit.html.twig', [
            'dossier' => $dossier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dossier_delete', methods: ['POST'])]
    public function delete(Request $request, Dossier $dossier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dossier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dossier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_dossier_index', [], Response::HTTP_SEE_OTHER);
    }
}
