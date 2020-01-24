<?php

namespace Pondit\Message;


use Pondit\Response\Responsable;

abstract class MessageSender
{
    use responsable;

    protected $data;

    /**
     * MessageSender constructor.
     * @param array $requestData
     */
    public function __construct(array $requestData = [])
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
        }

        // Todo: validation
        $this->data = $requestData;
    }

    abstract public function send();
}