<?php

namespace Chess;

use Chess\Enum\PieceColor;
use Chess\Enum\PieceType;
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
        $key = $piece->getPosition()->toKey();
        $this->pieces[$key] = $piece;
    }

    public function getPieceAt(Position $position): ?Piece
    {
        $key = $position->toKey();
        return $this->pieces[$key] ?? null;
    }

    public function hasPieceAt(Position $position): bool
    {
        $key = $position->toKey();
        return isset($this->pieces[$key]);
    }

    public function removePieceAt(Position $position): void
    {
        $key = $position->toKey();
        unset($this->pieces[$key]);
    }

    public function movePiece(Position $from, Position $to): void
    {
        $piece = $this->getPieceAt($from);
        if ($piece === null) {
            throw new \Chess\Exception\NoPieceException($from);
        }

        $this->removePieceAt($from);

        if ($this->hasPieceAt($to)) {
            $this->removePieceAt($to);
        }

        $piece->setPosition($to);
        $this->placePiece($piece);
    }

    public function isPathClear(Position $from, Position $to): bool
    {
        $fromRow = $from->getRow();
        $fromCol = $from->getColumn();  // ✅ CORRIGÉ: getCol() → getColumn()
        $toRow = $to->getRow();
        $toCol = $to->getColumn();      // ✅ CORRIGÉ: getCol() → getColumn()

        $rowStep = 0;
        $colStep = 0;

        if($toRow > $fromRow) {
           $rowStep = 1;
        } elseif ($toRow < $fromRow) {
            $rowStep = -1;
        }

        if($toCol > $fromCol) {
            $colStep = 1;
        } elseif ($toCol < $fromCol) {
            $colStep = -1;
        }

        $currentRow = $fromRow + $rowStep;
        $currentCol = $fromCol + $colStep;

        while ($currentRow !== $toRow || $currentCol !== $toCol) {
            $currentPos = new Position($currentRow, $currentCol);

            if ($this->hasPieceAt($currentPos)) {
                return false;
            }

            $currentRow += $rowStep;
            $currentCol += $colStep;
        }
        return true;
    }

    public function getPieces(): array
    {
        return array_values($this->pieces);
    }

    public function getKingPosition(PieceColor $color): ?Position
    {
        foreach ($this->pieces as $piece) {
            // ✅ CORRIGÉ: 'king' → PieceType::KING
            if ($piece->getType() === PieceType::KING && $piece->getColor() === $color) {
                return $piece->getPosition();
            }
        }
        return null;
    }

    public function render(): string
    {
        $output = "  0 1 2 3 4 5 6 7\n";

        for ($row = 0; $row < 8; $row++) {
            $output .= $row . " ";
            for ($col = 0; $col < 8; $col++) {
                $position = new Position($row, $col);
                if ($this->hasPieceAt($position)) {
                    $piece = $this->getPieceAt($position);
                    // ✅ CORRIGÉ: getSymbol() → afficher première lettre du type
                    $typeName = $piece->getType()->name;
                    $letter = substr($typeName, 0, 1);
                    
                    if ($piece->getColor() === PieceColor::WHITE) {
                        $letter = strtoupper($letter);
                    } else {
                        $letter = strtolower($letter);
                    }
                    
                    $output .= $letter . " ";
                } else {
                    $output .= ". ";
                }
            }
            $output .= "\n";
        }
        return $output;
    }

    public function clear(): void
    {
        $this->pieces = [];
    }

    public function count(): int
    {
        return count($this->pieces);
    }
}