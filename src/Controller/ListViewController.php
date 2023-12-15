<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Lists;
use App\Form\NewItemForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListViewController extends AbstractController
{

    #[Route('/list_view/{id}', name: 'lists')]
    public function index(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $item = new Items();
        $form = $this->createForm(NewItemForm::class, $item);
        $form->handleRequest($request);
        $list = $entityManager->getRepository(Lists::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setName($form->get('name')->getData());
            $item->setPrice($form->get('price')->getData());

            $list->addItem($item);

            $entityManager->persist($list);
            $entityManager->persist($item);
            $entityManager->flush();
            $this->calculateCost($id, $entityManager);
        }

        $listItems = $this->getListItems($entityManager, $id);

        return $this->render('listView/index.html.twig', [
            'id' => $id,
            'items' => $listItems,
            'newItemForm' => $form->createView(),
        ]);
    }

    private function getListItems(EntityManagerInterface $entityManager, int $id)
    {
        $repository = $entityManager->getRepository(Lists::class);
        $list = $repository->find($id);
        $items = $list->getItem();
        return $items;
    }

    #[Route('/list_view/{listId}/{itemId}', name: 'delete-item')]
    public function deleteList(int $listId, int $itemId, EntityManagerInterface $entityManager)
    {
        $list = $entityManager->getRepository(Lists::class)->find($listId);
        $item = $entityManager->getRepository(Items::class)->find($itemId);

        $list->removeItem($item);

        $entityManager->persist($list);
        $entityManager->flush();
        $this->calculateCost($listId, $entityManager);
        return $this->redirectToRoute('lists', ['id'=>$listId]);
    }

    private function calculateCost(int $id, EntityManagerInterface $entityManager)
    {
        $list = $entityManager->getRepository(Lists::class)->find($id);
        $items = $list->getItem();
        $cost = 0;

        if ($items) {
           foreach ($items as $item) {
               $cost += $item->getPrice();
           }
           $list->setEstimatedCost($cost);

           $entityManager->persist($list);
           $entityManager->flush();
        }
    }
}