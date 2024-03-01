<?php

namespace App\Controller;

use App\Entity\Diy;
use App\Form\DiyType;
use App\Repository\DiyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diy')]
class DiyController extends AbstractController
{
    #[Route('/', name: 'app_diy_index', methods: ['GET'])]
    public function index(DiyRepository $diyRepository): Response
    {
        return $this->render('diy/index.html.twig', [
            'diys' => $diyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_diy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diy = new Diy();
        $form = $this->createForm(DiyType::class, $diy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($diy);
            $entityManager->flush();

            return $this->redirectToRoute('app_diy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('diy/new.html.twig', [
            'diy' => $diy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diy_show', methods: ['GET'])]
    public function show(Diy $diy): Response
    {
        return $this->render('diy/show.html.twig', [
            'diy' => $diy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Diy $diy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DiyType::class, $diy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_diy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('diy/edit.html.twig', [
            'diy' => $diy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diy_delete', methods: ['POST'])]
    public function delete(Request $request, Diy $diy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($diy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_diy_index', [], Response::HTTP_SEE_OTHER);
    }
}
