<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Dossier;
use App\Form\Consultation1Type;
use App\Repository\ConsultationRepository;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/infirmier/consultation')]
class InfirmierConsultationController extends AbstractController
{
    #[Route('/', name: 'app_infirmier_consultation_index', methods: ['GET'])]
    public function index(ConsultationRepository $consultationRepository, DossierRepository $dossierRepository): Response
    {
        return $this->render('infirmier_consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
            'dossiers' => $dossierRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_infirmier_consultation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultation();
        $consultation->setCreatedAt(new \DatetimeImmutable());
        $consultation->setUser($this->getUser());
        // $consultation->setDossier($dossier);
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout d\'une nouvelle consultation');
            return $this->redirectToRoute('app_infirmier_consultation_show', [
            ], Response::HTTP_SEE_OTHER);
        }


        return $this->render('infirmier_consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/', name: 'app_infirmier_consultation_show', methods: ['GET'])]
    public function show(Consultation $consultation): Response
    {
        return $this->render('infirmier_consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route('/edit', name: 'app_infirmier_consultation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Consultation1Type::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_infirmier_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infirmier_consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    // #[Route('/', name: 'app_infirmier_consultation_delete', methods: ['POST'])]
    // public function delete(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($consultation);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_infirmier_consultation_index', [], Response::HTTP_SEE_OTHER);
    // }
}
