<?php


namespace App\Services\JobSearch;


use App\Entity\Category;

class SearchData
{
    /**
     * @var string
     */
    private $q;

    /**
     * @var Category[]
     */
    private $categories = [];

    /**
     * @var array
     */
    private $places = [];

    /**
     * @var array
     */
    private $contracts = [];

    /**
     * @var array
     */
    private $experiences = [];

    public function getQ()
    {
        return $this->q;
    }

    public function getCategories():? array
    {
        return $this->categories;
    }

    public function getPlaces():? array
    {
        return $this->places;
    }

    public function getContracts(): ? array
    {
        return $this->contracts;
    }

    public function getExperiences():? array
    {
        return $this->experiences;
    }

    public function setQ($q)
    {
        $this->q = $q;
        return $this;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    public function setPlaces($places)
    {
        $this->places = $places;
        return $this;
    }

    public function setContracts($contracts)
    {
        $this->contracts = $contracts;
        return $this;
    }

    public function setExperiences($experiences)
    {
        $this->experiences = $experiences;
        return $this;
    }

}