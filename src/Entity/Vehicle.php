<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    /*
        CAMPOS DE LA BASE DE DATOS
    */

    // ID del vehiculo y clave primaria (Debe ser un campo con valor unico para cada instancia)
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(unique: true)]
    private ?int $id = null;

    // Matricula del vehiculo (Debe ser un campo con valor unico para cada instancia)
    #[ORM\Column(length: 255, unique: true)]
    private ?string $plate = null;

    // Modelo del vehiculo
    #[ORM\Column(length: 255)]
    private ?string $model = null;

    // Marca del vehiculo
    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    // Color del vehiculo
    #[ORM\Column(length: 255)]
    private ?string $color = null;

    // Ruta de imagen del vehiculo
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $image_path = null;

    // Precio del vehiculo
    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    // Indica si el vehiculo ha sido vendido o no
    #[ORM\Column]
    private ?bool $sold = null;

    /*
        Metodos GET y SET para obtener Y modificar los valores de cada campo (excepto el ID)
    */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): static
    {
        $this->plate = $plate;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): static
    {
        $this->image_path = $image_path;

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

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): static
    {
        $this->sold = $sold;

        return $this;
    }
}
