<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;

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
}
