<?php

namespace App\Util;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class MonologDBHandler
 *
 * @package App\Util
 */
class MonologDBHandler extends AbstractProcessingHandler
{

    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * MonologDBHandler constructor.
     *
     * @param EntityManagerInterface $em - Entity manager.
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /**
     * Called when writing to our database
     *
     * @param array $record - Log record.
     */
    protected function write(array $record)
    {
        $logEntry = new Log();
        $logEntry->setCode($record['code']);
        $logEntry->setMessage($record['message']);
        $logEntry->setLevel($record['level']);
        $logEntry->setLevelName($record['level_name']);
        $logEntry->setExtra($record['extra']);
        $logEntry->setContext($record['context']);

        $this->em->persist($logEntry);
        $this->em->flush();
    }

}