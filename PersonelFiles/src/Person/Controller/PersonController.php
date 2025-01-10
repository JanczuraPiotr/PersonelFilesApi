<?php
namespace App\Person\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route("/person", name:"person_controller")]
    public function index(): Response
    {
        dump($this);
        return $this->render('Person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
}