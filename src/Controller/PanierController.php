<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ComposerRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\EtatRepository;
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


    #[Route('/api/getprod/{id}', name: 'app_api_getprod', methods: ['GET'])]
    public function getProduit($id,ProduitRepository $produitRepository): Response
    {

        $produit = $produitRepository->find($id);

        if (!$produit) {

            return new JsonResponse(['message' => 'Produit non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data= [
            'nom_produit' => $produit->getNomPro(),
            'prix_produit' => $produit->getPrixPro(),
            'image_produit' => $produit->getImgPro(),
            'description_produit' => $produit->getDescriptionPro(),
            'id_produit' => $produit->getId(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
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
                'id_composer' => $composer->getId(),
                'nom_produit' => $composer->getIdPro()->getNomPro(),
                'prix_produit' => $composer->getIdPro()->getPrixPro(),
                'quantite' => $composer->getQuantite(),
                'image_produit' => $composer->getIdPro()->getImgPro(),
                'description_produit' => $composer->getIdPro()->getDescriptionPro(),
                'id_produit' => $composer->getIdPro()->getId(),
            ];
        }
        return new JsonResponse($data, 200);
    }

    #[Route('/api/addproduitcomposer', name: 'app_api_addProduitToComposer')]
    public function addProduitToComposer(Security $security, EntityManagerInterface $entityManager,PanierRepository $panierRepository,Request $request,EtatRepository $etatRepository): Response
    {

        $data = json_decode($request->getContent());

            $code = 200;
            $user = $security->getUser();

          
            $panierUserEnCours = $panierRepository->findOneBy(
                ['user' => $user->getId(), 'etat' => '1'],
            );


            if (!$panierUserEnCours){
                $panier = New Panier();
                $panier->setIdUse($user);
                $panier->setIdEta($etatRepository->findOneById(1));
                $entityManager->persist($panier);
                $entityManager->flush();
            }
            
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


    #[Route('/api/removeproduitcomposer', name: 'app_api_removeProduitFromComposer')]
    public function removeProduitFromComposer(Security $security,ComposerRepository  $composersRepository, EntityManagerInterface $entityManager, PanierRepository $panierRepository, Request $request): Response {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['id'])) {
            return new JsonResponse(['success' => false, 'message' => 'L\'identifiant n\'a pas été fourni'], 400);
        }
    
      
        $id = $data['id'];
        $composer = $composersRepository->find($data);
   

        if (!$composer) {   
            return new JsonResponse(['success' => false, 'message' => 'L\'élément n\'existe pas'], 404);
        }
        try {
            $entityManager->remove($composer);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['success' => false, 'message' => $exception->getMessage()], 500);
        }

        return new JsonResponse(['status' => 'OK'], 200);
    }

    #[Route('/api/changequantiteproduit', name: 'app_api_changeQuantiteProduit', methods: ['POST'])]
    public function changeQuantiteProduit(Request $request, ComposerRepository $composerRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['quantite'])) {
            return new JsonResponse(['success' => false, 'message' => 'Les informations requises sont manquantes'], 400);
        }

        $idComposer = $data['id'];
        $nouvelleQuantite = $data['quantite'];

        $composer = $composerRepository->find($idComposer);

        if (!$composer) {
            return new JsonResponse(['success' => false, 'message' => 'Le produit n\'existe pas'], 404);
        }

        $composer->setQuantite($nouvelleQuantite);

        try {
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['success' => false, 'message' => $exception->getMessage()], 500);
        }

        return new JsonResponse(['success' => true, 'message' => 'La quantité du produit a été mise à jour avec succès'], 200);
    }


    #[Route('/', name: 'app_panier', methods: ['GET'])]
    public function panier(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findBy([], null, 10);
        return $this->render('panier/index.html.twig', [
            'produits'=> $produits,
        ]);
    }

    #[Route('/api/getproduit/{id_cat}/{max}/{min}', name: 'app_api_getproduitbyid', methods: ['GET'])]
    public function getProduitByCondition($id_cat,$max,$min,ProduitRepository $produitRepository): Response
    {

        $max = (float)$max  ? (float)$max : null;
        $min = (float)$min  ? (float)$min : null;
        $id_cat = (float)$id_cat  ? (float)$id_cat : null;

        if ($max === null && $min === null && $id_cat === null) {
            // Récupérer les 20 premiers produits si toutes les conditions sont nulles
            $produits = $produitRepository->findBy([], null, 20);
        } elseif ($max !== null && $min === null && $id_cat === null) {
            // Récupérer les produits dont le prix est inférieur ou égal à $max
            $produits = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.prix_pro < :max')
                ->setParameter('max', $max)
                ->getQuery()
                ->getResult();


        } elseif ($max === null && $min !== null && $id_cat === null) {
            $query = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.prix_pro >= :min')
                ->setParameter('min', $min)
                ->getQuery();
            $produits = $query->getResult();
        } elseif ($max === null && $min === null && $id_cat !== null) {
            $query = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.cat = :id_cat')
                ->setParameter('id_cat', $id_cat)
                ->getQuery();
            $produits = $query->getResult();
        } elseif ($max !== null && $min !== null && $id_cat === null) {
            $query = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.prix_pro BETWEEN :min AND :max')
                ->setParameter('min', $min)
                ->setParameter('max', $max)
                ->getQuery();
            $produits = $query->getResult();
        } elseif ($max !== null && $min === null && $id_cat !== null) {
            $query = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.cat = :id_cat')
                ->andWhere('p.prix_pro <= :max')
                ->setParameter('id_cat', $id_cat)
                ->setParameter('max', $max)
                ->getQuery();
            $produits = $query->getResult();
        }elseif ($max !== null && $min !== null && $id_cat !== null){
            $query = $produitRepository->createQueryBuilder('p')
                ->andWhere('p.cat = :id_cat')
                ->andWhere('p.prix_pro >= :min')
                ->andWhere('p.prix_pro <= :max')
                ->setParameter('id_cat', $id_cat)
                ->setParameter('min', $min)
                ->setParameter('max', $max)
                ->getQuery();
            $produits = $query->getResult();
        } else{
            dd("trombé");
        }




        $data = [];
        foreach ($produits as $produit) {
            $data[] = [
                'id_prod' => $produit->getId(),
                'nom_produit' => $produit->getNomPro(),
                'prix_produit' => $produit->getPrixPro(),
                'description' => substr($produit->getDescriptionPro(), 0, 60),
                'image_produit' => $produit->getImgPro(),
            ];
        }

        return new JsonResponse($data, 200);
    }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/api/autocomplete/{term}', name: 'autocomplete')]
    public function autocomplete($term,Request $request,EntityManagerInterface $entityManager): JsonResponse
    {

        $query = $this->entityManager->createQuery(
            'SELECT p.id, p.nom_pro AS nom_produit
            FROM App\Entity\Produit p
            WHERE p.nom_pro LIKE :term'
        )->setParameter('term', $term . '%');

        // Exécutez la requête et récupérez les résultats
        $results = $query->getResult();

        // Formatez les résultats pour qu'ils soient utilisables par l'autocomplétion
        $formattedResults = [];

        foreach ($results as $result) {
            $formattedResults[] = [
                'id' => $result['id'],
                'nom_produit' => $result['nom_produit'],
            ];
        }

        return new JsonResponse($formattedResults);
    }
}
