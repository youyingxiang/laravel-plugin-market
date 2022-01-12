<?php

namespace Yxx\LaravelPluginMarket\ValueObjects;


class Money
{
    const DEFAULT = 'CNY';

    public string $currency;

    public int $amountInCent;

    /**
     * @param  int  $amountInCent
     * @return Money
     */
    public static function withDefaultCurrency(int $amountInCent): Money
    {
        return new static(static::DEFAULT, $amountInCent);
    }

    /**
     * Money constructor.
     * @param string $currency
     * @param int $amountInCent
     */
    public function __construct(string $currency, int $amountInCent)
    {
        if ($amountInCent < 0) {
            throw new \InvalidArgumentException("无效金额 : {$amountInCent}");
        }

        $this->currency = $currency;
        $this->amountInCent = $amountInCent;
    }

    public function add(self $money): self
    {
        return new static($money->currency, $money->amountInCent + $this->amountInCent);
    }

    public function minus(self $money): self
    {
        $amount = $this->amountInCent - $money->amountInCent;

        if ($amount < 0) {
            throw new \InvalidArgumentException('无效的负金额');
        }

        return new static($this->currency, $amount);
    }

    public function multiply(int $number): self
    {
        return new static($this->currency, abs($number) * $this->amountInCent);
    }


    public function isGreater(self $money): bool
    {
        return $this->amountInCent > $money->amountInCent;
    }

    public function equals(self $money): bool
    {
        return $this->amountInCent === $money->amountInCent;
    }

    public function oneQuarter(): self
    {
        return new static($this->currency, (int) ($this->amountInCent / 4));
    }

    public function half(): self
    {
        return new static($this->currency, (int) ($this->amountInCent / 2));
    }

    public function isZero(): bool
    {
        return $this->amountInCent === 0;
    }

    public function amount(): float
    {
        return bcdiv($this->amountInCent , 100, 2);
    }

    public function toString(): string
    {
        return sprintf('%s %s', $this->currency, bcdiv($this->amountInCent , 100, 2));
    }
}
