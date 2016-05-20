<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service;

use Psr\Log\LoggerInterface;

abstract class LoggerAwareService
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }
}
