<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: Lists::class, mappedBy: 'item')]
    private Collection $list;

    public function __construct()
    {
        $this->list = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Lists>
     */
    public function getList(): Collection
    {
        return $this->list;
    }

    public function addList(Lists $list): static
    {
        if (!$this->list->contains($list)) {
            $this->list->add($list);
            $list->addItem($this);
        }

        return $this;
    }

    public function removeList(Lists $list): static
    {
        if ($this->list->removeElement($list)) {
            $list->removeItem($this);
        }

        return $this;
    }
}
