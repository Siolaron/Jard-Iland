<?php

namespace App\Controller;

use App\Entity\Island;
use App\Form\IslandType;
use App\Repository\IslandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IslandController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/island/show/{id}", name="app_island_show")
     */
    public function show(Island $island):Response
    {
        return $this->render('island/show.html.twig',[
            'island'=>$island
        ]);
    }
    
    /**
     * @Route("/island", name="app_island")
     */
    public function index(IslandRepository $islandRepository): Response
    {
        $island = $islandRepository->findAll();
        return $this->render('island/index.html.twig', [
            'islands' => $island,
        ]);
    }

    /**
     * @Route("/island/add", name="app_island_add")
     */
    public function add(Request $request):Response
    {
        $island = new Island();

        $form = $this->createForm(IslandType::class,$island);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($island);
            $this->em->flush();

            return $this->redirectToRoute('app_island');
        }

        return  $this->render('island/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/island/edit/{id}", name="app_island_edit")
     */
    public function edit(Request $request, Island $island):Response
    {
        $form = $this->createForm(IslandType::class,$island);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($island);
            $this->em->flush();

            return $this->redirectToRoute('app_island');
        }

        return  $this->render('island/edit.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/island/delete/{id}", name="app_island_delete")
     */
    public function delete(Island $island):Response
    {
        $this->em->remove($island);
        $this->em->flush();

        return $this->redirectToRoute('app_island');
    }
}
