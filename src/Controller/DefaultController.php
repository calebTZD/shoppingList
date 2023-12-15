<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class DefaultController extends AbstractController
{

    #[Route('/', methods: ['GET'])]
    public function inital(): Response
    {
        return $this->redirectToRoute('home');
    }
}