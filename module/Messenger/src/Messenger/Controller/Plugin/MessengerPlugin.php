<?php

namespace Messenger\Controller\Plugin;

use Zend\Stdlib\SplQueue;

class MessengerPlugin extends \Zend\Mvc\Controller\Plugin\FlashMessenger
{
    const SUCESSO = "success";
    const ERRO = "error";

    /**
     * Add a message to a specific type
     *
     * @param  string $message
     * @param  string $type
     * @param int $hops Number of hobs to expire this message
     * @return MessengerPlugin Provides a fluent interface
     */
    public function addMessage($message, $type = 'error', $hops = 1)
    {
        $this->getContainer()->setExpirationSeconds(1800);
        $this->setNamespace($type);

        /* PARENT METHOD - OVERRIDE */
        $container = $this->getContainer();
        $namespace = $this->getNamespace();

        if (!$this->messageAdded) {
            $this->getMessagesFromContainer();
            $container->setExpirationHops($hops, null, true);
        }

        if (!isset($container->{$namespace})
            || !($container->{$namespace} instanceof SplQueue)
        ) {
            $container->{$namespace} = new SplQueue();
        }

        $container->{$namespace}->push($message);

        $this->messageAdded = true;
        return $this;
    }


    /**
     * Whether a specific type has messages
     *
     * @return boolean
     */
    public function hasMessages($type = 'all')
    {
        $this->getMessagesFromContainer();
        if($type === 'all')
            return (!empty($this->messages));
        else
            return isset($this->messages[$type]);
    }

    /**
     * Get messages from a specific type
     *
     * @return array
     */
    public function getMessages($type = 'error')
    {
        $this->setNamespace($type);

        if ($this->hasMessages($type)) {
            return $this->messages[$this->getNamespace()]->toArray();
        }

        return array();
    }

    /**
     * Get messages as String
     *
     * @return array
     */
    public function getMessagesAsString($type = 'error', $glue = " - ")
    {
        $msg = "";
        return implode($glue, $this->getMessages($type));
    }


    /**
     * Clear all messages from the previous request & current namespace
     *
     * @return boolean True if messages were cleared, false if none existed
     */
    public function clearMessages($type = 'all')
    {
        if ($this->hasMessages($type)) {
            if($type === 'all')
                $this->messages = array();
            else {
                $this->setNamespace($type);
                unset($this->messages[$this->getNamespace()]);
            }

            return true;
        }

        return false;
    }

    /**
     * Pull messages from the session container
     *
     * Iterates through the session container, removing messages into the local
     * scope.
     *
     * @return void
     */
    protected function getMessagesFromContainer()
    {
        if (!empty($this->messages) || $this->messageAdded) {
            return;
        }

        $container = $this->getContainer();

        $namespaces = array();
        foreach ($container as $namespace => $messages) {
            $this->messages[$namespace] = $messages;
            $namespaces[] = $namespace;
        }
    }
}