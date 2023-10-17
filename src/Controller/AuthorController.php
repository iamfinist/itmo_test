<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\Type\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends BaseController
{
    #[Route('/author/create', name: 'author_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response {

        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author, ['submit' => 'Create author']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/author/update/{id}', name: 'author_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): Response {

        $author = $this->findModel($entityManager, $id, Author::class);
        $form = $this->createForm(AuthorType::class, $author, ['submit' => 'Update author']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/update.html.twig', [
            'form' => $form,
            'author' => $author
        ]);
    }

    #[Route('/author/delete/{id}', name: 'author_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response {

        $author = $this->findModel($entityManager, $id, Author::class);
        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('author_index');
    }

    #[Route('/author/index', name: 'author_index')]
    public function index(EntityManagerInterface $entityManager): Response {

        $authors = $entityManager
            ->getRepository(Author::class)
            ->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/author/view/{id}', name: 'author_view')]
    public function view(EntityManagerInterface $entityManager, int $id): Response {

        $author = $this->findModel($entityManager, $id, Author::class);

        return $this->render('author/view.html.twig', [
            'author' => $author
        ]);
    }

}