<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-07
 */
class BaseController extends AbstractController
{
    protected $entity;
    protected $formType;
    protected $path;
    protected $pluralEntity;
    protected $entityType;

    public function indexAction(Request $request)
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($this->entityType);
        $entities = $repository->findAll();

        return $this->render("{$this->path}/index.html.twig", array(
            $this->pluralEntity => $entities
        ));
    }

    public function createAction(Request $request)
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }
        $form = $this->createForm($this->formType, $this->entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($this->entity);
            $em->flush();

            return $this->redirectToRoute($this->path);
        }

        return $this->render("{$this->path}/create.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    public function updateAction(Request $request)
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }
        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));
        $form = $this->createForm($this->formType, $this->entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->entity);
            $em->flush();

            return $this->redirectToRoute($this->path);
        }

        return $this->render("{$this->path}/update.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction(Request $request)
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }

        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));

        $em->remove($this->entity);
        $em->flush();

        return $this->redirectToRoute($this->path);
    }

    public function showAction(Request $request)
    {
        $return = $this->loginValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }

        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));

        return $this->render("{$this->path}/show.html.twig", array(
            $this->path => $this->entity,
        ));
    }

    protected function isTokenValidAction(Request $request)
    {
        if ($request->headers->get('token') != $this->getParameter('token')) {
            return new JsonResponse(array(
                'msg' => 'Token Invalido'
            ), 401);
        }
    }

    protected function loginValidAction(Request $request)
    {
        if (
            $request->getSession()->get('username') != $this->getParameter('username')
            || $request->getSession()->get('password') != $this->getParameter('password')
        ) {
            return $this->redirectToRoute('login');
        }
    }

    public function deleteApiAction(Request $request)
    {
        $return = $this->isTokenValidAction($request);
        if ($return instanceof Response) {
            return $return;
        }

        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));

        $em->remove($this->entity);
        $em->flush();

        return new JsonResponse(array('msg' => 'Deletado com Sucesso'), 200);
    }
}
