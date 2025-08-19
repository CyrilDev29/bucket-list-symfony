<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Wish;
use App\Form\WishType;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/wishes/create', name: 'wish_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer un nouveau souhait
        $wish = new Wish();

        // Créer le formulaire
        $form = $this->createForm(WishType::class, $wish);

        // Traiter la requête (données soumises)
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Définir la date de création automatiquement
            $wish->setDateCreated(new \DateTime());

            // Sauvegarder en base de données
            $entityManager->persist($wish); // je m'empare du wish
            $entityManager->flush(); // je vide dans la table

            // Message de succès
            $this->addFlash('success', 'Idea successfully added!');

            // Rediriger vers la page de détail du nouveau souhait
            return $this->redirectToRoute('wish_detail', [
                'id' => $wish->getId()
            ]);
        }

        // Afficher le formulaire
        return $this->render('wish/create.html.twig', [
            'wishForm' => $form->createView()
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
    #[Route('/wishes/{id}/delete', name: 'wish_delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function delete(int $id, WishRepository $wishRepository, Request $request, EntityManagerInterface $em): Response
    {
        // Récupérer le souhait par son ID
        $wish = $wishRepository->find($id);

        // Si le souhait n'existe pas, erreur 404
        if (!$wish) {
            throw $this->createNotFoundException('This wish do not exists! Sorry!');
        }

        // Vérifier le token CSRF pour la sécurité
        if ($this->isCsrfTokenValid('delete'.$id, $request->query->get('token'))) {
            // Token valide : supprimer le souhait
            $em->remove($wish, true);
            $this->addFlash('success', 'This wish has been deleted');
        } else {
            // Token invalide : erreur de sécurité
            $this->addFlash('danger', 'This wish cannot be deleted');
        }

        // Retourner à la page de la liste
        return $this->redirectToRoute('wish_list');
    }
}