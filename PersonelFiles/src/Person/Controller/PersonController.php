<?php
namespace App\Person\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Person\Service\PersonService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Person\Entity\Person;
use App\Person\Form\PersonType;
use Psr\Log\LoggerInterface;

class PersonController extends AbstractController
{

    public function __construct(
        private PersonService $personService, 
        private LoggerInterface $logger)
    {

    }

    #[Route("/person", name:"person_index")]
    public function index(): Response
    {
        return $this->render('Person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    #[Route("/person", name:"person_create", methods: ["POST"])]
    public function createPerson(Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        dump($person);
        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personService->createPerson($person);
            $this->logger->info('Created person : '. $person->getId());

            $this->addFlash('success', 'New person was added!');
            return $this->redirectToRoute('/person');
        }

        return $this->render('Person/addPerson.html.twig', [
            'form' => $form->createView(),
        ]);


        // $this->personService->addPerson($request->request->get('name'), $request->request->get('age'));

        // return new Response('Person added successfully');
    }

    #[Route("/api/person/{id}", name:"api_person_get", methods: ["GET"])]
    public function apiGetPerson(int $id, EntityManagerInterface $entityManager): Response
    {
        $person = $this->personService->getById($id);
        dump($person);

        if (!$person) {
            return new JsonResponse(['status' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $person->getId(),
            'name' => $person->getName(),
            'surname' => $person->getSurname(),
            'personalId' => $person->getPersonalId(),
        ], Response::HTTP_OK);
    }
    // #[Route("/api/person", name:"api_person_post", methods: ["GET"])]
    // public function apiGetPerson(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     // $this->personService->addPerson($request->request->get('name'), $request->request->get('age'));

    //     return new JsonResponse(['status' => 'Person added successfully'], Response::HTTP_OK);
    // }

    #[Route("/api/person", name:"api_person_post", methods: ["POST"])]
    public function apiPostPerson(Request $request, EntityManagerInterface $entityManager): Response
    {
        // $this->personService->addPerson($request->request->get('name'), $request->request->get('age'));

        return new JsonResponse(['status' => 'Person added successfully'], Response::HTTP_CREATED);
    }
}