<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/person", name="app_person")
     */
    public function index(PersonRepository $personRepository): Response
    {
        $person = $personRepository->findAll();
        return $this->render('person/index.html.twig', [
            'persons' => $person,
        ]);
    }

    /**
     * @Route("/person/show/{id}", name="app_person_show")
     */
    public function show(Person $person):Response
    {
        return $this->render('person/show.html.twig',[
           'person'=>$person
        ]);
    }

    /**
     * @Route("/person/add", name="app_person_add")
     */
    public function add(Request $request):Response
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class,$person);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($person);
            $this->em->flush();

            return $this->redirectToRoute('app_person');
        }

        return  $this->render('person/add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/person/edit/{id}", name="app_person_edit")
     */
    public function edit(Request $request, Person $person):Response
    {
        $form = $this->createForm(PersonType::class,$person);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($person);
            $this->em->flush();

            return $this->redirectToRoute('app_person');
        }

        return  $this->render('person/edit.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/person/delete/{id}", name="app_person_delete")
     */
    public function delete(Person $person):Response
    {
        $this->em->remove($person);
        $this->em->flush();

        return $this->redirectToRoute('app_person');
    }
}
