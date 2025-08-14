<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Wish;

class WishController extends AbstractController
{
    #[Route('/wishes', name: 'wish_list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer le repository de l'entité Wish
        $wishRepository = $entityManager->getRepository(Wish::class);

        // Récupérer tous les souhaits publiés, triés par date de création (plus récent en premier)
        $wishes = $wishRepository->findBy(
            ['isPublished' => true], // seulement les souhaits publiés
            ['dateCreated' => 'DESC'] // plus récent en premier
        );

        // Passer les données au template
        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/wishes/{id}', name: 'wish_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le repository de l'entité Wish
        $wishRepository = $entityManager->getRepository(Wish::class);

        // Chercher le souhait par son ID
        $wish = $wishRepository->find($id);

        // Si le souhait n'existe pas, afficher une erreur 404
        if (!$wish) {
            throw $this->createNotFoundException('Ce souhait n\'existe pas !');
        }

        // Passer le souhait au template
        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
}