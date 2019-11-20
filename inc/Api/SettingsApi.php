<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Api;

class SettingsApi
{
    public $admin_pages = array();
    public $admin_subpages = array();    

    public function register() {
        if (!empty($this->admin_pages)) {
            add_action('admin_menu', array($this, 'addAdminMenu'));
        }
    }

    public function addPages(array $pages) {
        $this->admin_pages = $pages;   
        return $this; 
    }

    public function withSubPage(string $title = null) {
        if (empty($this->admin_pages)) {
            return $this;
        }

        $admin_page = $this->admin_pages[0];

        $subpage = array (
            array (
                'parent_slug' => $admin_page['menu_slug'], 
                'page_title'  => $admin_page['page_title'], 
                'menu_titile '=> $admin_page['menu_titile'], 
                'capability'  => $admin_page['capability'], 
                'menu_slug'   => $admin_page['menu_slug'],  
                'callback'    => function() { echo '<h1>RealEstate</h1>';}
            )
       );

       $this->admin_subpages = $subpage;

       return $this;
    }

    public function addAdminMenu() {
        foreach($this->admin_pages as $page) {
            add_menu_page($page['page_title'], $page['menu_titile'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);
        }
    }
}