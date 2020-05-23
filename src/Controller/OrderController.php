<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Orders;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/{id}", name="order", requirements={"id"="\d+"})
     */
    public function index(int $id, Request $request, EntityManagerInterface $em)
    {
        /** @var Item $item */
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);

        $order = new Orders();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            /** @var Orders $order */
            $order = $form->getData();

            $order->setItem($item);
            $order->setOrderDate(new \DateTime('now'));
            $order->setIsComplete(false);

            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('order_success');

        }

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/success", name="order_success")
     */
    public function success()
    {
        return $this->render('order/success.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/manager/orders", name="manager_orders")
     */
    public function managerOrders(PaginatorInterface $paginator, Request $request)
    {
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findBy(['isComplete' => false]);

        $ordersRepo = $this->getDoctrine()->getRepository(Orders::class);

        $ordersQuery = $ordersRepo->createQueryBuilder('o')
            ->select('o')
            ->where('o.isComplete = false')
            ->getQuery();

        $orders = $paginator->paginate(
            $ordersQuery,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('order/manager_orders.html.twig', [
            'controller_name' => 'OrderController',
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/manager/orders/{id}", name="manager_orders_info", requirements={"id"="\d+"})
     */
    public function managerOrdersInfo(int $id)
    {
        /** @var Orders $order */
        $order = $this->getDoctrine()->getRepository(Orders::class)->find($id);

        return $this->render('order/manager_orders_info.html.twig', [
            'controller_name' => 'OrderController',
            'order' => $order,
        ]);
    }

    /**
     * @Route("/manager/orders/complete/{id}", name="manager_orders_complete", requirements={"id"="\d+"})
     */
    public function completeOrder(int $id, EntityManagerInterface $em)
    {
        /** @var Orders $order */
        $order = $this->getDoctrine()->getRepository(Orders::class)->find($id);

        $order->setIsComplete(true);
        $em->flush();

        $this->addFlash('info', 'Заказ обработан');

        return $this->redirectToRoute('manager_orders');
    }

    /**
     * @Route("/manager/orders/delete/{id}", name="manager_orders_delete", requirements={"id"="\d+"})
     */
    public function deleteOrder(int $id, EntityManagerInterface $em)
    {
        /** @var Orders $order */
        $order = $this->getDoctrine()->getRepository(Orders::class)->find($id);

        $em->remove($order);
        $em->flush();

        $this->addFlash('info', 'Заказ удален');

        return $this->redirectToRoute('manager_orders');
    }
}
