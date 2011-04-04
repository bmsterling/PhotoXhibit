<?php
error_reporting(E_ERROR | E_WARNING);
/**
 *	
 */
include_once('core.php');

if(!class_exists("px_photograbber")){
	class px_photograbber extends px_core{
		function px_photograbber($_file_ = NULL){
			global $wpdb;
			parent::px_core($_file_);

			add_action('edit_page_form', array(&$this, 'add_photograbber_panel'));
			add_action('edit_form_advanced', array(&$this, 'add_photograbber_panel'));
		}
		
		function add_photograbber_panel(){
			$this->styles = array('panel.css','ui.flora.css');
			$this->js = array('jquery','ui','draggable','droppable','dimension','selectable','panels');
			$this->getOptions();
			if( $this->vars['use_manager'] == 1 ){
				$this->loadJs();
				$this->loadCss();
				$this->loadExternals('/common/inc/pages/parts/manager/panel.php');
			}
		}
	}  //  end : class px_photograbber
}  //  end : if(!class_exists("px_photograbber"))
?>