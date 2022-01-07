<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FarmPages extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('dashboard.html.twig');
    }

    /**
     * @Route("/new_cattle", name="new_cattle")
     */
    public function new_cattle(): Response
    {
        return $this->render('new_cattle.html.twig');
    }

    /**
     * @Route("/list_cattle", name="list_cattle")
     */
    public function list_cattle(): Response
    {
        return $this->render('list_cattle.html.twig');
    }

    /**
     * @Route("/list_slaughters", name="list_slaughters")
     */
    public function list_slaughters(): Response
    {
        return $this->render('list_slaughters.html.twig');
    }

}