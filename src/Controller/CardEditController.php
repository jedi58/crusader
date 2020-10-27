<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Force;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardEditController extends AbstractController
{
    /**
     * @Route("/card/edit/{forceId}--{id}", name="card_edit")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $force = $this->getDoctrine()->getRepository(Force::class)->findOneBy(
            [
              'public_id' => $request->get('forceId'),
              'player' => $this->getUser(),
            ]
        );

        if (!$force) {
            return $this->redirectToRoute('dashboard');
        }

        $card = $this->getDoctrine()->getRepository(Card::class)->findOneBy(
            [
                'id' => $request->get('id'),
            ]
        );

        if (!$card || $card->getParentForce()->getPublicId() != $force->getPublicId()) {
            return $this->redirectToRoute('force_edit', $force->getPublicId());
        }

        return $this->render('card_edit/index.html.twig', [
            'controller_name' => 'CardEditController',
            'card' => $card,
        ]);
    }
}
