<?php
namespace App\Helpers\Theme; 

class Categories
{
    /**
     * Return URL of all the content released in that particular year
     *
     * @param int $year
     * 
     */
    public static function releaseUrl(int $year)
    {
        return route('releaseShow', ['year' => $year]);
    }

    /**
     * Return URL of all the content released under that particular genre
     *
     * @param string $genre
     * 
     */
    public static function genreCategoryUrl(string $genre)
    {
        return route('genreShow', ['slug' => $genre]);
    }

    /**
     * Return URL of all the content released under that particular actor
     *
     * @param string $actor
     * 
     */
    public static function castActorCategoryUrl(string $actor)
    {
        return route('castShow', ['slug' => $actor]);
    }

    /**
     * Return URL of all the content released under that particular rating
     *
     * @param string $rating
     * 
     */
    public static function ratingCategoryUrl(string $rating)
    {
        return route('ratingShow', ['grade' => $rating]);
    }

}