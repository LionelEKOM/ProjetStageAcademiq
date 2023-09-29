<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Examen;
use App\Form\ExamenType;
use App\Repository\DossierRepository;
use App\Repository\ExamenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medecin/dossier/{id}/examen')]
class ExamenController extends AbstractController
{
    #[Route('/', name: 'app_examen_index', methods: ['GET'])]
    public function index(ExamenRepository $examenRepository): Response
    {
        return $this->render('examen/index.html.twig', [
            'examens' => $examenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_examen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Dossier $dossier): Response
    {
        $examan = new Examen();
        $examan->setDossier($dossier);
        $examan->setCreatedAt(new \DateTimeImmutable());
        $examan->setUser($this->getUser());
        $form = $this->createForm(ExamenType::class, $examan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($examan);
            $entityManager->flush();

            $this->addFlash('success', 'Examen ajouté avec succes !!');
            return $this->redirectToRoute('app_medecin_dossier_show', [
                'id' => $dossier->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examen/new.html.twig', [
            'examan' => $examan,
            'form' => $form,
        ]);
    }

    #[Route('/{examen}', name: 'app_examen_show', methods: ['GET'])]
    public function show(Examen $examan): Response
    {
        return $this->render('examen/show.html.twig', [
            'examan' => $examan,
        ]);
    }

}
