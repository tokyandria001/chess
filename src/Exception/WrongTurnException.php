<?php

namespace Chess\Exception;

class WrongTurnException extends ChessException
{
    public function __construct($message = "Ce n'est pas votre tour de jouer")
    {;
        parent::__construct($message);
    }
}