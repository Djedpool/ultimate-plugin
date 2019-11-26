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
	public  function  ultimateOptionsGroup($input) {
        return $input;
    }

    public  function  ultimateAdminSection() {
        echo 'Check this beautiful section!';
    }

    public  function  ultimateTextExample() {
	    $value =  esc_attr(get_option('text_example'));

        echo '<input type="text" class="regular-text" name="text-example" value="'.$value.'" placeholder="Write Something Here!">';
    }



}