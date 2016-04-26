<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

//$set = new \h4cc\AliceFixturesBundle\Fixtures\FixtureSet();
        $ary[] = __DIR__.'/fixtures/users.yml';
        $ary[] = __DIR__.'/fixtures/attributes.yml';
        $ary[] = __DIR__.'/fixtures/skills.yml';
        $ary[] = __DIR__.'/fixtures/magicalCapabilities.yml';
        $ary[] = __DIR__.'/fixtures/traditions.yml';
        $ary[] = __DIR__.'/fixtures/totems.yml';
        $ary[] = __DIR__.'/fixtures/characters.yml';
        $ary[] = __DIR__.'/fixtures/characterToAttributes.yml';
        $ary[] = __DIR__.'/fixtures/characterToSkills.yml';
        $ary[] = __DIR__.'/fixtures/connectionsNotInDB.yml';
        $ary[] = __DIR__.'/fixtures/connectionsInDB.yml';
        $ary[] = __DIR__.'/fixtures/specializations.yml';
        $ary[] = __DIR__.'/fixtures/characterToSpec.yml';

        $objects = \Nelmio\Alice\Fixtures::load($ary, $manager);
        return $objects;
    }
}
