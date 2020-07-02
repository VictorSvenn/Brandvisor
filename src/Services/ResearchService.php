<?php

namespace App\Services;

use App\Repository\InitiativeRepository;
use App\Repository\EnterpriseRepository;

class ResearchService
{
    /**
     * @var InitiativeRepository
     */
    private $InitiativeRepository;

    public function __construct(InitiativeRepository $initiativeRepository)
    {
        $this->InitiativeRepository = $initiativeRepository;
    }
}
