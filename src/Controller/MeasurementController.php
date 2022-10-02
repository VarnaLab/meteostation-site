<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/measurements')]
class MeasurementController extends AbstractController
{
    #[Route('', name: 'measurement_create', methods: ['post'])]
    public function createMeasurement(Request $request, Connection $conn): Response
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $stationId = $data['end_device_ids']['device_id'] ?? throw new \JsonException('No device ID provided');
            $timestamp = $data['received_at'] ?? null;
            $value = $data['uplink_message']['decoded_payload']['data'] ?? throw new \JsonException('No measurement provided');
        } catch (\JsonException $e) {
            throw new UnprocessableEntityHttpException('Invalid json provided');
        }

        $stmt = $conn->prepare(<<<SQL
                INSERT INTO station_data
                (station_id, value, created_at)
                values
                (:id, :value, :created)
                on conflict do nothing
            SQL
        );


        if (!array_is_list($value)) {
            $value = [$value];
        }

        try {
            foreach ($value as $item) {
                $stmt->executeStatement([
                    'id' => $stationId,
                    'value' => json_encode($item, JSON_THROW_ON_ERROR),
                    'created' => (new \DateTimeImmutable($timestamp ?? 'now'))->format('c'),
                ]);
            }

            return $this->json(['status' => 'OK'], 201);
        } catch (Exception\ForeignKeyConstraintViolationException $e) {
            return $this->json(['error' => 'Station not registered'], 422);
        } catch (Exception $e) {
            //TODO: Handling
            throw $e;
        }

        throw new InvalidArgumentException('Invalid format provided');
    }
}
