<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;

class ProjectController extends AbstractController
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
     * ProjectController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $entityManager->getRepository(Project::class);
    }

    #[Route('/projects', name: 'app_projects')]
    public function index()
    {
        $projects = $this->projectRepository->findByUser($this->getUser()->getId());
        return $this->render('project/list.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/create', name: 'create_project')]
    public function registerAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $project->setName($data->getName());

            $project->setUser($this->getUser());
            $project->setTimers([]);
            $project->setCreatedAt(new \DateTime());
            $project->setUpdatedAt(new \DateTime());

            // save the Project
            $this->updateDatabase($project);
            return $this->redirectToRoute('app_projects');
        }

        return $this->render('project/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function updateDatabase($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}