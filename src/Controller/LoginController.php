<?php
// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     */
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            // Vérifiez si le nom d'utilisateur et le mot de passe correspondent à un client ou un administrateur
            // Cela peut se faire en vérifiant la base de données ou toute autre méthode d'authentification.
            if ($username === 'admin' && $password === 'admin') {
                return $this->redirectToRoute('app_admin');
            //} elseif ($username === 'client' && $password === 'clientpassword') {
                //return $this->redirectToRoute('app_index');
            } else {
                // Vous pouvez ajouter un message d'erreur si les identifiants sont incorrects.
                $this->addFlash('error', 'Nom d\'utilisateur ou mot de passe incorrect');
            }
        }

        return $this->render('login/login.html.twig');
    }
}
