<?php

namespace App\Controller;

use App\Entity\Force;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForceEditController extends AbstractController
{
    /**
     * @Route("/force/edit/{id<[0-9a-z\-]+>}", name="force_edit")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $force = $this->getDoctrine()->getRepository(Force::class)->findOneBy([
            'public_id' => $request->get('id'),
            'player' => $this->getUser(),
        ]);

        if (!$force) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('force_edit/index.html.twig', [
            'controller_name' => 'ForceEditController',
            'data' => [
                'force' => $force,
            ],
        ]);
    }
}
