<?php

namespace App\Controller;

use App\Entity\Construction;
use App\Form\ConstructionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConstructionController extends AbstractController
{
    /**
     * @Route("/construction", name="app_construction")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $constructions = $entityManager->getRepository(Construction::class)->findAll();
        return $this->render('construction/index.html.twig', [
            'constructions' => $constructions,
        ]);
    }

    /**
     * @Route("/construction/add", name="app_construction_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager):Response
    {
        $construction = new Construction();

        $form = $this->createForm(ConstructionType::class,$construction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($construction);
            $entityManager->flush();

            return $this->redirectToRoute('app_construction');
        }

        return  $this->render('construction/add.html.twig',[
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/construction/edit/{id}", name="app_construction_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, Construction $construction):Response
    {
        $form = $this->createForm(ConstructionType::class,$construction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($construction);
            $entityManager->flush();

            return $this->redirectToRoute('app_construction');
        }

        return  $this->render('construction/edit.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/construction/delete/{id}", name="app_construction_delete")
     */
    public function delete(EntityManagerInterface $entityManager, Construction $construction):Response
    {
        $entityManager->remove($construction);
        $entityManager->flush();

        return $this->redirectToRoute('app_construction');
    }
}
