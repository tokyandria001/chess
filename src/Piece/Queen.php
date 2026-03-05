<?php

namespace Chess\Piece;

use Chess\Position;
use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;

class Queen extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::QUEEN;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $fromRow = $this->position->getRow();
        $fromCol = $this->position->getColumn();
        $toRow = $target->getRow();
        $toCol = $target->getColumn();

        $rowDistance = abs($toRow - $fromRow);
        $colDistance = abs($toCol - $fromCol);

        if ($fromRow === $toRow && $colDistance > 0) {
            return true; // Mouvement horizontal
        }

        if ($fromCol === $toCol && $rowDistance > 0) {
            return true; // Mouvement vertical
        }

        if ($rowDistance === $colDistance && $rowDistance > 0) {
            return true; // Mouvement en diagonale
        }

        return false;
    }
}