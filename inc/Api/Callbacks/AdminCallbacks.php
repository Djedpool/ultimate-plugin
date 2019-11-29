<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController 
{
	public function adminDashboard(){
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCpt(){
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}

	public function adminTaxonomy(){
		return require_once( "$this->plugin_path/templates/taxonomy.php" );
	}

	public function adminWidget(){
		return require_once( "$this->plugin_path/templates/widget.php" );
	}

	// Templates with input, this i great way we can validate input here
//	public  function  ultimateOptionsGroup($input) {
//        return $input;
//    }
//
//    public  function  ultimateAdminSection() {
//        echo 'Check this beautiful section!';
//    }

    public  function  ultimateTextExample() {
	    $value =  esc_attr(get_option('text_example'));

        echo '<input type="text" class="regular-text" name="text_example" value="'.$value.'" placeholder="Write Something Here!">';
    }

    public  function  ultimateFirstName() {
        $value =  esc_attr(get_option('first_name'));

        echo '<input type="text" class="regular-text" name="first_name" value="'.$value.'" placeholder="Give me your name or die!">';
    }
}