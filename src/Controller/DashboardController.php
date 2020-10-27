<?php

namespace App\Controller;

use App\Entity\Force;
use App\Parser\BattleScribeRoster;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        $forces = $this->getDoctrine()->getManager()->getRepository(Force::class)->findBy(
            [],
            [],
            25,
            0
        );
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'data' => [
                'forces' => $forces,
            ],
        ]);
    }
}
