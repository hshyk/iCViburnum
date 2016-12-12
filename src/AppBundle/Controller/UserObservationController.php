<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\iCViburnum\Observation;
use AppBundle\Entity\VirtualViburnum\BasisOfRecord;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;



/**
 * Observation controller.
 *
 * @Route("/user/observations")
 */
class UserObservationController extends Controller
{
    /**
     * Lists all iCViburnum\Observation entities.
     *
     * @Route("/", name="user_observations_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $query =  $this->getDoctrine()->getRepository('AppBundle:iCViburnum\Observation')->findAllByUser($this->get('security.token_storage')->getToken()->getUser()->getId());
        $mapQuery = $this->getDoctrine()->getRepository('AppBundle:iCViburnum\Observation')->findAllByUser($this->get('security.token_storage')->getToken()->getUser()->getId())->getResult();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
            );

        $map = $this->get('fungio_google_map.map');
        foreach($mapQuery as $observation) {
            $marker = $this->get('fungio_google_map.marker');
            $marker->setPosition($observation->getLatitude(), $observation->getLongitude());
            $map->addMarker($marker);
        }
        $map->setMapOption('zoom', 1);

        return $this->render('user/observations/index.html.twig', array(
            'observations' => $query->getResult(),
            'pagination' => $pagination,
            'map' => $map,
        ));
    }

    /**
     * Creates a new observation entity.
     *
     * @Route("/add", name="user_observations_add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        //$session = $request->getSession();

        $observation = new Observation();
        $form = $this->createForm('AppBundle\Form\Type\UserObservationType', $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $observationType = $this->getDoctrine()
                ->getRepository('AppBundle:VirtualViburnum\BasisOfRecord', 'virtualviburnum')
                ->findOneByValue(BasisOfRecord::HUMAN_OBSERVATION)
                ->getObservationType();

            $observation->setOrganism($form->get('organism')->getData()->getOrganism());
            $observation->setType($observationType);
            $observation->setUser($this->get('security.token_storage')->getToken()->getUser());
            $observation->setGeom($form->get('latitude')->getData(), $form->get('longitude')->getData());

            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('user_observations_show', array('id' => $observation->getId()));
        }

        return $this->render('user/observations/add.html.twig', array(
            'map' => $this->get('fungio_google_map.map'),
            'observation' => $observation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Display a lifelist of seen Viburnum.
     *
     * @Route("/lifelist", name="user_observations_lifelist")
     * @Method("GET")
     */
    public function viewLifelist()
    {
        $organisms =  $this->getDoctrine()->getRepository('AppBundle:iCViburnum\Organism')->findAllByUser($this->get('security.token_storage')->getToken()->getUser()->getId());
        return $this->render('user/observations/lifelist.html.twig', array(
            'organisms' => $organisms,
            'search' => $this->get('app.util.organism_util')
        ));
    }

    /**
     * Creates a new observation entity.
     *
     * @Route("/images/upload", name="user_observations_images_upload")
     * @Method({"GET", "POST"})
     */
    public function getUploadedFiles()
    {
        $finder = new Finder();
        $finder->files()->in(
            $this->get('kernel')->getRootDir().
            '/../uploads/'.
            $this->get('security.token_storage')->getToken()->getUser()->getId());

        $files = array();

        foreach ($finder as $file) {
            array_push($files, array(
                "name" => basename($file->getRealPath()),
                'deleteUrl' => '/app_dev.php/user/observations/images/upload/delete?file='.$file->getFileName(),
    		    'deleteType' => 'DELETE'
                )
            );
        }

        return new JsonResponse(array('files' => $files));
    }

    /**
     * Delete an uploaded file
     *
     * @Route("/images/upload/delete", name="user_observations_images_upload_delete")
     * @Method({"DELETE"})
     */
    public function deleteUploadedFiles(Request $request)
    {
        $fs = new Filesystem();
        $fs->remove($this->get('kernel')->getRootDir().
            '/../uploads/'.
            $this->get('security.token_storage')->getToken()->getUser()->getId().'/'.
            $request->query->get('file')
            );

        return new JsonResponse(array(
            '/app_dev.php/user/observations/images/upload/delete?file='.$request->query->get('file') => true,
    		   ));
    }

    /**
     * Finds and displays a iCViburnum\Observation entity.
     *
     * @Route("/{id}", name="user_observations_show")
     * @Method("GET")
     */
    public function showAction(Observation $observation)
    {
        $deleteForm = $this->createDeleteForm($observation);
        return $this->render('user/observations/show.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing iCViburnum\Observation entity.
     *
     * @Route("/{id}/edit", name="user_observations_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Observation $observation)
    {
        $deleteForm = $this->createDeleteForm($observation);
        $editForm = $this->createForm('AppBundle\Form\Type\UserObservationType', $observation);
        $editForm->handleRequest($request);

        $editForm->get('howAdd')->setData('map');

        $map = $this->get('fungio_google_map.map');
        $marker = $this->get('fungio_google_map.marker');
        $marker->setPosition($observation->getLatitude(), $observation->getLongitude());
        $map->addMarker($marker);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $observation->setOrganism($editForm->get('organism')->getData()->getOrganism());
            $observation->setGeom($editForm->get('latitude')->getData(), $editForm->get('longitude')->getData());

            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('user_observations_show', array('id' => $observation->getId()));
        }

        return $this->render('user/observations/edit.html.twig', array(
            'observation' => $observation,
            'map' => $map,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a iCViburnum\Observation entity.
     *
     * @Route("/{id}", name="user_observations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Observation $observation)
    {
        $form = $this->createDeleteForm($observation
            );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($observation);
            $em->flush();
        }

        return $this->redirectToRoute('user_observations_index');
    }

    /**
     * Creates a form to delete a iCViburnum\Observation entity.
     *
     * @param Observation $iCViburnum\Observation The iCViburnum\Observation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Observation $observation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_observations_delete', array('id' => $observation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
