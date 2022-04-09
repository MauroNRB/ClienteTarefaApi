<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-02
 */
class MainController extends BaseController
{
    public function indexAction(Request $request): Response
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }

        return $this->render('index.html.twig');
    }
}