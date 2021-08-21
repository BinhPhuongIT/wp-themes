<?php
/**
 * WP Job Manager - Job Submit Form
 */

// Check if WP Job Manager is installed
if( !class_exists( 'WP_Job_Manager' ) )
{
	add_shortcode('av_job_submit_form', 'avia_please_install_wpjm');
	return;
}

// Populate the backend shortcode options
if ( !class_exists( 'avia_sc_job_submit_form' ) )
{
	class avia_sc_job_submit_form extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['name']		= __('Job Submit Form', 'avia_framework' );
			$this->config['tab']		= __('Plugin Additions', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-comments.png";
			$this->config['order']		= 2;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_jobs_submit_form';
			$this->config['tooltip'] 	= __('Display the job submission form for WP Job Manager', 'avia_framework' );
			$this->config['drag-level'] = 3;
		}

		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		function popup_elements()
		{
			
		}

		/**
		 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
		 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
		 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
		 *
		 *
		 * @param array $params this array holds the default values for $content and $args.
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_element($params)
		{
			$params['innerHtml'] = "<img src='".$this->config['icon']."' title='".$this->config['name']."' />";
			$params['innerHtml'].= "<div class='avia-element-label'>".$this->config['name']."</div>";
			$params['content'] 	 = NULL; //remove to allow content elements
			return $params;
		}



		/**
		 * Frontend Shortcode Handler
		 *
		 * @param array $atts array of attributes
		 * @param string $content text within enclosing form of shortcode element
		 * @param string $shortcodename the shortcode found, when == callback name
		 * @return string $output returns the modified html string
		 */
		function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
		{
	
			$output  = '';
			$output .= '<section class="av_textblock_section" >';
			$output .= do_shortcode("[submit_job_form]");
			$output .= '</section>';
			
			return $output;
		}
	}
}
