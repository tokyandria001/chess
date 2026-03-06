<?php

namespace Chess\Exception;

class OccupiedByAllyException extends ChessException
{
    public function __construct($message = "La case est occupée par une pièce alliée")
    {
        parent::__construct($message);
    }
}