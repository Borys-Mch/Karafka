<?php
/*  -------- A place for notes ----------






add_action( 'after_setup_theme', 'my_lang_ukr');
function my_lang_ukr(){
	load_theme_textdomain( 'karafka', trailingslashit( WP_LANG_DIR ) . 'themes' );
	load_theme_textdomain( 'karafka', get_template_directory() . '/languages' );
}
*/

add_action('after_setup_theme', 'my_theme_setup'); 
function my_theme_setup(){ 
	load_theme_textdomain('karafka', get_template_directory() . '/languages'); 
} 



add_action( 'storefront_header',function(){
	echo '<a class="tel-header" href="tel:+380800357150"> 0 800-359-312 </a>	';
}, 39);

add_action( 'storefront_header',function(){
	echo '<div class="header-login"><a class="my-account" href="https://karafka.com.ua/my-account/"> </a></div>';
}, 61);

add_action( 'storefront_header',function(){
	echo '<div class="header-login"><a class="my-wishlist" href="https://karafka.com.ua/wishlist"> </a></div>';
}, 61);

add_action( 'storefront_header',function(){
	echo '<div class="header-login"><a class="my-compare compare added" href="/product-category/posud/dlya-zbergannya-produktv/maslyanki-limonnic/?action=yith-woocompare-view-table&amp;iframe=yes" rel="nofollow"></a></div>';
}, 61);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_before_single_product', 'woocommerce_template_single_title', 11);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'woocust_sku_after_price', 25);
function woocust_sku_after_price(){
	global $product;
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<span class="sku_wrapper">Код товара: <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
	<?php endif;
}

add_action('woocommerce_single_product_summary', 'woocust_teg_price', 40);
function woocust_teg_price(){
	global $product;
	echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' );
}

// ............................................. Cod product ...........................................................................

add_action('woocommerce_product_options_sku', function(){
	?>
	<div class="options_group">
		<?php
		$arg = array(
			'id'                => 'cust_text_field',
			'label'             => 'Артику - 2',
			'placeholder'       => 'Текстове поле',
			'desc_tip'          => true,
			//'custom_attributes' => array('required' => 'required' ),
			'description'   => __( 'Введіть тут значення поля', 'woocommerce' ),
		);
		woocommerce_wp_text_input( $arg );
		?>
	</div>
	<?php
});

add_action( 'woocommerce_process_product_meta', function( $post_id ){
	$product	= wc_get_product( $post_id );

	$text_field = isset( $_POST['cust_text_field'] ) ? sanitize_text_field( $_POST['cust_text_field'] ) : '';
	$product->update_meta_data( 'cust_text_field', $text_field );
	$product->save();

}, 10, 1);

add_action( 'woocommerce_single_product_summary', function(){
	
	$product = wc_get_product();
	echo '<span class="art_two"><span>Артикул: </span>', get_post_meta( $product->get_id(), 'cust_text_field', true ), '</span>';

}, 25 );

add_action( 'woocommerce_single_product_summary', function(){
	
	$product = wc_get_product();
	echo '<span class="art_two"><span>Виробник: </span>', get_post_meta( $product->get_id(), 'Виробник:', true ), '</span>';

}, 25 );

