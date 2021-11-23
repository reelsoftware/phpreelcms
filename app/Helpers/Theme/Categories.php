<?php
namespace App\Helpers\Theme; 

class Categories
{
    /**
     * Returns the URL of a specific category with a specific value
     *
     * @param  string  $categoryName name of the category to select content for
     * @param  string  $value to search for 
     * 
     */
    public static function categoryUrl(string $categoryName, string $value)
    {
        if($value != "")
        {
            return route('categoryShow', [
                'categoryName' => $categoryName,
                'value' => $value
            ]);
        }
    }

    /**
     * Returns the URL of the category that contains all the content released under that particular genre
     *
     * @param string $genre
     * 
     */
    public static function genreCategoryUrl(string $genre)
    {
        return route('genreShow', ['slug' => $genre]);
    }

    /**
     * Returns the URL of the category that contains all the content released under that particular actor.
     *
     * @param string $actor
     * 
     */
    public static function castActorCategoryUrl(string $actor)
    {
        return route('castShow', ['slug' => $actor]);
    }

    /**
     * Returns the URL of the category that contains all the content released under that particular rating
     *
     * @param string $rating
     * 
     */
    public static function ratingCategoryUrl(string $rating)
    {
        return route('ratingShow', ['grade' => $rating]);
    }

}