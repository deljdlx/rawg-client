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
    ];

    private $serviceURLRoot = 'https://api.rawg.io/api';



    public function getPlatforms()
    {
        $data = $this->query($this->endPoints['platforms']);
        $platforms = [];
        foreach ($data['results'] as $platform) {
            unset($platform['games']);
            $platforms[]= $platform;
        }
        return $platforms;
    }


    public function getCategories()
    {
        $data = $this->query($this->endPoints['categories']);
        $categories = [];
        foreach ($data['results'] as $category) {
            unset($category['games']);
            $categories[]= $category;
        }
        return $categories;
    }

    public function getTags($maxPage = 5)
    {
        $tags = [];

        $endPoint = $this->endPoints['tags'];

        $pageCount = 0;
        do {

            $data = $this->query($endPoint);
            foreach ($data['results'] as $tag) {
                unset($tag['games']);
                $tags[] = $tag;
                $endPoint = $data['next'];
            }
            $pageCount++;
        } while($endPoint && $pageCount < $maxPage);


        return $tags;
    }



    private function query($endPoint)
    {
        $endPoint = str_replace($this->serviceURLRoot, '', $endPoint);
        $data = file_get_contents($this->serviceURLRoot.$endPoint);
        return json_decode($data, true);
    }
}






