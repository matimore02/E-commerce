<?php

namespace App\Controller;

use App\Entity\Commenter;
use App\Form\Commenter1Type;
use App\Repository\CommenterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
#[Route('/commenter')]
class CommenterController extends AbstractController
{
    #[Route('/', name: 'app_commenter_index', methods: ['GET'])]
    public function index(CommenterRepository $commenterRepository): Response
    {
        return $this->render('commenter/index.html.twig', [
            'commenters' => $commenterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commenter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $commenter = new Commenter();

        $form = $this->createForm(Commenter1Type::class, $commenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commenter->setDateCommentaire(new DateTime());
            $commenter->setUser($security->getUser());

            
            $entityManager->persist($commenter);
            $entityManager->flush();

            return $this->redirectToRoute('app_commenter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commenter/new.html.twig', [
            'commenter' => $commenter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commenter_show', methods: ['GET'])]
    public function show(Commenter $commenter): Response
    {
        return $this->render('commenter/show.html.twig', [
            'commenter' => $commenter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commenter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commenter $commenter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commenter1Type::class, $commenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commenter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commenter/edit.html.twig', [
            'commenter' => $commenter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commenter_delete', methods: ['POST'])]
    public function delete(Request $request, Commenter $commenter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commenter->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commenter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commenter_index', [], Response::HTTP_SEE_OTHER);
    }
}
