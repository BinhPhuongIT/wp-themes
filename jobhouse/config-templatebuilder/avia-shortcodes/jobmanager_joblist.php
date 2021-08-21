<?php
/**
 * WP Job Manager - Job List
 */

// Check if WP Job Manager is installed
if( !class_exists( 'WP_Job_Manager' ) )
{
	add_shortcode('av_joblist', 'avia_please_install_wpjm');
	return;
}

// Populate the backend shortcode options
if ( !class_exists( 'avia_sc_joblist' ) )
{
	class avia_sc_joblist extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['name']		= __('All Job Listings', 'avia_framework' );
			$this->config['tab']		= __('Plugin Additions', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-blog.png";
			$this->config['order']		= 1;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_jobs';
			$this->config['tooltip'] 	= __('Display a list of jobs', 'avia_framework' );
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
						"id" 	=> "categories",
						"type" 	=> "select",
						"taxonomy" => "job_listing_category",
						"subtype" => "cat",
						"multiple"	=> 6
				),
				
				array(
						"name" 	=> __("Show Categories", 'avia_framework' ),
						"desc" 	=> __("Should job categories be displayed?", 'avia_framework' ),
						"id" 	=> "show_categories",
						"type" 	=> "select",
						"std" 	=> "false",
						"subtype" => array(
						__('Yes',  'avia_framework' ) =>'true',
						__('No',  'avia_framework' ) =>'false')),

				array(
						"name" 	=> __("How Many?", 'avia_framework' ),
						"desc" 	=> __("How many items should be displayed?", 'avia_framework' ),
						"id" 	=> "per_page",
						"type" 	=> "select",
						"std" 	=> "10",
						"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),
				
				array(
						"name" 	=> __("Sort By", 'avia_framework' ),
						"desc" 	=> __("Here you can choose what should be used when determining sort order", 'avia_framework' ),
						"id" 	=> "order_by",
						"type" 	=> "select",
						"std" 	=> "date",
						"no_first"=>true,
						"subtype" => array( __('Sort by Job Title', 'avia_framework' ) =>'title',
										    __('Sort by Job ID', 'avia_framework' ) =>'id',
										    __('Sort by Publishing Date', 'avia_framework' ) =>'date',
											__('Sort by Random Order', 'avia_framework' ) =>'rand')),

				array(
						"name" 	=> __("Sorting Options", 'avia_framework' ),
						"desc" 	=> __("Here you can choose how to sort the jobs", 'avia_framework' ),
						"id" 	=> "order",
						"type" 	=> "select",
						"std" 	=> "asc",
						"no_first"=>true,
						"subtype" => array( __('Sort by Ascending Values', 'avia_framework' ) =>'asc',
											__('Sort by Descending Values', 'avia_framework' ) =>'desc')),

				array(
						"name" 	=> __("Show Filters", 'avia_framework' ),
						"desc" 	=> __("Should job filters be displayed?", 'avia_framework' ),
						"id" 	=> "show_filters",
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
			
			$atts =  shortcode_atts(array('categories' => '', 
			                              'show_categories' => true, 
			                              'per_page' => '10',
			                              'order_by' => 'date',
			                              'order' => 'asc',
			                              'show_filters' => true,
			                              ), $atts, $this->config['shortcode']);
		
			
			$output  = '';
			$output .= '<section class="av_textblock_section" >';
			// $output .= do_shortcode("[jobs categories=" . $atts['categories'] . " show_categories=" . $atts['show_categories'] . " per_page=" . $atts['per_page'] . " order_by=" . $atts['order_by'] . " order=" . $atts['order'] . " show_filters=" . $atts['show_filters'] . "]");
			
			// Categories set
			if (!(empty($atts['categories']))) 
			{
				$output .= do_shortcode("[jobs categories=" . $atts['categories'] . " show_categories=" . $atts['show_categories'] . " per_page=" . $atts['per_page'] . " order_by=" . $atts['order_by'] . " order=" . $atts['order'] . " show_filters=" . $atts['show_filters'] . "]");
			} 
			
			// Categories not set
			else 
			{
				$output .= do_shortcode("[jobs show_categories=" . $atts['show_categories'] .  " per_page=" . $atts['per_page'] . " order_by=" . $atts['order_by'] . " order=" . $atts['order'] . " show_filters=" . $atts['show_filters'] . " ]");
			}


			$output .= '</section>';
			
			return $output;
		}
	}
}


