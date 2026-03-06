<?php

namespace Chess\Exception;

class NoPieceException extends ChessException
{
    public function __construct($position)
    {
        $message = "Aucune pièce à la position (" . $position->getRow() . ", ". $position->getColumn() . ")";
        parent::__construct($message);
    }
}