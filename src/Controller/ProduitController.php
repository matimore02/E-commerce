<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de Produit
        $produit = new Produit();
    
        // Création du formulaire associé à l'entité Produit
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
    
        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du fichier uploadé
            $brochureFile = $form->get('img_pro')->getData();
    
            // Traitement du fichier s'il est présent
            if ($brochureFile) {
                // Génération d'un nom de fichier unique
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();
    
                // Déplacement du fichier vers le répertoire d'upload
                try {
                    $brochureFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    var_dump($e->getMessage());
                }
    
                // Attribution du nouveau nom de fichier à l'entité Produit
                $produit->setImgPro($newFilename);
    
                // Persiste l'entité avec le nouveau fichier
                $entityManager->persist($produit);
                $entityManager->flush();
    
                // Redirection vers une autre route après le traitement du formulaire
                return $this->redirectToRoute('app_produit_index');
            }
        }
    
        // Si le formulaire n'est pas soumis ou n'est pas valide, affiche le formulaire et les données associées
        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
