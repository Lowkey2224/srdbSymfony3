<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use CharacterDatabaseBundle\Entity\Skill;

class SkillControllerTest extends AbstractEntityControllerTest
{
    private $skillThrowing = [
        'name' => 'Wurfwaffen',
        'type' => [
            'id' =>Skill::TYPE_ACTION_SKILL,
            'name' => Skill::TYPE_ACTION_SKILL_NAME
            ],
        'attribute' => [
            'id' => 2,
            'name' => 'Schnelligkeit',
        ],
    ];

    private $skillTHeimlichkeit = [
        'name' => 'Heimlichkeit ist gut',
        'type' => [
            'id' =>Skill::TYPE_ACTION_SKILL,
            'name' => Skill::TYPE_ACTION_SKILL_NAME
        ],
        'attribute' => [
            'id' => 2,
            'name' => 'Schnelligkeit',
        ],
    ];

    private $skillTHeimlichkeitOriginal = [
        'name' => 'Heimlichkeit',
        'type' => [
            'id' =>Skill::TYPE_ACTION_SKILL,
            'name' => Skill::TYPE_ACTION_SKILL_NAME
        ],
        'attribute' => [
            'id' => 2,
            'name' => 'Schnelligkeit',
        ],
    ];

    protected function getRouteName()
    {
        return '/skill';
    }

    protected function getInvalidJson()
    {
        return [
            ['hallo' => "welt"],
            [
                'Name' => 'Hallo',
                "type" => Skill::TYPE_ACTION_SKILL,
                'attribute' => [
                    'id' => 0,
                    'name' => "gibt es nicht",
                ],
            ],
        ];

    }

    /**
     * Returns an Array Of Items which can be used for Creation
     * @return array
     */
    protected function getValidCreationJson()
    {
        return [
            $this->skillThrowing,
        ];
    }

    /**
     * Returns an Array of Entity that will be updated.
     * Preferably always n*2 Items, with first one as change, and second one with the original State
     * this array must Contain an ID
     * @return array
     */
    protected function getEntityUpdated()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);

        $skill = $em->getRepository('CharacterDatabaseBundle:Skill')
            ->findOneBy(['name' => $this->skillTHeimlichkeitOriginal['name']]);
        $this->skillTHeimlichkeitOriginal['id'] = $skill->getId();
        $this->skillTHeimlichkeit['id'] = $skill->getId();

        return [
            $this->skillTHeimlichkeit,
            $this->skillTHeimlichkeitOriginal,
        ];
    }

    /**
     * Returns an array of Fields/Keys in dot notation, that will be checked
     * @return array
     */
    protected function fieldsForIndexTesting()
    {
        return ['name', 'type', 'attribute.id', 'attribute.name', 'type.id', 'type.name'];
    }
}
