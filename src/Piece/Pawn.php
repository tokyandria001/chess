<?php

namespace Chess\Piece;

use Chess\Position;
use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;

class Pawn extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::PAWN;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $fromRow = $this->position->getRow();
        $fromCol = $this->position->getColumn();
        $toRow = $target->getRow();
        $toCol = $target->getColumn();

        $rowDifference = $toRow - $fromRow;
        $colDifference = abs($toCol - $fromCol);

        if ($this->color === \Chess\Enum\PieceColor::WHITE) {
            // Mouvement vers le haut
            if ($rowDifference <= 0) {
                return false; // Les pions blancs ne peuvent pas reculer
            }
        } else {
            // Mouvement vers le bas
            if ($rowDifference >= 0) {
                return false;
            }
        }

        if ($colDifference > 0) {
        // Mouvement diagonal (capture)
        return abs($rowDifference) === 1 && $colDifference === 1;
        } 
    
        return abs($rowDifference) === 1 || (abs($rowDifference) === 2);
    }

    protected function isPawnMoveValid($board, Position $target): bool
    {
        $fromRow = $this->position->getRow();
        $toRow = $target->getRow();
        $fromCol = $this->position->getColumn();
        $toCol = $target->getColumn();

        $rowDifference = $toRow - $fromRow;
        $colDifference = abs($toCol - $fromCol);

        // Cas 1 : Capture diagonale
        if ($colDifference === 1) {
            // Il DOIT y avoir une pièce ennemie sur la case cible
            $targetPiece = $board->getPieceAt($target);
            return $targetPiece !== null && $targetPiece->getColor() !== $this->color;
        }

        // Cas 2 : Avance simple ou double (même colonne)
        // Vérifier que la case cible est vide
        if ($board->getPieceAt($target) !== null) {
            return false;
        }

        // Avance double : doit être depuis la position initiale du pion
        if (abs($rowDifference) === 2) {
            // WHITE : position initiale à la ligne 6
            // BLACK : position initiale à la ligne 1
            if ($this->color === \Chess\Enum\PieceColor::WHITE) {
                if ($fromRow !== 6) {
                    return false;
                }
            } else {
                if ($fromRow !== 1) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function canCapture($board, Position $target): bool
    {
        $colDifference = abs($target->getColumn() - $this->position->getColumn());

        if ($colDifference === 1) {
            return true;
        }

        $targetPiece = $board->getPieceAt($target);
        return $targetPiece === null;
    }
}