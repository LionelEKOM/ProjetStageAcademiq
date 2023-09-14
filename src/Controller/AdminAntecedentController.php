<?php

namespace App\Controller;

use App\Entity\Antecedent;
use App\Form\AntecedentType;
use App\Repository\AntecedentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/antecedent')]
class AdminAntecedentController extends AbstractController
{
    #[Route('/', name: 'app_admin_antecedent_index', methods: ['GET'])]
    public function index(AntecedentRepository $antecedentRepository): Response
    {
        return $this->render('admin_antecedent/index.html.twig', [
            'antecedents' => $antecedentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_antecedent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $antecedent = new Antecedent();
        $form = $this->createForm(AntecedentType::class, $antecedent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($antecedent);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_antecedent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_antecedent/new.html.twig', [
            'antecedent' => $antecedent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_antecedent_show', methods: ['GET'])]
    public function show(Antecedent $antecedent): Response
    {
        return $this->render('admin_antecedent/show.html.twig', [
            'antecedent' => $antecedent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_antecedent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Antecedent $antecedent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AntecedentType::class, $antecedent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_antecedent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_antecedent/edit.html.twig', [
            'antecedent' => $antecedent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_antecedent_delete', methods: ['POST'])]
    public function delete(Request $request, Antecedent $antecedent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$antecedent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($antecedent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_antecedent_index', [], Response::HTTP_SEE_OTHER);
    }
}
