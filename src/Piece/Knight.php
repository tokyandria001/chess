<?php

namespace Chess\Piece;

use Chess\Position;
use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;

class Knight extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::KNIGHT;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $fromRow = $this->position->getRow();
        $fromCol = $this->position->getColumn();
        $toRow = $target->getRow();
        $toCol = $target->getColumn();

        $rowDistance = abs($toRow - $fromRow);
        $colDistance = abs($toCol - $fromCol);

        if (($rowDistance === 2 && $colDistance === 1) || ($rowDistance === 1 && $colDistance === 2)) {
            return true; // Mouvement en L
        }

        return false;
    }
}