<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Usr;

class UsrController extends AbstractController
{
    /**
	 * @Route("/register", name="app_register")
	 */
	public function register(Request $request, UserPasswordEncoderInterface $encoder)
	{
		$form = $this->createFormBuilder()
					->add('email')
					->add('password', RepeatedType::class, [
						'type' =>PasswordType::class, 
						'invalid_message' => 'the passwords do not match',
						'required' => true, 
						'first_options' => ['label' => 'password'],
						'second_options' => ['label' => 'confirm password']
					])
					->add('register', SubmitType::class, [
						'attr' => [
							'class' => 'btn btn-success float rigth'
						]
					])
					->getForm();
					
		$form->handleRequest($request);
		
		if($form->isSubmitted()) {
			$formData = $form->getData();
			
			$usr = new Usr();
			$usr->setEmail($formData['email']);
			$usr->setPassword(
				$encoder->encodePassword($usr, $formData['password'])
			);
			
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($usr);
			$em->flush();
			
			return $this->redirect($this->generateUrl('app_login'));
		}
					
		return $this->render('usr/index.html.twig', [
            'form' => $form->createView()
        ]);
	}
}
