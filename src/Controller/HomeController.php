<?php

namespace App\Controller;

use App\Repository\IslandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(IslandRepository $islandRepository): Response
    {
        $islands = $islandRepository->findBy(['person'=>null]);
        return $this->render('home/index.html.twig', [
            'title' => 'Jard eLand',
            'islands'=>$islands
        ]);
    }
}
