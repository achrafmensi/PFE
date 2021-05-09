<?php

namespace App\Controller;

use App\Entity\Detailstache;
use App\Form\DetailstacheType;
use App\Repository\DetailstacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DetailstacheController extends AbstractController
{
    /**
     * @Route("/indexdetailstache", name="detailstache_index", methods={"GET"})
     */
    public function index(DetailstacheRepository $detailstacheRepository): Response
    {
        return $this->render('detailstache/index.html.twig', [
            'detailstaches' => $detailstacheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newdetailstache", name="detailstache_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailstache = new Detailstache();
        $detailstache-> setDatesaisie(new \DateTime('now'));
        $form = $this->createForm(DetailstacheType::class, $detailstache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailstache);
            $entityManager->flush();

            return $this->redirectToRoute('detailstache_index');
        }

        return $this->render('detailstache/new.html.twig', [
            'detailstache' => $detailstache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showdetailstache/{id}", name="detailstache_show", methods={"GET"})
     */
    public function show(Detailstache $detailstache): Response
    {
        return $this->render('detailstache/show.html.twig', [
            'detailstache' => $detailstache,
        ]);
    }

    /**
     * @Route("/edit/detailstache/{id}", name="detailstache_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Detailstache $detailstache): Response
    {
        $form = $this->createForm(DetailstacheType::class, $detailstache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detailstache_index', [
                'id' => $detailstache->getId(),
            ]);
        }

        return $this->render('detailstache/edit.html.twig', [
            'detailstache' => $detailstache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deletedetailstache/{id}", name="detailstache_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Detailstache $detailstache): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailstache->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailstache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detailstache_index');
    }
}
