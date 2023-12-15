<?php

namespace App\Controller;

use App\Entity\Lists;
use App\Form\newListForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private array $userLists = [];

    #[Route('/home', name: 'home')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $list = new Lists();
        $form = $this->createForm(newListForm::class, $list);
        $form->handleRequest($request);
        $userId = $this->getUserId();

        if ($form->isSubmitted() && $form->isValid()) {
            $list->setName($form->get('name')->getData());
            $list->setUserId($userId);

            $entityManager->persist($list);
            $entityManager->flush();
        }

        $this->userLists = $this->getUserLists($entityManager, $userId);

        return $this->render('userLists/index.html.twig', [
            'lists' => $this->userLists,
            'newListForm' => $form->createView(),
        ]);
    }

    private function getUserLists(EntityManagerInterface $entityManager, $userId): array
    {
        $repository = $entityManager->getRepository(Lists::class);
        $lists = $repository->findBy(
            ['user_id' => $userId]
        );
        if ($lists !== null){
            return $lists;
        }
        return [];
    }

    private function getUserId()
    {
        $user = $this->getUser();
        return $user->getId();
    }

    #[Route('/home/{id}', name: 'delete-list')]
    public function deleteList(int $id, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Lists::class);
        $list = $repository->find($id);
        if($list) {
            $entityManager->remove($list);
            $entityManager->flush();
            $this->cleanupCrossTable($list, $entityManager);
        }
        return $this->redirectToRoute('home');
    }

    private function cleanupCrossTable(Lists $list, EntityManagerInterface $entityManager)
    {
        $items = $list->getItem();
        foreach ($items as $item) {
            $item->removeList($list);
            $entityManager->persist($item);
        }

        $entityManager->flush();
    }
}