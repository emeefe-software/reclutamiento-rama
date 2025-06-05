<?php
namespace App\Library\Frontend;

/**
 * @author Abraham
 * 
 * Representa un elemento del menu del frontend
 */
class MenuItem{

    public $title;
    public $url;
    private $submenu;
    public $isSpecial;
    public $isSubItem;
    public $icon;

    public function __construct($config, $isSubItem = false){
        $this->title = isset($config['title']) ? $config['title']:'';
        $this->isSpecial = isset($config['is_special']) ? $config['is_special']:false;
        $this->url = isset($config['url']) ? $config['url']:(isset($config['route_name']) ? route($config['route_name']):'#');
        $this->icon = isset($config['icon']) ? $config['icon'] : null;
        $this->defineSubmenuFromConfig($config);    
        $this->isSubItem = $isSubItem;    
    }

    private function defineSubmenuFromConfig($config){
        if(isset($config['submenu']) && is_array($config) && count($config)>0){
            $this->submenu = [];

            foreach ($config['submenu'] as $subItem) {
                $this->submenu[] = new self($subItem, true);
            }
        }else{
            $this->submenu = null;
        }
    }

    public function hasSubMenu(){
        return !!$this->submenu;
    }

    public function getSubMenu(){
        return $this->hasSubMenu() ? $this->submenu : [];
    }

    public function isSpecial(){
        return $this->isSpecial;
    }

    public function hasIcon(){
        return !!$this->icon;
    }
}