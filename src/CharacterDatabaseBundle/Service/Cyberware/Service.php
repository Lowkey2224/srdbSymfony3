<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service\Cyberware;

use CharacterDatabaseBundle\Entity\Cyberware;
use CharacterDatabaseBundle\Entity\CyberwareLevel;
use CharacterDatabaseBundle\Service\LoggerAwareService;
use Doctrine\Common\Collections\ArrayCollection;

class Service extends LoggerAwareService
{

    /**
     * @param Cyberware $cyberware
     * @param $jsonDecoded
     * @return ArrayCollection
     */
    public function createCyberwareLevels(Cyberware $cyberware, $jsonDecoded)
    {
        $levels = new ArrayCollection();
        foreach ($jsonDecoded as $level) {
            $item = new CyberwareLevel();
            $item->setEffect($level['effect']);
            $item->setCost($level['cost']);
            $item->setLevel($level['level']);
            $item->setCyberware($cyberware);
            $levels->add($item);
        }
        return $levels;
    }
}
