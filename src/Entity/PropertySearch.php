<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

    private $maxPrice;

    /**
     * @Assert\Range(min=10, max=400, minMessage="La surface doit faire au moins 10m²", 
     * maxMessage="La surface ne doit pas faire plus de 400m²")
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct(){
        $this->options = new ArrayCollection();
    }

    public function getMaxPrice(){
        return $this->maxPrice;
    }

    public function getMinSurface(){
        return $this->minSurface;
    }

    public function setMaxPrice(int $maxPrice){
        $this->maxPrice = $maxPrice;
        return $this->maxPrice;
    }

    public function setMinSurface(int $minSurface){
        $this->minSurface = $minSurface;
        return $this->minSurface;
    }

    public function getOptions() : ArrayCollection{
        return $this->options;
    }

    public function setOptions(ArrayCollection $options){
        $this->options = $options;
    }

}