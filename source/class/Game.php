<?php

namespace ElBiniou\Rawg;


class Game
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Platform[]
     */
    protected $plaforms = [];

    /**
     * @var Category[]
     */
    protected $categories = [];

    protected $data = [];


    /**
     * Game constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $data
     * @return $this
     */
    public function loadFromArray(array $data)
    {
        $this->data = $data;

        foreach ($this->data['platforms'] as $platformData) {
            $platform = new Platform($this->client);
            $platform->loadFromArray($platformData['plaform']);
            $this->plaforms[] = $platform;
        }

        foreach ($this->data['genres'] as $genreData) {
            $category = new Category($this->client);
            $category->loadFromArray($genreData);
            $this->categories[] = $category;
        }

        return $this;
    }

    /**
     * @return Platform[]
     */
    public function getPlarforms()
    {
        return $this->plaforms;
    }

}
