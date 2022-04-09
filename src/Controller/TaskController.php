<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Task;
use App\Form\TaskType;
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
}
