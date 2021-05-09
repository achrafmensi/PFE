<?php

namespace App\Controller;

use App\Entity\Detailstache;
use App\Form\DetailstacheType;
use App\Repository\DetailstacheRepository;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Controller\DataTablesTrait;
use Symfony\Component\Security\Core\Security;


class TacheController extends AbstractController
{     
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/indextache", name="tache_index", methods={"GET"})
     */
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('tache/index.html.twig', [
            'taches' => $tacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newtache", name="tache_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tache = new Tache();
        $user = $this->security->getUser();
       
        if ($user->hasRole("ROLE_CONSULTANT")){

        $tache-> setConsultant($user = $this->getUser());}

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();

            if ($user->hasRole("ROLE_CONSULTANT")){
            return $this->redirectToRoute('consultant');}
            else if ($user->hasRole("ROLE_CHEF")){
                return $this->redirectToRoute('chef');}
    
         else  return $this->redirectToRoute('tache_index');}

        return $this->render('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showtache/{id}", name="tache_show", methods={"GET"})
     */
    public function show(Tache $tache): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }

    /**
     * @Route("/edittache/{id}", name="tache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tache $tache): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tache_index', [
                'id' => $tache->getId(),
            ]);
        }

        return $this->render('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deletetache/{id}", name="tache_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tache $tache): Response
    {        $user = $this->security->getUser();

        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tache);
            $entityManager->flush();
        }

        if ($user->hasRole("ROLE_CONSULTANT")){
            return $this->redirectToRoute('consultant');}
            else if ($user->hasRole("ROLE_CHEF")){
                return $this->redirectToRoute('chef');}
         else  return $this->redirectToRoute('tache_index');
    }
}
