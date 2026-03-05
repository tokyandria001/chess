<?php

namespace Chess\Piece;

use Chess\Position;
use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;

class Rook extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::ROOK;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $fromRow = $this->position->getRow();
        $fromCol = $this->position->getColumn();
        $toRow = $target->getRow();
        $toCol = $target->getColumn();

        if ($fromRow === $toRow && $fromCol !== $toCol) {
            return true; // Mouvement horizontal
        }
        if ($fromCol === $toCol && $fromRow !== $toRow) {
            return true; // Mouvement vertical
        }
        return false;
    }
}