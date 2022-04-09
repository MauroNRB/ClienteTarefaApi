<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Task;
use App\Form\ClientType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-07
 */
class ClientController extends BaseController
{
    public function __construct()
    {
        $this->entity = new Client();
        $this->formType = ClientType::class;
        $this->path = 'client';
        $this->pluralEntity = 'clients';
        $this->entityType = Client::class;
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
            /** @var Client $entity */
            foreach($entities as $entity) {
                $tasks = array();
                /** @var Task $task */
                foreach($entity->getTasks() as $task) {
                    $tasks[] = array(
                        'id' => $task->getId(),
                        'conclusionAt' => $task->getConclusionAt(),
                        'expirationAt' => $task->getExpirationAt(),
                        'url' => $this->generateUrl('task_show_api', array('id' => $task->getId()))
                    );
                }

                $arr[] = array(
                    'id' => $entity->getId(),
                    'name' => $entity->getName(),
                    'email' => $entity->getEmail(),
                    'genero' => $entity->getGenreLabel(),
                    'phone' => $entity->getPhone(),
                    'tasks' => $tasks,
                    'url' => $this->generateUrl('client_show_api', array('id' => $entity->getId()))
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

            $tasks = array();
            /** @var Task $task */
            foreach($this->entity->getTasks() as $task) {
                $tasks[] = array(
                    'id' => $task->getId(),
                    'conclusionAt' => $task->getConclusionAt(),
                    'expirationAt' => $task->getExpirationAt(),
                    'url' => $this->generateUrl('task_show_api', array('id' => $task->getId()))
                );
            }

            $arr = array(
                'id' => $this->entity->getId(),
                'name' => $this->entity->getName(),
                'email' => $this->entity->getEmail(),
                'genero' => $this->entity->getGenreLabel(),
                'phone' => $this->entity->getPhone(),
                'tasks' => $tasks,
                'url' => $this->generateUrl('client_show_api', array('id' => $this->entity->getId()))
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
            $this->entity->setName($arr['name']);
            $this->entity->setEmail($arr['email']);
            $this->entity->setPhone($arr['phone']);
            $this->entity->setPassword($arr['password']);
            $this->entity->setGenre($arr['genre']);

            $em = $this->getDoctrine()->getManager();
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
            $this->entity->setName($arr['name']);
            $this->entity->setEmail($arr['email']);
            $this->entity->setPhone($arr['phone']);
            $this->entity->setPassword($arr['password']);
            $this->entity->setGenre($arr['genre']);

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
