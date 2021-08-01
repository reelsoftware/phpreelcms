<?php
namespace App\Helpers\Menu; 

class MenuBuilder
{
    /**
    * @var array containing the structure of the whole menu as key-value pairs (key is the name, value is the url)
    */
    private $menu;

    /**
     * Add new items to the menu
     *
     * @param $name name of the menu item or dropdown menu item
     * @param $value url or array of dropdown items
     * 
     * @return MenuBuilder
     */
    public function add($name, $value)
    {
        $this->menu[$name] = $value;

        return $this;
    }

    /**
     * Add new items to an existing dropdown menu
     *
     * @param $name name of the menu item or dropdown menu item
     * @param $value url or array of dropdown items
     * 
     * @return MenuBuilder
     */
    public function append($name, $value)
    {
        $this->menu[$name] = $this->menu[$name] + $value;

        return $this;
    }

    /**
     * Add new items to the menu after a specified item that is already contained in the menu
     *
     * @param $name name of the menu item or dropdown menu item
     * @param $value url or array of dropdown items
     * @param $afterItem name of the reference item after which we want to insert a new menu item
     * 
     * @return MenuBuilder
     */
    public function addAfter($name, $value, $afterItem)
    {
        $this->menu[$name] = $value;

        //Get the position where the new value should go
        $position = 0;

        foreach($this->menu as $key => $value)
        {
            $position++;

            if($key == $afterItem)
                break;
        }

        //Insert the value at the give position
        $this->menu = array_slice($this->menu, 0, $position, true) +
            array($name => $value) +
            array_slice($this->menu, $position, count($this->menu) - $position, true);

        return $this;
    }

    /**
     * Return the generated menu as an array
     * 
     * @return array
     */
    public function generate()
    {
        return $this->menu;
    }
}