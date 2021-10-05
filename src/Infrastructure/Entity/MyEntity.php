<?php

namespace App\Infrastructure\Entity;

use App\Domain\Model\MyModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MyEntity
 * @ORM\Entity(repositoryClass=MyEntityRepository::class)
 * @ORM\Table(name="myentity")
 */
class MyEntity extends MyModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private int $id;

    /**
     * @ORM\Column(name="uuid", type="string", length=100)
     * @var string
     */
    protected string $uuid;

    /**
     * @return int | null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
