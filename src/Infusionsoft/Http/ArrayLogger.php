<?php

namespace Infusionsoft\Http;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class ArrayLogger implements LoggerInterface
{
    use LoggerTrait;

    private $logs = [];

    public function getLogs(){
        return $this->logs;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string|\Stringable $message
     * @param array $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array()): void
    {
        $this->logs[$level][] = [
            'message' => $message,
            'context' => $context
        ];
    }
}
