<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Service\StatsService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/admin/stats", name="admin_stats")
     */
    public function index(StatsService $statsService, PaginatorInterface $paginator, Request $request)
    {
        $ordersQuery = $this->getDoctrine()->getRepository(Orders::class)
            ->createQueryBuilder('o')
            ->select('o')
            ->where('o.isComplete = :isComplete')
            ->setParameter('isComplete', true)
            ->getQuery();

        $orders = $paginator->paginate(
            $ordersQuery,
            $request->query->getInt('page', 1),
            10
        );

        $items = $statsService->getAmountOfOrdersByAllItems();

        $header = array();
        $header[] = 'Подарок';
        $header[] = 'Количество заказов';

        $resArray[] = $header;

        foreach ($items as $item) {
            $array = array();
            $array[] = $item[0]->getName();
            $array[] = (int)$item[1];
            $resArray[] = $array;
        }

        $chart = new ColumnChart();

        $chart->getData()->setArrayToDataTable(
            $resArray
        );

        $chart->getOptions()->setTitle('Статистика заказов');
        $chart->getOptions()->setHeight(500);
        $chart->getOptions()->setWidth(1000);
        $chart->getOptions()->getTitleTextStyle()->setBold(false);
        $chart->getOptions()->getTitleTextStyle()->setColor('#6184ff');
        $chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $chart->getOptions()->getVAxis()->setFormat('#');

        return $this->render('stats/index.html.twig', [
            'controller_name' => 'StatsController',
            'chart' => $chart,
            'orders' => $orders,
        ]);
    }
}
