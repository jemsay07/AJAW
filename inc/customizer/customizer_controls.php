<?php
/**
 * This where all the customizer controls store,
 *
 * @package AJAW
 */

/**
 * Radio image customize control
 */
class Ajaw_Customize_Radio_Image extends WP_Customize_Control{

    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    
    public $type = 'radio-image';
	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	
	public function enqueue(){

		wp_enqueue_script( 'ajaw-customize-controls' );
		wp_enqueue_script( 'ajaw-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/assets/customize-controls.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'ajaw-image-select', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/assets/customizer-controls.css' );
	}
   
    /**
     * Add custom JSON parameters to use in the JS template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    
    public function to_json() {
		parent::to_json();

		// Create the image URL. Replaces the %s placeholder with the URL to the customizer /images/ directory.
		foreach ( $this->choices as $value => $args ) {
			$this->choices[ $value ]['url'] = esc_url( sprintf( $args['url'], get_template_directory_uri() . '/inc/customizer/assets/images/' ) );
		}

		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
		$this->json['id']      = $this->id;
	}

	/**
	 * An Underscore (JS) template for this control's content.
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since  1.1
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# for ( key in data.choices ) { #>

			<label for="{{ data.id }}-{{ key }}">
				<span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
				<input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />
				<img src="{{ data.choices[ key ]['url'] }}" alt="{{ data.choices[ key ]['label'] }}" />
			</label>
		<# } #>
		<?php
	}
}

/**
 * Multiple Checkbox customize control class
 */
class Ajaw_Customize_Control_Checkbox_Multiple extends WP_Customize_Control{

    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    
    public $type = 'checkbox-multiple';

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	
	public function enqueue(){
		wp_enqueue_script( 'ajaw-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/assets/customize-controls.js', array( 'jquery' ) );
	}

    /**
     * Displays the control content.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    
    public function ajaw_content(){
    	if ( empty( $this->choices ) )  return; ?>

    	 <?php if ( !empty( $this->label ) ) : ?>
    		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    	<?php endif; //label ?>

    	<?php if ( ! empty( $this->description ) ): ?>
    		<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    	<?php endif; //descriptions ?>
    	<?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

    	<ul>
    		<?php foreach ( $this->choices as $value => $label): ?>
    			<li>
    				<label>
    					<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> >
    					<?php echo esc_html( $label ); ?>
    				</label>
    			</li>
    		<?php endforeach; ?>
    	</ul>

    	<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
    <?php 
	}
}

/**
 * Ajaw Customize Category
 */
class Ajaw_Customize_Category_Control extends WP_Customize_Control{
    
    public $type = 'dropdown-category';

    protected $dropdown_args = false;

    protected function render_content(){ ?>
        <label>
            <?php 
                if ( !empty( $this->label ) ) {
                    ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php
                }
                if ( !empty( $this->description ) ) {
                    ?>
                    <span class="description customize-control-title"><?php echo esc_html( $this->description ); ?></span>
                    <?php
                }

                $value = array(
                    'taxonomy'          => 'category',
                    'show_option_none'  => '',
                    'selected'          => $this->value(),
                    'show_option_all'   => __( 'All', 'ajaw' ),
                    'orderby'           => 'id',
                    'order'             => 'ASC',
                    'show_count'        => 1,
                    'hide_empty'        => 1,
                    'child_of'          => 0,
                    'depth'             => 0,
                    'tab_index'         => 0,
                    'hide_if_empty'     => false,
                    'option_none_value' => 0,
                    'value_field'       => 'term_id',
                );

                $dropdown_args = wp_parse_args( $this->dropdown_args, $value );

                $dropdown_args['echo'] = false;
                $dropdown = wp_dropdown_categories( $dropdown_args );
                $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

                echo $dropdown;
            ?>
        </label>
    <?php }
}

function ajaw_customizer_control_scripts(){
    wp_enqueue_script( 'ajaw-customizer', get_template_directory_uri() . '/inc/customizer/assets/customize-controls.js', array( 'customize-controls' ) );
    wp_enqueue_style( 'ajaw-customizer',  get_template_directory_uri() . '/inc/customizer/assets/customizer-controls.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ajaw_customizer_control_scripts', 99 );