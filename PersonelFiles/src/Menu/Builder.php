<?php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createDefaultMenu(array $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Default', ['route' => 'default']);
        $menu->addChild('Person', ['route' => 'person']);

        // Dodaj tutaj więcej elementów menu dla modułu `default`

        return $menu;
    }


    public function createPersonMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav me-auto mb-2 mb-md-0');

        $menu->addChild('Default', ['route' => 'default']);

        $menu->addChild('Person Home', ['route' => 'person_index']);
        $menu->addChild('Add Person', ['route' => 'person_add']);
        $menu->addChild('Show all persons', ['route' => 'person_all']);

        return $menu;
    }

}