<?php

namespace App\Controller;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use App\Entity\Detailstache;
use App\Form\DetailstacheType;
use App\Repository\DetailstacheRepository;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Symfony\Component\Security\Core\Security;



class ProjetController extends AbstractController
{     
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
      /**
     * @Route("/zz", name="user_index", methods={"GET"})
     */
    public function index2(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/indexam.html.twig', [
            'projets' => $projetRepository->findby(
                ['chefdeprojet' => $user = $this->getUser()],
)
        ]); 
    }
     

    /**
     * @Route("/indexprojet", name="projet_index", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]); 
    }

    /**
     * @Route("/newprojet", name="projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();

        $user = $this->security->getUser();
       
        if ($user->hasRole("ROLE_CHEF")){

        $projet-> setChefdeprojet($user = $this->getUser());}
        
        $form = $this->createForm(ProjetType::class, $projet);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showprojet/{id}", name="projet_show", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
     return $this->render('projet/show.html.twig', ['projet' => $projet]);
    }

    /**
     * @Route("/editprojet/{id}", name="projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_index', [
                'id' => $projet->getId(),
            ]);
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteprojet/{id}", name="projet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Projet $projet): Response
    {           $user = $this->security->getUser();

        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }
        if ($user->hasRole("ROLE_CHEF")){
            return $this->redirectToRoute('chef');}
         else  return $this->redirectToRoute('projet_index');
    }

}
