<?php

namespace ElBiniou\Rawg;


class Category
{

    protected $data = [
        'id' => '',
        'name' => '',
        'slug' => '',
        'games_count' => '',
        'image_background' => ''
    ];

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadFromArray(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getImage()
    {
        return $this->data['image_background'];
    }
}

