<?php

namespace App\Controller;

use App\Entity\Antecedent;
use App\Entity\Dossier;
use App\Form\Antecedent1Type;
use App\Repository\AntecedentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medecin/dossier/{id}/antecedent')]
class AntecedentController extends AbstractController
{
    #[Route('/', name: 'app_antecedent_index', methods: ['GET'])]
    public function index(AntecedentRepository $antecedentRepository): Response
    {
        return $this->render('antecedent/index.html.twig', [
            'antecedents' => $antecedentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_antecedent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Dossier $dossier): Response
    {
        $antecedent = new Antecedent();
        $antecedent->setCreatedAt(new \DateTimeImmutable());
        $antecedent->setUser($this->getUser());
        $antecedent->setDossier($dossier);
        $form = $this->createForm(Antecedent1Type::class, $antecedent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($antecedent);
            $entityManager->flush();

            $this->addFlash('success', 'Nouvel Antecedent Ajouté avec succes !!');
            return $this->redirectToRoute('app_medecin_dossier_show', [
                'id' => $dossier->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('antecedent/new.html.twig', [
            'antecedent' => $antecedent,
            'form' => $form,
        ]);
    }

}
