<?php

namespace madmis\CoingeckoApi\Model;

/**
 * Class Price
 * @package madmis\CoingeckoApi\Model
 */
class Price
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date): void
    {
        $this->date = new \DateTime("@$date");
    }
}
