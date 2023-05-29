<?php

namespace App\Controller;

use App\Entity\Timer;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TimerController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $projectRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $timerRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $entityManager->getRepository(Project::class);
        $this->timerRepository = $entityManager->getRepository(Timer::class);
    }

    #[Route('/projects/{id}/timers', name: 'timer')]
    public function createTimer(Request $request, int $id)
    {
        $project = $this->projectRepository->find($id);

        $timer = new Timer();
        $timer->setName($request->get('name'));
        $timer->setUser($this->getUser());
        $timer->setProject($project);
        $timer->setStartedAt(new \DateTime());
        $timer->setCreated(new \DateTime());
        $timer->setUpdated(new \DateTime());
        $this->updateDatabase($timer);

        // Serialize object into Json format
        $jsonContent = $this->serializeObject($timer);

        return $jsonContent;

    }

    #[Route('/project/timers/active', name: 'active_timer')]
    public function runningTimer()
    {
        $timer = $this->timerRepository->findRunningTimer($this->getUser()->getId());

        $jsonContent = $this->serializeObject($timer);

        return $jsonContent;
    }

    #[Route('/projects/{id}/timers/stop', name: 'stop_running')]
    public function stopRunningTimer()
    {
        $timer = $this->timerRepository->findRunningTimer($this->getUser()->getId());

        if ($timer) {
            $timer->setStoppedAt(new \DateTime());
            $this->updateDatabase($timer);
        }

        // Serialize object into Json format
        $jsonContent = $this->serializeObject($timer);

        return $jsonContent;
    }

    public function serializeObject($object)
    {
        $encoders = [new JsonEncoder()]; 
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        // Serialize your object in Json
        $jsonObject = $serializer->serialize($object, 'json', [
            'circular_reference_handler' => function ($o) {
                return $o->getId();
            }
        ]);
        
        // For instance, return a Response with encoded Json
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }


    public function updateDatabase($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}