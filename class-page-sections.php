<?php

namespace LSB\Boksok\Core;

class PageSections {

	var $taxonomies = array(
		'lsb_tax_topic' => 'Emne',
		'lsb_tax_author' => 'Forfatter',
		'lsb_tax_list' => 'Liste',
		'lsb_tax_series' => 'Serie',
		'lsb_tax_genre' => 'Sjanger',
		'lsb_tax_audience' => 'Målgruppe',
		'lsb_tax_age' => 'Alder',
		'lsb_tax_language' => 'Språk',
	);

	public function __construct() {
		add_action( 'acf/init', array( &$this, 'register_taxonomy_field_group' ) );
	}

	public function taxonomy_options ( $page_section_type, $is_multi_select ) {

		$taxonomy_options = array();

		$field_type = 'select';
		if( $is_multi_select ) {
			$field_type = 'multi_select';
		}

		foreach ($this->taxonomies as $key => $value) {
			$taxonomy_options[] = array (
				'key' => 'lsb_acf_page_section_taxonomy_'.$key,
				'label' => $value,
				'name' => 'lsb_page_section_taxonomy_'.$key,
				'display' => 'row',
				'max' => 1,
				'sub_fields' => array(
					array(
						'key' => 'lsb_acf_page_section_taxonomy_'.$key.'_terms',
						'label' => '',
						'name' => 'lsb_page_section_taxonomy_'.$key.'_terms',
						'type' => 'taxonomy',
						'taxonomy' => $key,
						'field_type' => $field_type,
						'return_format' => 'object',
						'multiple' => 0,
						'add_term' => 0,
					),
				),
			);
		}

		return $taxonomy_options;
	}

	public function register_taxonomy_field_group() {

		if( function_exists('acf_add_local_field_group') ) {

			acf_add_local_field_group(array (
				'key' => 'lsb_acf_page_sections_group',
				'title' => 'Taxonomy sections',
				'fields' => array (
					array (
						'key' => 'lsb_acf_page_sections',
						'label' => 'Blokker',
						'name' => 'lsb_page_sections',
						'type' => 'flexible_content',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'button_label' => 'Legg til blokk',
						'min' => '',
						'max' => 10,
						'layouts' => array (
							array (
								'key' => 'lsb_acf_page_section_books',
								'name' => 'lsb_page_section_books',
								'label' => 'Bøker',
								'display' => 'page_section',
								'sub_fields' => array (
									array (
										'key' => 'lsb_acf_page_section_books_title',
										'label' => 'Tittel',
										'name' => 'lsb_page_section_title',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array (
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array (
										'key' => 'lsb_acf_page_section_books_filters',
										'label' => 'Kriterie',
										'name' => 'lsb_page_section_filters',
										'type' => 'flexible_content',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array (
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'button_label' => 'Legg til kriterie',
										'min' => '',
										'max' => '1',
										'layouts' => $this->taxonomy_options('books', false)
									),
								),
								'min' => '',
								'max' => '',
							),
							array (
								'key' => 'lsb_acf_page_section_buttons',
								'name' => 'lsb_page_section_buttons',
								'label' => 'Knapper',
								'display' => 'page_section',
								'sub_fields' => array (
									array (
										'key' => 'lsb_acf_page_section_buttons_title',
										'label' => 'Tittel',
										'name' => 'lsb_page_section_title',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array (
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array (
										'key' => 'lsb_acf_page_section_buttons_filters',
										'label' => 'Knapper',
										'name' => 'lsb_page_section_filters',
										'type' => 'flexible_content',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array (
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'button_label' => 'Velg knapp(er) fra',
										'min' => '',
										'max' => '',
										'layouts' => $this->taxonomy_options('buttons', true)
									),
								),
								'min' => '',
								'max' => '',
							),
						),
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'taxonomy',
							'operator' => '==',
							'value' => 'lsb_tax_lsb_cat',
						),
					),
          array (
            array (
              'param' => 'page_template',
              'operator' => '==',
              'value' => 'template-frontpage.php',
            ),
          ),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
		}
	}
}
