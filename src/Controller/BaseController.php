<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('author_index');
    }
    protected function findModel(EntityManagerInterface $entityManager, int $id, string $className) {

        $model = $entityManager
            ->getRepository($className)
            ->find($id);

        if (!$model) {
            throw $this->createNotFoundException(
                "No {$className} found for id {$id}"
            );
        }

        return $model;
    }
}