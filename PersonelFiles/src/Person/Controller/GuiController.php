<?php
namespace App\Person\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Person\Form\PersonType;
use App\Person\Entity\Person;
use App\Person\Service\PersonService;


class GuiController extends AbstractController
{
    private PersonService $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    #[Route("/person/form", name:"person_form", methods: ["GET", "POST"])]
    public function showForm(Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
    
        $form->handleRequest($request);
        dump($person);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personService->createPerson($person);

            $this->addFlash('success', 'New person was added!');
            return $this->redirectToRoute('person_index');
        }
        \dump($form);
        return $this->render('Person/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}