<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ComposerRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/api/byuser', name: 'app_api_getpanier')]
    public function index(Security $security, ComposerRepository  $composersRepository,PanierRepository $panierRepository): Response
    {
        $id_user = $security->getUser();

        $panierUserEnCours = $panierRepository->findBy(
            ['user' => $id_user->getId(), 'etat' => '1'],

        );

        $composers = $composersRepository->findBy(
            ['panier' => $panierUserEnCours]
        );

        $data = [];
        foreach ($composers as $composer) {
            $data[] = [
                'nom_produit' => $composer->getIdPro()->getNomPro(),
                'quantite' => $composer->getQuantite(),
            ];
        }
        return new JsonResponse($data, 200);
    }

    #[Route('/api/addproduitcomposer', name: 'app_api_addProduitToComposer')]
    public function addProduitToComposer(Security $security, EntityManagerInterface $entityManager,PanierRepository $panierRepository,Request $request): Response
    {

        $data = json_decode($request->getContent());

            $code = 200;
            $id_user = $security->getUser();


            $panierUserEnCours = $panierRepository->findOneBy(
                ['user' => $id_user->getId(), 'etat' => '1'],
            );

            $produit = $entityManager->getRepository(Produit::class)->find($data->produit);

            $composer = new Composer;
            $composer->setQuantite($data->quantite);
            $composer->setIdPro($produit);
            $composer->setIdPan($panierUserEnCours);

        try {
            $entityManager->persist($composer);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['success' => false, 'message' => $exception->getMessage()], 500);
        }
            return new JsonResponse(['status' => 'OK'], $code);




    }
}
