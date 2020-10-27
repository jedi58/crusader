<?php

namespace App\Parser;

use Symfony\Component\DomCrawler\Crawler;

class BattleScribeRoster
{
    const XPATH_SCHEMA = '//roster/forces/force/';
    const XPATH_FACTION = '@catalogueName';
    const XPATH_UNITS = 'selections/selection[not(categories/category[@name="Configuration"]) and not(categories/category[@name="Stratagems"])]';
    const XPATH_KEYWORD = 'selection/categories/category[not(starts-with(@name, "Faction: "))]';
    const XPATH_MODELS = 'selection/selections/selection[@type="model"]';
    const XPATH_ROLE = 'selection/categories/category[@primary="true"]';
    const XPATH_PROFILE = 'selection/selections/selection/profiles/profile';
    const XPATH_SUB_PROFILE = 'selection/selections/selection/selections/selection/profiles/profile';
    const XPATH_ABILITIES = '[@typeName="Abilities"]';
    const XPATH_PSYKER = '[@typeName="Psychic Power"]';
    const XPATH_WEAPON = '[@typeName="Weapon"]';
    const XPATH_COST = 'selection/costs/cost[@name=" PL"]';

    private $crawler;

    private $units = [];

    private $costs = [];

    private $costLimits = [];

    public function __construct(string $content)
    {
        $this->crawler = new Crawler();
        $this->crawler->addXmlContent($content);
    }

    public function getForce()
    {
        $units = $this->getUnits();
        $units->each(function(Crawler $unit) {
            $this->units[] = [
                'name' => $this->getNameForUnit($unit),
                'role' => $this->getRoleForUnit($unit),
                'equipment' => $this->getEquipmentForUnit($unit),
                'psychic' => $this->getPsychicForUnit($unit),
                'traits' => [],
                'relics' => [],
                'other' => $this->getAbilitiesForUnit($unit),
                'cost' => $this->getCostForUnit($unit),
                'keywords' => $this->getKeywords($unit),
            ];
        });
        return $this->units;
    }

    public function getFaction()
    {
        return $this->crawler
            ->filterXPath(
                BattleScribeRoster::XPATH_SCHEMA
                . BattleScribeRoster::XPATH_FACTION
            )
            ->text()
        ;
    }

    public function getCosts()
    {
        $this->crawler->filterXPath('//roster/costs/cost')->each(function(Crawler $node)
        {
            $this->costs[trim($node->attr('name'))] = (int) $node->attr('value');
        });

        return $this->costs;
    }

    public function getCostLimits()
    {
        $this->crawler->filterXPath('//roster/costLimits/costLimit')->each(function(Crawler $node)
        {
            $this->costLimits[trim($node->attr('name'))] = (int) $node->attr('value');
        });

        return $this->costLimits;
    }

    public function getUnits()
    {
        return $this->crawler
            ->filterXPath(
                BattleScribeRoster::XPATH_SCHEMA
                . BattleScribeRoster::XPATH_UNITS
            )
        ;
    }

    public function getRoleForUnit($unit)
    {
        return $unit->filterXPath(BattleScribeRoster::XPATH_ROLE)->attr('name', 'Infantry');
    }

    public function getNameForUnit($unit)
    {
        return $unit->attr('name');
    }

    public function getEquipmentForUnit($unit)
    {
        $equipment = $unit->filterXPath(BattleScribeRoster::XPATH_PROFILE . BattleScribeRoster::XPATH_WEAPON)->each(function($node)
        {
            return $node->attr('name');
        });
        $equipment2 = $unit->filterXPath(BattleScribeRoster::XPATH_SUB_PROFILE . BattleScribeRoster::XPATH_WEAPON)->each(function($node)
        {
            return $node->attr('name');
        });
        return array_unique(array_merge($equipment, $equipment2));
    }

    public function getAbilitiesForUnit($unit)
    {
        return $unit->filterXPath(BattleScribeRoster::XPATH_PROFILE . BattleScribeRoster::XPATH_ABILITIES)->each(
            function ($node)
            {
                return $node->attr('name');
            }
        );
    }

    public function getPsychicForUnit($unit)
    {
        return $unit->filterXPath(BattleScribeRoster::XPATH_PROFILE . BattleScribeRoster::XPATH_PSYKER)->each(
            function ($node)
            {
                return $node->attr('name');
            }
        );
    }

    public function getCostForUnit($unit)
    {
        return (int) $unit->filterXPath(BattleScribeRoster::XPATH_COST)->attr('value', 0);
    }

    public function getKeywords($unit)
    {
        return $unit->filterXPath(BattleScribeRoster::XPATH_KEYWORD)->each(
            function ($node)
            {
                return $node->attr('name');
            }
        );
    }
}
