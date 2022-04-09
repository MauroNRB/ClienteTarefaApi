<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-07
 */
class TaskController extends BaseController
{
    public function __construct()
    {
        $this->entity = new Task();
        $this->formType = TaskType::class;
        $this->path = 'task';
        $this->pluralEntity = 'tasks';
        $this->entityType = Task::class;
    }

    public function createAction(Request $request):Response
    {
        $this->loginValidAction($request);
        $form = $this->createForm($this->formType, $this->entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Client::class);
            /** @var Client $client */
            $client = $repository->find($request->request->all()['task']['client']);
            $this->entity->setClient($client);

            $em->persist($this->entity);
            $em->flush();

            return $this->redirectToRoute($this->path);
        }

        return $this->render("{$this->path}/create.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    public function indexApiAction(Request $request)
    {
        try {
            $return = $this->isTokenValidAction($request);
            if ($return instanceof Response) {
                return $return;
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository($this->entityType);
            $entities = $repository->findAll();

            $arr = array();
            /** @var Task $entity */
            foreach ($entities as $entity) {
                $arr[] = array(
                    'id' => $entity->getId(),
                    'conclusionAt' => $entity->getConclusionAt(),
                    'expirationAt' => $entity->getExpirationAt(),
                    'client' => array(
                        'id' => $entity->getClient()->getId(),
                        'name' => $entity->getClient()->getName(),
                        'email' => $entity->getClient()->getEmail(),
                        'phone' => $entity->getClient()->getPhone(),
                        'genero' => $entity->getClient()->getGenreLabel(),
                        'url' => $this->generateUrl('client_show_api', array('id' => $entity->getClient()->getId()))
                    ),
                    'url' => $this->generateUrl('task_show_api', array('id' => $entity->getId()))
                );
            }

            return new JsonResponse($arr, 200);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function showApiAction(Request $request)
    {
        try {
            $return = $this->isTokenValidAction($request);
            if ($return instanceof Response) {
                return $return;
            }

            $em = $this->getDoctrine()->getManager();
            $this->entity = $em->find($this->entityType, $request->get('id'));

            $arr = array(
                'id' => $this->entity->getId(),
                'conclusionAt' => $this->entity->getConclusionAt(),
                'expirationAt' => $this->entity->getExpirationAt(),
                'client' => array(
                    'id' => $this->entity->getClient()->getId(),
                    'name' => $this->entity->getClient()->getName(),
                    'email' => $this->entity->getClient()->getEmail(),
                    'phone' => $this->entity->getClient()->getPhone(),
                    'genero' => $this->entity->getClient()->getGenreLabel(),
                    'url' => $this->generateUrl('client_show_api', array('id' => $this->entity->getClient()->getId()))
                ),
                'url' => $this->generateUrl('task_show_api', array('id' => $this->entity->getId()))
            );

            return new JsonResponse($arr, 200);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function createApiAction(Request $request)
    {
        try {
            $return = $this->isTokenValidAction($request);
            if ($return instanceof Response) {
                return $return;
            }

            $arr = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            $this->entity->setDescription($arr['description']);
            $this->entity->setExpirationAt(\DateTimeImmutable::createFromFormat("Y-m-d", $arr['expirationAt']));
            $this->entity->setConclusionAt(\DateTimeImmutable::createFromFormat("Y-m-d", $arr['conclusionAt']));
            $this->entity->setClient($em->find(Client::class, $arr['client']));

            $em->persist($this->entity);
            $em->flush();

            return new JsonResponse(array('msg' => 'Criado com Sucesso'), 201);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function updateApiAction(Request $request)
    {
        try {
            $return = $this->isTokenValidAction($request);
            if ($return instanceof Response) {
                return $return;
            }

            $em = $this->getDoctrine()->getManager();
            $this->entity = $em->find($this->entityType, $request->get('id'));

            $arr = json_decode($request->getContent(), true);

            $this->entity->setDescription($arr['description']);
            $this->entity->setExpirationAt(\DateTimeImmutable::createFromFormat("Y-m-d", $arr['expirationAt']));
            $this->entity->setConclusionAt(\DateTimeImmutable::createFromFormat("Y-m-d", $arr['conclusionAt']));
            $this->entity->setClient($em->find(Client::class, $arr['client']));

            $em->persist($this->entity);
            $em->flush();

            return new JsonResponse(array('msg' => 'Atualizado com Sucesso'), 201);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }
}
