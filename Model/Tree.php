<?php


namespace master;


class Tree
{
    private float $coordx;
    private float $coordy;
    private string $type;

    /**
     * Tree constructor.
     * @param float $coordX
     * @param float $coordY
     * @param string $typeOfNeed
     */
    public function __construct(float $coordx, float $coordy, string $typeOfNeed)
    {
        $this->coordx = $coordx;
        $this->coordy = $coordy;
        $this->type = $typeOfNeed;
    }

    public function get_object_as_array() {
        return get_object_vars($this);
    }

    /**
     * @return float
     */
    public function getCoordx(): float
    {
        return $this->coordx;
    }

    /**
     * @return float
     */
    public function getCoordy(): float
    {
        return $this->coordy;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


}