/*

add_filter( 'woocust_teg_price', 'teg_icon' );   
function teg_icon() {
	$separator ='';
	$output = ''; //initialize clean output;
	$posttags = get_the_tags();
	 if ($posttags) {
	 $img_path = get_bloginfo('stylesheet_directory');
	 foreach($posttags as $tag) {
	 $image = 'tag_icon_' . $tag->slug . '.png';
   
	 $link = get_tag_link( $tag->term_id);
   
	 $output .= $separator . '<a href="' . $link . '">';
	 $separator =' &nbsp | &nbsp '; // this adds a space between the icons; you can change it
	 if(file_exists(STYLESHEETPATH.'/library/images/'.$image)) {
	  $output .= '<img src="' . $img_path.'/library/images/'.$image . ' " class="tag_icon" alt="tag ' . $tag->name .' icon" />  '. $tag->name .'  ';
	 } else {
	 $output .= $tag->name;
	 }
	$output .= '</a>';
	 }
	echo $output;
	 }
}

// ............................................. Add to cart ...........................................................................



<?php
 $separator ='';
 $output = ''; //initialize clean output;
 $posttags = get_the_tags();
  if ($posttags) {
  $img_path = get_bloginfo('stylesheet_directory');
  foreach($posttags as $tag) {
  $image = 'tag_icon_' . $tag->slug . '.png';

  $link = get_tag_link( $tag->term_id);

  $output .= $separator . '<a href="' . $link . '">';
  $separator =' &nbsp | &nbsp '; // this adds a space between the icons; you can change it
  if(file_exists(STYLESHEETPATH.'/library/images/'.$image)) {
   $output .= '<img src="' . $img_path.'/library/images/'.$image . ' " class="tag_icon" alt="tag ' . $tag->name .' icon" />  '. $tag->name .'  ';
  } else {
  $output .= $tag->name;
  }
 $output .= '</a>';
  }
 echo $output;
  }
 ?>




add_filter( 'woocommerce_product_single_add_to_cart_text', 'tb_woo_custom_cart_button_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'tb_woo_custom_cart_button_text' );   
function tb_woo_custom_cart_button_text() {
        return __( 'В кошик', 'woocommerce' );
}

add_filter( 'woocust_teg_price', 'wc_custom_replace_teg_text' );
function wc_custom_replace_teg_text( $html ) {
    return str_replace( ( 'Позначка', 'woocommerce' ), ( 'Значення', 'woocommerce' ), $html );
}


// View Cart, Update Cart, Proceed to Checkout
function tb_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Позначка:' :
            $translated_text = __( 'Значення:', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'tb_text_strings', 40  );
*/

// ......................................... Order by stock status ..............................................................
class iWC_Orderby_Stock_Status{
	public function __construct(){
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
		add_filter('posts_clauses', array($this, 'order_by_stock_status'), 2000);
	}
	}
	public function order_by_stock_status($posts_clauses){
	global $wpdb;
	if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {
		$posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
		$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
		$posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
	}
	return $posts_clauses;
	}
	}
	new iWC_Orderby_Stock_Status;


	add_filter( 'woocommerce_shortcode_products_query', function( $args, $atts, $loop_name ){
		if( $loop_name == 'product_category'){
		$args['meta_key'] = '_stock_status';
		$args['orderby'] = array('meta_value' => 'ASC', 'menu_order' => 'DESC');
		}
		return $args;
		}, 10, 3);

// ....................................................................................................................................

function storefront_credit() {
	$links_output = '';

	if ( apply_filters( 'storefront_credit_link', true ) ) {
		if ( storefront_is_woocommerce_activated() ) {
			$links_output .= '<a href="https://woocommerce.com" target="_blank" title="' . esc_attr__( 'WooCommerce - The Best eCommerce Platform for WordPress', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront &amp; WooCommerce', 'storefront' ) . '</a>.';
		} else {
			$links_output .= '<a href="https://woocommerce.com/storefront/" target="_blank" title="' . esc_attr__( 'Storefront -  The perfect platform for your next WooCommerce project.', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront', 'storefront' ) . '</a>.';
		}
	}

	if ( apply_filters( 'storefront_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
		$separator    = '<span role="separator" aria-hidden="true"></span>';
		$links_output = get_the_privacy_policy_link( '', ( ! empty( $links_output ) ? $separator : '' ) ) . $links_output;
	}

	$links_output = apply_filters( 'storefront_credit_links_output', $links_output );
	?>
	<div class="site-info">
		<?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( $links_output ) . ' 2020 - ' . gmdate( 'Y' ) ) ); ?>

		
	</div><!-- .site-info -->
	<?php
}
/**
 * Меняем ярлык "Распродажа" на процент скидки
 */
add_filter( 'woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3 );
function add_percentage_to_sale_badge( $html, $post, $product ) {
    if( $product->is_type('variable')){
        $percentages = array();
 
        // Get all variation prices
        $prices = $product->get_variation_prices();
 
        // Loop through variation prices
        foreach( $prices['price'] as $key => $price ){
            // Only on sale variations
            if( $prices['regular_price'][$key] !== $price ){
                // Calculate and set in the array the percentage for each variation on sale
                $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
            }
        }
        $percentage = max($percentages) . '%';
    } else {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();
 
        $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
    }
    return '<span class="onsale">' . esc_html__( '-', 'woocommerce' ) . ' ' . $percentage . '</span>';
}


