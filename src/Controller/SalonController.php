<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Cars;
use App\Form\CarrosType;


class SalonController extends AbstractController 

// PAGE SALON INDEX
{
    #[Route('/salon', name: 'app_salon')]
    public function index(Request $request, CarsRepository $repository, EntityManagerInterface $em): Response
    {
        $allcars = $repository->findAll();

        return $this->render('salon/index.html.twig', [
            'carsTable' => $allcars,
        ]);
    }

// TEMPLATE FOR THE SLUG 
    #[Route(path: '/salon/{slug}-{id}', name: 'app_salon_show', requirements : ['id'=> '\d+', 'slug'=> '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, carsRepository $repository ) : Response
    {
        $carsid = $repository->find($id);
                        
        if($carsid->getSlug() !== $slug){
            return $this->redirectToRoute('app_salon_show', ['id' => $carsid->getId(), 'slug' => $carsid->getSlug()]);
        }

        return $this->render('salon/show.html.twig', [ 'carSolo' => $carsid
        ]);

    }

// TEMPLATE FOR THE EDIT

#[Route(path : '/salon/update/{id}', name : 'app_salon_edit')]
public function edit(Cars $cars, Request $request, EntityManagerInterface $em) : Response{
    $form = $this->createForm(CarrosType::class, $cars);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $em->flush();
        return $this->redirectToRoute('app_salon_show', ['id' => $cars->getId(), 'slug' => $cars->getSlug()]);
    }

    return $this->render('salon/edit.html.twig',[
        'carSolo' => $cars,
        'monForm' => $form
    ]);
}

// TEMPLATE FOR THE CREATION

#[Route(path : '/salon/create', name : 'app_salon_create')]
public function create(Request $request, EntityManagerInterface $em) : Response{
    $cars=new Cars();
    $form = $this->createForm(CarrosType::class, $cars);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $em->persist($cars);
        $em->flush();
        $this->addFlash('success', 'The car ' . $cars->getModel() . 'has been created');
        return $this->redirectToRoute('app_salon');
    }
    return $this->render('salon/create.html.twig',[
        // une methode, une page
       'form_create' => $form
    ]);
}

// TEMPLATE FOR THE DELETION

     #[Route(path : '/salon/delete/{id}', name : 'app_salon_delete')]
     public function delete(Cars $cars, EntityManagerInterface $em) : Response{
        $titre=$cars ->getModel();
        $em->remove($cars);
        $em->flush();
        $this->addFlash('info', 'The Model' . $titre . 'has been removed from the database');
        return $this->redirectToRoute('app_salon');
        }

}  

