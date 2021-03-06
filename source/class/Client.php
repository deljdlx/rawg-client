<?php

namespace ElBiniou\Rawg;

//https://rawg.io/apidocs
//documentation : https://api.rawg.io/docs/?format=openapi

//@todo mettre une couche de cache
//@todo gérer la pagination

class Client
{

    protected $endPoints = [
        'categories' => '/genres',
        'tags' => '/tags',
        'platforms' => '/platforms',
        'games' => '/games',
    ];

    private $serviceURLRoot = 'https://api.rawg.io/api';

    /**
     * @return Platform[]
     */
    public function getPlatforms()
    {
        $data = $this->query($this->endPoints['platforms']);
        $platforms = [];
        foreach ($data['results'] as $platform) {
            unset($platform['games']);
            $instance = new Platform($this);
            $instance->loadFromArray($platform);
            $platforms[] = $instance;
        }
        return $platforms;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        $data = $this->query($this->endPoints['categories']);
        $categories = [];
        foreach ($data['results'] as $category) {
            unset($category['games']);

            $instance = new Category($this);
            $instance->loadFromArray($category);
            $categories[] = $instance;
        }
        return $categories;
    }

    /**
     * @param int $maxPage
     * @return Tag[]
     */
    public function getTags($pageStart = 1, $maxPage = 1)
    {
        $tags = [];

        $endPoint = $this->endPoints['tags'] . '?page=' . $pageStart;

        $pageCount = 0;
        do {

            $data = $this->query($endPoint);
            foreach ($data['results'] as $tag) {
                unset($tag['games']);
                $instance = new Tag($this);
                $instance->loadFromArray($tag);
                $tags[] = $instance;
                $endPoint = $data['next'];
            }
            $pageCount++;
        } while ($endPoint && $pageCount < $maxPage);

        return $tags;
    }

    public function getGames($pageStart = 1, $maxPage = 1)
    {
        $endPoint = $this->endPoints['games']. '?page=' . $pageStart;
        $pageCount = 0;
        $games = [];
        do {

            $data = $this->query($endPoint );
            foreach ($data['results'] as $game) {
                $instance = new Game($this);
                $instance->loadFromArray($game);
                $games[] = $instance;
                $endPoint = $data['next'];
            }
            $pageCount++;
        } while ($endPoint && $pageCount < $maxPage);

        return $games;
    }


    private function query($endPoint)
    {
        $endPoint = str_replace($this->serviceURLRoot, '', $endPoint);
        $data = file_get_contents($this->serviceURLRoot . $endPoint);
        return json_decode($data, true);
    }
}
