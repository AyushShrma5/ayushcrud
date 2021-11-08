<?php

namespace App\Controller;
use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MainController extends AbstractController
{
   
    public function index(): Response
    {   
        $data = $this->getDoctrine()->getRepository(Crud::class)->findAll();
        //dd($data);
        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }

   
    public function create(Request $request,ValidatorInterface $validator)
    {   
        $crud = new Crud();
        $form = $this->createForm(CrudType::Class,$crud);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
            //dd($form['password']->getData());
            $plainPassword = $form['password']->getData();
            $encoded = md5($plainPassword);
            $crud->setPassword($encoded);

            //die('as');
            //$plainPassword = 'ryanpass';
            //$encoded = $encoder->encodePassword($user, $plainPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','submitted Successfully !!');

            return $this->redirectToRoute('main');

        }else{

              $errors = $validator->validate($crud);

             if (count($errors) > 0) {
        
                return $this->render('main/create.html.twig', [
                    'errors' => $errors,
                    'form' => $form->createView(),
                ]);
            }
            
            //die('23');
        }

        return $this->render('main/create.html.twig', [
            'form' => $form->createView(),
            'errors' => ''
        ]);
    }

   
    public function update(Request $request, $id)
    {   
        $crud = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $form = $this->createForm(CrudType::Class,$crud);
         $form->remove('password'); 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','updated Successfully !!');

            return $this->redirectToRoute('main');

        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function delete($id)
    {   
        $data = $this->getDoctrine()->getRepository(Crud::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','deleted Successfully !!');
        return $this->redirectToRoute('main');      
    }
}
