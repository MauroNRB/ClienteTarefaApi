<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-04
 */
class LoginController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        $error = false;
        if ($request->isMethod('POST')) {
            if (
                $request->request->get('username') == $this->getParameter('username')
                && $request->request->get('password') == $this->getParameter('password')
            ) {
                if (
                    $request->getSession()->get('username') == $this->getParameter('username')
                    && $request->getSession()->get('password') == $this->getParameter('password')
                ) {
                    return $this->redirectToRoute('index');
                }

                if ($request->getSession() instanceof Session) {
                    $session = $request->getSession();
                } else {
                    $session = new Session();
                    $session->start();
                }

                // set and get session attributes
                $session->set('username', $request->request->get('username'));
                $session->set('password', $request->request->get('password'));
                $request->setSession($session);

                return $this->redirectToRoute('index');
            }

            $session = new Session();
            $request->setSession($session);
            $error = 'Login incorreto';
        }

        return $this->render('login/index.html.twig', array(
            'error' => $error,
        ));
    }
}
