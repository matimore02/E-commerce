<?php

namespace App\Controller;

use App\Repository\CatProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListProduitController extends AbstractController
{
    #[Route('/list/produit', name: 'app_list_produit')]
    public function index(CatProduitRepository $catProduitRepository): Response
    {
        $catPs = $catProduitRepository->findAll();

        return $this->render('list_produit/index.html.twig', [
            'catPs'=>$catPs,
        ]);
    }
}
