<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\CalendarChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Ob\HighchartsBundle\Highcharts\Highchart;



class UserController extends AbstractController
{
 

  /**
     * @Route("/chef", name="chef")
     */
    public function chef(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/chef.html.twig', [
            'projets' => $projetRepository->findby(
                ['chefdeprojet' => $user = $this->getUser()],
)
        ]); 
    }

    /**
     * @Route("/consultant",name="consultant")
     */
    public function index3(TacheRepository $tacheRepository): Response
    {
        return $this->render('tache/consultant.html.twig', [
            'taches' => $tacheRepository->findby(
                ['consultant' => $user = $this->getUser()],
)
        ]); 
    }
    /**
     * @Route("/stats", name="stats", methods={"GET"})
     */
    public function index4()
    {
        
    $items = $this->getDoctrine()->getRepository(Projet::class)->findAll();
    $total = 0;
    foreach ($items as $item) {
        $total += $item->getBudget();
    }
 
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable([
        [ 'Budget Total', 'Hours per Day' ],
        [ 'Budget Total $', $total ],
    ]);
    /***/

        return $this->render('projet/stats.html.twig', array(
                'piechart' => $pieChart,
            )
 
        );
    }


    /**
     * @Route("/stats", name="stats2", methods={"GET"})
     */
    public function pie2(Request $r)
{
    $series = array(
        array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
    );

    $ob = new Highchart();
    $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
    $ob->title->text('Chart Title');
    $ob->xAxis->title(array('text'  => "Horizontal axis title"));
    $ob->yAxis->title(array('text'  => "Vertical axis title"));
    $ob->series($series);

    return $this->render('projet/stats.html.twig', array(
        'chart' => $ob
    ));
}
    



    
    public function findAllroles($roles): array
{
    
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM fos_user p
        WHERE p.roles LIKE :roles
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['roles' => $roles]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
}
}
