<?php
/**
 * WP Resume Manager - Resume List
 */

// Check if WP Job Manager is installed
if( !class_exists( 'WP_Resume_Manager' ) )
{
	add_shortcode('av_resumelist', 'avia_please_install_wprm');
	return;
}

// Populate the backend shortcode options
if ( !class_exists( 'avia_sc_resumelist' ) )
{
	class avia_sc_resumelist extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['name']		= __('All Resume Listings', 'avia_framework' );
			$this->config['tab']		= __('Plugin Additions', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-sixth.png";
			$this->config['order']		= 4;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_resumes';
			$this->config['tooltip'] 	= __('Display a list of resumes', 'avia_framework' );
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
			$this->elements = array(

				array(
						"name" 	=> __("Which Categories?", 'avia_framework' ),
						"desc" 	=> __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework' ),
						"id" 	=> "resume_categories",
						"type" 	=> "select",
						"taxonomy" => "resume_category",
						"subtype" => "cat",
						"multiple"	=> 6
				),
				
				array(
						"name" 	=> __("Show Categories", 'avia_framework' ),
						"desc" 	=> __("Should job categories be displayed?", 'avia_framework' ),
						"id" 	=> "show_resume_categories",
						"type" 	=> "select",
						"std" 	=> "false",
						"subtype" => array(
						__('Yes',  'avia_framework' ) =>'true',
						__('No',  'avia_framework' ) =>'false')),

				array(
						"name" 	=> __("How Many?", 'avia_framework' ),
						"desc" 	=> __("How many items should be displayed?", 'avia_framework' ),
						"id" 	=> "resume_per_page",
						"type" 	=> "select",
						"std" 	=> "10",
						"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),
				
				array(
						"name" 	=> __("Sort By", 'avia_framework' ),
						"desc" 	=> __("Here you can choose what should be used when determining sort order", 'avia_framework' ),
						"id" 	=> "resume_order_by",
						"type" 	=> "select",
						"std" 	=> "date",
						"no_first"=>true,
						"subtype" => array( __('Sort by Resume Title', 'avia_framework' ) =>'title',
										    __('Sort by Resume ID', 'avia_framework' ) =>'id',
										    __('Sort by Publishing Date', 'avia_framework' ) =>'date',
											__('Sort by Random Order', 'avia_framework' ) =>'rand')),

				array(
						"name" 	=> __("Sorting Options", 'avia_framework' ),
						"desc" 	=> __("Here you can choose how to sort the resumes", 'avia_framework' ),
						"id" 	=> "resume_order",
						"type" 	=> "select",
						"std" 	=> "asc",
						"no_first"=>true,
						"subtype" => array( __('Sort by Ascending Values', 'avia_framework' ) =>'asc',
											__('Sort by Descending Values', 'avia_framework' ) =>'desc')),

				array(
						"name" 	=> __("Show Filters", 'avia_framework' ),
						"desc" 	=> __("Should job filters be displayed?", 'avia_framework' ),
						"id" 	=> "resume_show_filters",
						"type" 	=> "select",
						"std" 	=> "true",
						"subtype" => array(
						__('Yes',  'avia_framework' ) =>'true',
						__('No',  'avia_framework' ) =>'false')),

				);
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
			// $atts['class'] = $meta['el_class'];
			$custom_class = !empty($meta['custom_class']) ? $meta['custom_class'] : "";
			
			$atts =  shortcode_atts(array('resume_categories' => '', 
			                              'show_resume_categories' => 'false', 
			                              'resume_per_page' => '10',
			                              'resume_order_by' => 'date',
			                              'resume_order' => 'asc',
			                              'resume_show_filters' => 'true',
			                              ), $atts, $this->config['shortcode']);
		
			
			$output  = '';
			$output .= '<section class="av_textblock_section" >';
			$output .= do_shortcode("[resumes categories=" . $atts['resume_categories'] . " show_categories=" . $atts['show_resume_categories'] . " per_page=" . $atts['resume_per_page'] . " order_by=" . $atts['resume_order_by'] . " order=" . $atts['resume_order'] . " show_filters=" . $atts['resume_show_filters'] . "]");
			$output .= '</section>';
			
			return $output;
		}
	}
}

