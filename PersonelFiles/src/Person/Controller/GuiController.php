<?php
namespace App\Person\Controller;

use App\Person\Entity\PersonManager;
use App\Person\Entity\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Person\Form\PersonType;
use App\Person\Entity\Person;
use App\Person\Service\PersonService;
use Psr\Log\LoggerInterface;

#[Route("/person")]
class GuiController extends AbstractController
{
    public function __construct(
        private PersonService $personService,
        private LoggerInterface $logger)
    {
    }

    #[Route("/add", name:"person_add", methods: ["GET", "POST"])]
    public function showForm(Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
    
        $form->handleRequest($request);
        dump($person);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personService->createPerson($person);
            $this->logger->info('Created person : '. $person->getId());

            $this->addFlash('success', 'New person was added!');
        }

        return $this->render('Person/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/all', name: 'person_all')]
    public function showAll(): Response
    {
        $people = $this->personService->getAll();

        dump($people);
        return $this->render('Person/all.html.twig', ['people' => $people]);
    }
}