<?php
// Class Fibonacci - generate deret fibonacci dalam format tabel
class Fibonacci
{
    private int $rows;
    private int $cols;
    private const MAX_SIZE = 100;

    public function __construct(int $rows = 0, int $cols = 0)
    {
        $this->rows = max(0, min($rows, self::MAX_SIZE));
        $this->cols = max(0, min($cols, self::MAX_SIZE));
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function getCols(): int
    {
        return $this->cols;
    }

    public function hasData(): bool
    {
        return $this->rows > 0 && $this->cols > 0;
    }

    // Generate deret fibonacci
    public function generate(): array
    {
        $total = $this->rows * $this->cols;
        $fib = [];

        for ($i = 0; $i < $total; $i++) {
            if ($i === 0) {
                $fib[] = 0;
            } elseif ($i === 1) {
                $fib[] = 1;
            } else {
                $fib[] = $fib[$i - 1] + $fib[$i - 2];
            }
        }

        return $fib;
    }

    // Generate dalam format tabel 2D
    public function generateTable(): array
    {
        $sequence = $this->generate();
        $table = [];
        $index = 0;

        for ($r = 0; $r < $this->rows; $r++) {
            $row = [];
            for ($c = 0; $c < $this->cols; $c++) {
                $row[] = $sequence[$index] ?? '';
                $index++;
            }
            $table[] = $row;
        }

        return $table;
    }
}
