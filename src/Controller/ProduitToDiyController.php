<?php

namespace App\Controller;

use App\Entity\ProduitToDiy;
use App\Form\ProduitToDiyType;
use App\Repository\ProduitToDiyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit/to/diy')]
class ProduitToDiyController extends AbstractController
{
    #[Route('/', name: 'app_produit_to_diy_index', methods: ['GET'])]
    public function index(ProduitToDiyRepository $produitToDiyRepository): Response
    {
        return $this->render('produit_to_diy/index.html.twig', [
            'produit_to_diys' => $produitToDiyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_to_diy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produitToDiy = new ProduitToDiy();
        $form = $this->createForm(ProduitToDiyType::class, $produitToDiy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produitToDiy);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_to_diy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit_to_diy/new.html.twig', [
            'produit_to_diy' => $produitToDiy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_to_diy_show', methods: ['GET'])]
    public function show(ProduitToDiy $produitToDiy): Response
    {
        return $this->render('produit_to_diy/show.html.twig', [
            'produit_to_diy' => $produitToDiy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_to_diy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProduitToDiy $produitToDiy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitToDiyType::class, $produitToDiy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_to_diy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit_to_diy/edit.html.twig', [
            'produit_to_diy' => $produitToDiy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_to_diy_delete', methods: ['POST'])]
    public function delete(Request $request, ProduitToDiy $produitToDiy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produitToDiy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produitToDiy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_to_diy_index', [], Response::HTTP_SEE_OTHER);
    }
}
