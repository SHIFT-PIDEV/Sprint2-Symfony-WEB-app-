<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{

    /**
     * @Route("/question/addquestion", name="add_question")
     */
    public function addquestion(Request $request): Response
    {
        $Question = new Question();
        $form = $this->createForm(QuestionType::class,$Question);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Question);

            $entityManager->flush();

            return $this->redirectToRoute('list_question');

        }

        return $this->render("question/addquestion.html.twig", [
            "form_title" => "Ajouter une question",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/question/delete_question/{idQuestion}", name="delete_question")
     */
    public function deleteQuestion(int $idQuestion): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $question = $entityManager->getRepository(Question::class)->find($idQuestion);
        $entityManager->remove($question);
        $entityManager->flush();
        return $this->redirectToRoute('list_question');
    }
    /**
     * @Route("/question/listquestion", name="list_question")
     */
    public function listQuestion(Request $request)
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->findAll();

        return $this->render('question/questions.html.twig', [
            "question" => $question,]);
    }
    /**
     * @Route("/question/edit_question/{idQuestion}", name="edit_question")
     */
    public function editQuestion(Request $request, int $idQuestion): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $Question = $entityManager->getRepository(Question::class)->find($idQuestion);
        $form = $this->createForm(QuestionType::class,$Question);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();



            $entityManager->flush();

             return $this->redirectToRoute('list_question');

        }

        return $this->render("question/edit_question.html.twig", [
            "form_title" => "Modifier une question",
            "form" => $form->createView(),
        ]);
    }
}
