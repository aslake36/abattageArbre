<?php


namespace master;


class Tree
{
    private float $coordX;
    private float $coordY;
    private string $typeOfNeed;

    /**
     * Tree constructor.
     * @param float $coordX
     * @param float $coordY
     * @param string $typeOfNeed
     */
    public function __construct(float $coordX, float $coordY, string $typeOfNeed)
    {
        $this->coordX = $coordX;
        $this->coordY = $coordY;
        $this->typeOfNeed = $typeOfNeed;
    }

    public function get_object_as_array() {
        return get_object_vars($this);
    }

    /**
     * @return float
     */
    public function getCoordX(): float
    {
        return $this->coordX;
    }

    /**
     * @return float
     */
    public function getCoordY(): float
    {
        return $this->coordY;
    }

    /**
     * @return string
     */
    public function getTypeOfNeed(): string
    {
        return $this->typeOfNeed;
    }


}