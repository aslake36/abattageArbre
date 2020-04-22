<?php


namespace master;

use Cassandra\Date;
use function Sodium\add;

class Applicant
{
    private int $id;
    private string $civity;
    private string $firstname;
    private string $name;
    private string $society;
    private string $address;
    private string $city;
    private string $zipCode;
    private string $email;
    private string $phone;
    private string $constructPermit;
    private array $trees;

    public function __construct($id, $civity, $firstname, $name, $society, $address, $city, $zipCode, $email, $phone, $constructPermit, array $trees = [])
    {
        $this->id = $id;
        $this->civity = $civity;
        $this->firstname = $firstname;
        $this->name = $name;
        $this->society = $society;
        $this->address = $address;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->email = $email;
        $this->phone = $phone;
        $this->constructPermit = $constructPermit;
        $this->trees = $trees;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCivity(): string
    {
        return $this->civity;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSociety(): string
    {
        return $this->society;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getConstructPermit(): string
    {
        return $this->constructPermit;
    }

    /**
     * @return array
     */
    public function getTrees(): array
    {
        return $this->trees;
    }

    /******* SETTER ********/
    /**
     * @param array $trees
     */
    public function setTrees(array $trees): void
    {
        $this->trees[] = $trees;
    }
}

