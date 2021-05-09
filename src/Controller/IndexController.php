<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;

class IndexController extends Controller {
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/")
     */
    public function index() {
        $user = $this->security->getUser();

        if ($user->hasRole("ROLE_CHEF")){
            return $this->redirectToRoute('chef');
        }
        else if ($user->hasRole("ROLE_CONSULTANT")){
            return $this->redirectToRoute('consultant');
        }
        else if ($user->hasRole("ROLE_ADMIN")){
            return $this->redirect('admin');
        }
        else if ($user->hasRole("ROLE_DIRECTEUR")){
            return $this->redirectToRoute('stats');
        }        
    }
}