<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\StationService;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationsController extends AbstractController
{


    public function __construct(
        private readonly StationService $stationService
    )
    {
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    #[Route('/stations')]
    public function stations(): Response
    {
        $stations = $this->stationService->findCurrent();

        return $this->json($stations->fetchAllAssociative());
    }
}
