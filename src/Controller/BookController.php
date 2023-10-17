<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\Type\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends BaseController
{
    #[Route('/book/create', name: 'book_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response {

        $book = new Book();
        $form = $this->createForm(BookType::class, $book, ['submit' => 'Create book']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/book/update/{id}', name: 'book_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): Response {

        $book = $this->findModel($entityManager, $id, Book::class);
        $form = $this->createForm(BookType::class, $book, ['submit' => 'Update book']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/update.html.twig', [
            'form' => $form,
            'book' => $book
        ]);
    }

    #[Route('/book/delete/{id}', name: 'book_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response {

        $book = $this->findModel($entityManager, $id, Book::class);
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_index');
    }

    #[Route('/book/index', name: 'book_index')]
    public function index(EntityManagerInterface $entityManager): Response {

        $books = $entityManager
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }

    #[Route('/book/view/{id}', name: 'book_view')]
    public function view(EntityManagerInterface $entityManager, int $id): Response {

        $book = $this->findModel($entityManager, $id, Book::class);

        return $this->render('book/view.html.twig', [
            'book' => $book
        ]);
    }
}