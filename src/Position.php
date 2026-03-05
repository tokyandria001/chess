<?php

namespace Chess;

class Position
{
    private int $row;
    private int $column;

    public function __construct(int $row, int $column)
    {
        if ($row < 0 || $row > 7){
            throw new \InvalidArgumentException("La ligne doit être entre 0 et 7., reçu: $row");
        }
        if ($column < 0 || $column > 7){
            throw new \InvalidArgumentException("La colonne doit être entre 0 et 7., reçu: $column");
        }
        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function equals(Position $other): bool
    {
        return $this->row === $other->getRow() && $this->column === $other->getColumn();
    }

    public function toKey(): string
    {
        return $this->row . ':' . $this->column;
    }

    public static function fromKey(string $key): Position
    {
        $parts = explode(':', $key);
        if (count($parts) !== 2) {
            throw new \InvalidArgumentException("Clé de position invalide: $key");
        }
        $row = (int)$parts[0];
        $column = (int)$parts[1];

        return new self($row, $column);
    }
}