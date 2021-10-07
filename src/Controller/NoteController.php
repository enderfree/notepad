<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Note;

/**
 * @Route("/notes")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="notes")
     */
    public function notes(): Response
    {
		$user = $this->getUser();
		return $this->render('note/notes.html.twig', [
			'notes' => $this->getDoctrine()->getRepository(note::class)->findAll(),
			'user' => $user,
        ]);
    }
	
	/**
	 * @Route("/create", name="createNote")
	 */
	public function create(Request $request):Response
	{
		$form = $this->createFormBuilder()
					->add('title')
					->add('content')
					->add('Submit', SubmitType::class, [
						'attr' => [
							'class' => 'btn btn-success float rigth'
						]
					])
					->getForm();
					
		$form->handleRequest($request);
		
		if($form->isSubmitted()) {
			$formData = $form->getData();
			
			$note = new Note();
			$note->setTitle($formData['title']);
			$note->setContent($formData['content']);
			$note->setUsr($this->getUser());
			
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($note);
			$em->flush();
			
			return $this->redirect($this->generateUrl('notes'));
		}
		
		$user = $this->getUser();
		return $this->render('note/createNote.html.twig', [
            'form' => $form->createView(),
			'user' => $user,
		]);
	}
	
	/**
     * @Route("/id/{id}")
     */
	public function display(Request $request): Response
	{
		$noteId = $request->get('id');
		$user = $this->getUser();
		return $this->render('note/note.html.twig', [
			'note' => $this->getDoctrine()->getRepository(note::class)->find($noteId),
			'user' => $user,
        ]);
	}
}
