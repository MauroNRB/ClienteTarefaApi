<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-02
 */
class MainController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        if (
            $request->getSession()->get('username') == $this->getParameter('username')
            && $request->getSession()->get('password') == $this->getParameter('password')
        ) {
            $number = random_int(0, 100);

            return $this->render('index.html.twig', array(
                'number' => $number,
            ));
        } else {
            return $this->redirectToRoute('login');
        }
    }
}