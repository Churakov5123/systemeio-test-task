<?php

declare(strict_types=1);

namespace App\ApiBundle\Entity;

/**
 * @ORM\Table(name="tax")
 * @ORM\Entity(repositoryClass="App\ApiBundle\Repository\TaxRepository")
 */
class Tax
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(name="country_code", type="string",length=2)
     */
    private string $countryCode;

    /**
     * @ORM\Column(name="percent", type="integer")
     */
    private int $percent;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getPercent(): int
    {
        return $this->percent;
    }

    public function setPercent(int $percent)
    {
        $this->percent = $percent;
    }
}
