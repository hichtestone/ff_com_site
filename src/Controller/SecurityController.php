<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
    #[Route("/login123", "app_login123")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
		 echo '<pre>';
		var_export($this->getUser());
		 echo '</pre>';
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();
            foreach ($roles as $role)
            {
                if ($role == 'ROLE_SUPER_ADMIN') {

                    return $this->redirectToRoute('home');
                }
                elseif($role == 'ROLE_USER'){

                    return $this->redirectToRoute('home');                     }
            }

        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
