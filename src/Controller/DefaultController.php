<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(Request $request,ProduitRepository $produitRepository,Security $security): Response
    {
        $catId = $request->query->get('cat');
        if (!$catId){
            $produits = $produitRepository->findBy([], null, 20);
        }else{
            $produits = $produitRepository->findBy(['cat'=>$catId], null, 20);
        }



        return $this->render('default/index.html.twig', [
            'produits'=> $produits,
        ]);
    }
}
