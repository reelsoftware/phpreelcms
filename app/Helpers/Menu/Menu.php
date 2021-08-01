<?php
namespace App\Helpers\Theme; 

use App\Helpers\Menu\MenuBuilder;

class Menu
{
    public static function dashboard(): MenuBuilder
    {
        $menu = new MenuBuilder();
        return $menu
            ->add('Dashboard', route('dashboard'))
            ->add('Movies', [
                'Show all' => route('movieDashboard'),
                'Create new' => route('movieCreate')
            ])
            ->add('Series', [
                'Show all' => route('seriesDashboard'),
                'Create new' => route('seriesCreate')
            ])
            ->add('Seasons', [
                '' => '',
                '' => ''
            ])
            ->add('Movies', [
                '' => '',
                '' => ''
            ])
            ->add('Movies', [
                '' => '',
                '' => ''
            ]);
    }
}