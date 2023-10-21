<?php

namespace Cqs\Messenger;

interface MessageBus
{
    public function dispatch(Message $message): mixed;
}
