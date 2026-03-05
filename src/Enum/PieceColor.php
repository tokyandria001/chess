<?php

namespace Chess\Enum;

enum PieceColor
{
    case WHITE;
    case BLACK;

    public function opposite(): PieceColor
    {
        return match ($this) {
            PieceColor::WHITE => PieceColor::BLACK,
            PieceColor::BLACK => PieceColor::WHITE,
        };
    }
}