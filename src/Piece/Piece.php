<?php

namespace Chess\Piece;

use Chess\Position;
use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;
use Chess\Contract\Renderable;

abstract class Piece implements Renderable
{
    protected PieceColor $color;
    protected Position $position;
    protected PieceType $type;

    public function __construct(PieceColor $color, Position $position)
    {
        $this->color = $color;
        $this->position = $position;
    }

    public function getColor(): PieceColor
    {
        return $this->color;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }   

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

    public function getType(): PieceType
    {
        return $this->type;
    }

    public function render(): string
    {
        return $this->color->name . ' ' . $this->type->name;
    }

    public function canMove($board, Position $newPosition): bool
    {
        if ($this->position->equals($target)){
            return false; // Ne peut pas rester sur la même position
        }

        if (!$this->isValidMovementShape($target)){
            return false; // Mouvement non conforme à la pièce
        }

        if ($this->canCapture($board, $target) === false){
            return false; // Peut capturer une pièce adverse
        }

        if ($this->type !== \Chess\Enum\PieceType::KNIGHT){
            if (!$this->isPathClear($board, $target)){
                return false; // Chemin obstrué pour les pièces autres que le cavalier
            }
        }

        if ($this->type == \Chess\Enum\PieceType::KNIGHT){
            if (!$this->isPawnMoveValid($board, $target)){
                return false; // Chemin obstrué pour les pièces autres que le cavalier
            }
        }

        return true; // Mouvement valide
    }
}