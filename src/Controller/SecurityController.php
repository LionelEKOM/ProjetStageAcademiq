<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('app_home');
        // }

        if ($this->getUser()) {

            $this->addFlash('danger', 'Désolé mais vous etes deja connecté !!' );
             // Récupérer les rôles de l'utilisateur
        $roles = $this->getUser()->getRoles();

        // Vérifier le rôle et rediriger en fonction
        if (in_array('ROLE_MEDECIN', $roles, true)) {
            return $this->redirectToRoute('app_medecin_dossier_index');
        } elseif (in_array('ROLE_INFIRMIER', $roles, true)) {
            return $this->redirectToRoute('app_infirmier_consultation_index');
        } elseif (in_array('ROLE_ADMIN', $roles, true)) {
            return $this->redirectToRoute('app_admin_user_index');
        } else {
            // Redirection par défaut si le rôle n'est pas reconnu
            return $this->redirectToRoute('app_home');
        }
            }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->addFlash('success', 'Bienvenue ! Vous êtes maintenant connecté.');
    
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
