<?php

namespace App\Controller;

use App\Entity\CatProduit;
use App\Form\CatProduitType;
use App\Repository\CatProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cat/produit')]
class CatProduitController extends AbstractController
{
    #[Route('/', name: 'app_cat_produit_index', methods: ['GET'])]
    public function index(CatProduitRepository $catProduitRepository): Response
    {
        return $this->render('cat_produit/index.html.twig', [
            'cat_produits' => $catProduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cat_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $catProduit = new CatProduit();
        $form = $this->createForm(CatProduitType::class, $catProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($catProduit);
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_produit/new.html.twig', [
            'cat_produit' => $catProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cat_produit_show', methods: ['GET'])]
    public function show(CatProduit $catProduit): Response
    {
        return $this->render('cat_produit/show.html.twig', [
            'cat_produit' => $catProduit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cat_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CatProduit $catProduit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CatProduitType::class, $catProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cat_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_produit/edit.html.twig', [
            'cat_produit' => $catProduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cat_produit_delete', methods: ['POST'])]
    public function delete(Request $request, CatProduit $catProduit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catProduit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($catProduit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cat_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
