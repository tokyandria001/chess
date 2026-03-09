<?php

namespace Chess;

use Chess\Enum\PieceColor;
use Chess\Piece\Piece;

class Board
{
    private array $pieces = [];

    public function __construct()
    {
        $this->pieces = [];
    }

    public function placePiece(Piece $piece): void
    {
        $this->pieces[] = $piece;
    }

    public function getPiece(Position $position): ?Piece
    {
        return $this->squares[$position->getRow()][$position->getColumn()];
    }

    public function setPiece(Position $position, ?Piece $piece): void
    {
        $this->squares[$position->getRow()][$position->getColumn()] = $piece;
    }
}