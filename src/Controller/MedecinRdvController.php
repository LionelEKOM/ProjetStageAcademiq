<?php

namespace App\Controller;

use DateTime;
use App\Entity\Rdv;
use App\Form\Rdv2Type;
use App\Entity\Dossier;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/medecin/rdv')]
class MedecinRdvController extends AbstractController
{
    #[Route('/', name: 'app_medecin_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository): Response
    {
        return $this->render('medecin_rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medecin_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rdv = new Rdv();
        $rdv->setDate(new DateTime());
        $rdv->setUser($this->getUser());
        $form = $this->createForm(Rdv2Type::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rdv);
            $entityManager->flush();

            $this->addFlash('success', 'Rendez-vous ajouté avec succes !!');
            return $this->redirectToRoute('app_medecin_rdv_index', [

            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('medecin_rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    // #[Route('/{rdv}', name: 'app_medecin_rdv_show', methods: ['GET'])]
    // public function show(Rdv $rdv): Response
    // {
    //     return $this->render('medecin_rdv/show.html.twig', [
    //         'rdv' => $rdv,
    //     ]);
    // }

    // #[Route('/{rdv}/edit', name: 'app_medecin_rdv_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(Rdv2Type::class, $rdv);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_medecin_rdv_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('medecin_rdv/edit.html.twig', [
    //         'rdv' => $rdv,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{rdv}', name: 'app_medecin_rdv_delete', methods: ['POST'])]
    // public function delete(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($rdv);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_medecin_rdv_index', [], Response::HTTP_SEE_OTHER);
    // }
}
