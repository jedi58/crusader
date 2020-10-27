<?php

namespace App\Controller;

use App\Entity\BattlefieldRole;
use App\Entity\Card;
use App\Entity\Faction;
use App\Entity\Force;
use App\Parser\BattleScribeRoster;
use App\Repository\FactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForceCreateController extends AbstractController
{
    /**
     * @Route("/force/create", name="force_create", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render('force_create/index.html.twig', [
            'controller_name' => 'ForceCreateController',
        ]);
    }

    /**
     * @Route("/force/create", name="process_roster", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function processRoster(Request $request)
    {
        // Parse Roster file from BattleScribe
        $bsRoster = $request->files->get('bsRoster');
        if (empty($request->files) || !$bsRoster) {
            $this->addFlash('error', 'Invalid file');
            return $this->redirectToRoute('force_create');
        }
        $roster = new BattleScribeRoster(
            file_get_contents($bsRoster->getPathname())
        );

        // Get faction name
        $faction = $this->getDoctrine()->getManager()->getRepository(Faction::class)->findOneBy(
            [
                'name' => $roster->getFaction(),
            ]
        );

        // Create new Force
        $force = new Force();
        $force
            ->setPlayer($this->getUser())
            ->setName('New Force')
            ->setFaction($faction)
        ;

        // Add units to force
        $units = $roster->getForce();

        if (!empty($units)) {
            foreach ($units as $unit) {
                $role = $this->getDoctrine()->getManager()->getRepository(BattlefieldRole::class)->findOneBy(
                    [
                        'name' => $unit['role'],
                    ]
                );

                $card = new Card();
                $card
                    ->setName($unit['name'])
                    ->setRole($role)
                    ->setEquipment(implode(', ', $unit['equipment']))
                    ->setPsychic(implode(', ', $unit['psychic']))
                    ->setWarlordTraits(implode(',', $unit['traits']))
                    ->setRelics(implode(', ', $unit['relics']))
                    ->setOtherUpgrades(implode(', ', $unit['other']))
                    ->setType($unit['name'])
                    ->setPowerRating($unit['cost'])
                    ->setKeywords(implode(', ', $unit['keywords']))
                ;

                $force->addCard($card);
            }

            $this->getDoctrine()->getManager()->persist($force);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('notice', 'Force created');

            return $this->redirectToRoute(
                'force_edit',
                [
                    'id' => $force->getPublicId(),
                ]
            );
        }

        $this->addFlash('error', 'Roster did not contain any units');
        return $this->redirectToRoute('force_create');
    }
}
