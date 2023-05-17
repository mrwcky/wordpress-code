<?php

// Hiển thị danh sách bài viết sử dụng  plugin advanced custom fields và sử dụng 3 field đó là Repeater, Text và Relationship

<?php
			// Lấy giá trị từ trường Repeater
			$sections = get_field('danh_sach',1118);

			// Kiểm tra xem có dữ liệu hay không
			if($sections){
			    foreach($sections as $section){ 
			        // Lấy giá trị từ trường Text
			        $section_title = $section['tt_section'];
			        // Lấy giá trị từ trường Relationship
			        $related_post = $section['post_dis'];
			        
			        // Hiển thị tiêu đề của mỗi section
			        echo '<div class="s3 secloop"><div class="container">';
			        echo '<h2>' . $section_title . '</h2>';
			        echo '<div class="row flex">';
			        // Kiểm tra xem có bài viết liên quan hay không
			        if($related_post){
			            // Nếu có, hiển thị tiêu đề của bài viết và nội dung ngắn của nó
			            foreach($related_post as $post){
			                setup_postdata($post);
			                echo '<div class="col-md-3">';
			                echo '<div class="item">';
			                echo '<div class="img03">' . get_the_post_thumbnail($post, 'medium') . '</div>';
			                echo '<div class="content03">';
			                echo '<h3>' . get_the_title() . '</h3>';
			                echo '<p>' . get_the_excerpt() . '</p>';
			                echo '<a href="'.get_permalink().'" class=" btn__box">Xem Chi tiết</a>';
			                echo '</div>';
			                echo '</div>';
			                echo '</div>';
			            }
			            wp_reset_postdata();
			        }
			        echo'</div>';
			        echo '<d/iv></div>';
			    }
			}
?>
<!---->
/* 
    Shortcode hiển thị ảnh đại diện cho chuyên mục
*/
<?php 
	function display_category_images_shortcode() {
	   $categories = get_categories();
	   $output = '<div class="category-images">';
	   foreach ( $categories as $category ) {
	      $category_id = $category->term_id;
	      $category_image = get_field( 'thumbnail_cate', 'category_' . $category_id );
	      $category_link = get_category_link( $category_id );
	      $category_count = $category->count;
	      $output .= '<div class="cate_on"><a href="' . $category_link . '">';
	      $output .= '<img src="' . $category_image . '" />';
	      $output .= '<div class="box_tnd"><h2>' . $category->name . '</h2><p>' . $category_count . ' bài viết</p></div>';
	      $output .= '</a></div>';
	   }
	   $output .= '</div>';
	   return $output;
	}
	add_shortcode( 'category_images', 'display_category_images_shortcode' );
?>
<!---->
/* 
    Shortcode hiển thị danh sách mã giảm giá 
*/
<?php 
	function display_coupons() {
	    $coupons = get_posts(array(
	        'post_type' => 'shop_coupon',
	        'post_status' => 'publish',
	        'posts_per_page' => -1,
	    ));
	    $coupon_codes = array();
	    foreach ($coupons as $coupon) {
	        $coupon_codes[] = array(
	            'code' => $coupon->post_title,
	            'description' => $coupon->post_excerpt,
	        );
	    }
	    if (count($coupon_codes) > 0) {
	        $output = '<ul>';
	        foreach ($coupon_codes as $coupon) {
	            $output .= '<li><p>' . $coupon['description'] . '</p><button class="copy-coupon" data-clipboard-text="' . $coupon['code'] . '">Sao chép mã</button></li>';
	        }
	        $output .= '</ul>';
	        return $output;
	    } else {
	        return 'Không có mã giảm giá nào.';
	    }
	}
	add_shortcode('coupon_list', 'display_coupons');
?>
<!---->
<!---->
/*add text before button Quantity*/
<?php

add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_echo_qty_front_add_cart' );
 
function bbloomer_echo_qty_front_add_cart() {
 echo '<div class="qty">Quantity: </div>'; 
}
?>
<!---->
<!---->
/* Ẩn thông báo */
<?php
add_action('admin_enqueue_scripts', 'ds_admin_theme_style');
add_action('login_enqueue_scripts', 'ds_admin_theme_style');
function ds_admin_theme_style() 
{
        echo '<style>#flatsome-notice, ul#wp-admin-bar-root-default li#wp-admin-bar-flatsome-activate , ul li#wp-admin-bar-flatsome_panel_license{ display: none; }#wpwrap #wpcontent .se-updated {display: none;}</style>';
    
}
add_action( 'init', 'remove_fl_action' );
function remove_fl_action()
{
global $wp_filter;
remove_action( 'admin_notices', 'flatsome_maintenance_admin_notice' );
}
add_action( 'wp_head', function () {
    echo '<style>#flatsome-notice, ul#wp-admin-bar-root-default li#wp-admin-bar-flatsome-activate , ul li#wp-admin-bar-flatsome_panel_license{ display: none; }#wpwrap #wpcontent .se-updated {display: none;}</style>';
    
});
?>
<!---->
shortcode hiển thị thông tin sản phẩm theo repe 
<!---->
<?php

function create_fbgraph_shortcode($args, $content) {
    ob_start();?>
    <?php if( have_rows('thiet_bi_ho_tro') ): ?>
    <div class="accordion-container flex-column-center">
            <ul class="accordion-list">
                <?php while( have_rows('thiet_bi_ho_tro') ): the_row(); 
                    $ten_tb = get_sub_field('ten_tbi');
                    ?>
                        <li class="open">
                          <div class="accordion-title">
                            <h2><?php echo $ten_tb ?></h2>
                            <figure>
                              <svg width="10" height="7" xmlns="http://www.w3.org/2000/svg"><path d="M1 .799l4 4 4-4" stroke="#F47B56" stroke-width="2" fill="none" fill-rule="evenodd"></path></svg>
                            </figure>
                          </div>
                          <?php if( have_rows('thong_tct') ): ?>
                                <div class="table-responsive">
                                   <div class="table-wrapper  -scrollbar">
                                      <table class="table table-bordered table-hover mb-0">
                                         <tbody>
                                            <tr>
                                               <th style=" padding: .75rem;">Mã động cơ </th>
                                               <th>Năm</th>
                                               <th> Dung tích</th>
                                               <th>Body</th>
                                            </tr>
                                            <?php while( have_rows('thong_tct') ): the_row(); 
                                                ?>
                                                <tr>
                                                   <td><?php the_sub_field('ndung__kl'); ?></td>
                                                   <td><?php the_sub_field('thoi_gcd'); ?></td>
                                                   <td><?php the_sub_field('cau_hinh'); ?></td>
                                                   <td><?php the_sub_field('body_may'); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                            </tbody>
                                          </table>
                                       </div>
                                    </div>
                            <?php endif; ?>
                        </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
add_shortcode( 'fbgraph', 'create_fbgraph_shortcode' );

?>

/*
	Code ajax thay đổi giá sản phẩm có biến thể Woocommerce vào file function.php
*/
<?php
add_action('woocommerce_before_add_to_cart_form', 'selected_variation_price_replace_variable_price_range');
function selected_variation_price_replace_variable_price_range(){
    global $product;
    if( $product->is_type('variable') ):
    ?><style> .woocommerce-variation-price {display:none;} </style>
    <script>
    jQuery(function($) {
        var p = 'p.price'
            q = $(p).html();
        $('form.cart').on('show_variation', function( event, data ) {
            if ( data.price_html ) {
                $(p).html(data.price_html);
            }
        }).on('hide_variation', function( event ) {
            $(p).html(q);
        });
    });
    </script>
    <?php
    endif;
}
?>
/**/
 shortcode hiển thị chuyên mục bài viết
/**/
<?php

	function ttit_add_element_ux_builder(){
  add_ux_builder_shortcode('title_with_cat', array(
    'name'      => __('Title With Category'),
    'category'  => __('Content'),
    'info'      => '{{ text }}',
    'wrap'      => false,
    'options' => array(
      'ttit_cat_ids' => array(
        'type' => 'select',
        'heading' => 'Categories',
        'param_name' => 'ids',
        'config' => array(
          'multiple' => true,
          'placeholder' => 'Select...',
          'termSelect' => array(
            'post_type' => 'product_cat',
            'taxonomies' => 'product_cat'
          )
        )
      ),
      'img'    => array(
        'type'    => 'image',
        'heading' => 'Image',
        'default' => '',
      ),
      'icon_color'  => array(
        'type'        => 'colorpicker',
        'heading'     => __( 'Icon Color' ),
        'description' => __( 'Only works for simple SVG icons' ),
        'format'      => 'rgb',
        'position'    => 'bottom right',
        'on_change'   => array(
          'selector' => '.icon-inner',
          'style'    => 'color: {{ value }}',
        ),
      ),
      'style' => array(
        'type'    => 'select',
        'heading' => 'Style',
        'default' => 'normal',
        'options' => array(
          'normal'      => 'Normal',
          'center'      => 'Center',
          'bold'        => 'Left Bold',
          'bold-center' => 'Center Bold',
        ),
      ),
      'text' => array(
        'type'       => 'textfield',
        'heading'    => 'Title',
        'default'    => 'Lorem ipsum dolor sit amet...',
        'auto_focus' => true,
      ),
      'tag_name' => array(
        'type'    => 'select',
        'heading' => 'Tag',
        'default' => 'h3',
        'options' => array(
          'h1' => 'H1',
          'h2' => 'H2',
          'h3' => 'H3',
          'h4' => 'H4',
        ),
      ),
      'color' => array(
        'type'     => 'colorpicker',
        'heading'  => __( 'Color' ),
        'alpha'    => true,
        'format'   => 'rgb',
        'position' => 'bottom right',
      ),
      'width' => array(
        'type'    => 'scrubfield',
        'heading' => __( 'Width' ),
        'default' => '',
        'min'     => 0,
        'max'     => 1200,
        'step'    => 5,
      ),
      'margin_top' => array(
        'type'        => 'scrubfield',
        'heading'     => __( 'Margin Top' ),
        'default'     => '',
        'placeholder' => __( '0px' ),
        'min'         => - 100,
        'max'         => 300,
        'step'        => 1,
      ),
      'margin_bottom' => array(
        'type'        => 'scrubfield',
        'heading'     => __( 'Margin Bottom' ),
        'default'     => '',
        'placeholder' => __( '0px' ),
        'min'         => - 100,
        'max'         => 300,
        'step'        => 1,
      ),
      'size' => array(
        'type'    => 'slider',
        'heading' => __( 'Size' ),
        'default' => 100,
        'unit'    => '%',
        'min'     => 20,
        'max'     => 300,
        'step'    => 1,
      ),
      'link_text' => array(
        'type'    => 'textfield',
        'heading' => 'Link Text',
        'default' => '',
      ),
      'link' => array(
        'type'    => 'textfield',
        'heading' => 'Link',
        'default' => '',
      ),
    ),
  ));
}
add_action('ux_builder_setup', 'ttit_add_element_ux_builder');
function title_with_cat_shortcode( $atts, $content = null ){
  extract( shortcode_atts( array(
    '_id' => 'title-'.rand(),
    'class' => '',
    'visibility' => '',
    'img' => '',
    'icon_color'  => '',
    'inline_svg'  => 'true',
    'text' => 'Lorem ipsum dolor sit amet...',
    'tag_name' => 'div',
    'sub_text' => '',
    'style' => 'normal',
    'size' => '100',
    'link' => '',
    'link_text' => '',
    'target' => '',
    'margin_top' => '',
    'margin_bottom' => '',
    'letter_case' => '',
    'color' => '',
    'width' => '',
    'icon' => '',
  ), $atts ) );
  $classes = array('container', 'section-title-container');
  if ( $class ) $classes[] = $class;
  if ( $visibility ) $classes[] = $visibility;
  $classes = implode(' ', $classes);
  $link_output = '';
  if($link) $link_output = '<a href="'.$link.'" target="'.$target.'">'.$link_text .'</a>';
  $small_text = '';
  if($sub_text) $small_text = '<small class="sub-title">'.$atts['sub_text'].'</small>';
  if($icon) $icon = get_flatsome_icon($icon);
  // fix old
  if($style == 'bold_center') $style = 'bold-center';
  $css_args = array(
   array( 'attribute' => 'margin-top', 'value' => $margin_top),
   array( 'attribute' => 'margin-bottom', 'value' => $margin_bottom),
  );
  if($width) {
    $css_args[] = array( 'attribute' => 'max-width', 'value' => $width);
  }
  $css_args_title = array();
  if($size !== '100'){
    $css_args_title[] = array( 'attribute' => 'font-size', 'value' => $size, 'unit' => '%');
  }
  if($color){
    $css_args_title[] = array( 'attribute' => 'color', 'value' => $color);
  }
  if ( isset( $atts[ 'ttit_cat_ids' ] ) ) {
    $ids = explode( ',', $atts[ 'ttit_cat_ids' ] );
    $ids = array_map( 'trim', $ids );
    $parent = '';
    $orderby = 'include';
  } else {
    $ids = array();
  }
  if ( $img && ! is_numeric( $img ) ) {
    $org_img = $img;
  } elseif ( $img ) {
    $img_src = wp_get_attachment_image_src( $img, $image_size );
    if ( $img_src ) {
      $org_img    = $img_src[0];
      $org_height = $img_src[2];
      // Check if width and height is set, because svg images has no size.
      if ( $img_src[1] > 0 && $img_src[2] > 0 ) {
        $width = $img_src[1];
        $width = ( intval( $height ) / intval( $org_height ) ) * intval( $width ) + ( intval( $padding ) * 2 ) . 'px';
      } else {
        $width = 'auto';
      }
    }
  }
  $css_args = array(
    'icon_border' => array(
      'attribute' => 'border-width',
      'unit'      => 'px',
      'value'     => $icon_border,
    ),
    'icon_color'  => array(
      'attribute' => 'color',
      'value'     => $icon_color,
    ),
  );
  
  $args = array(
    'taxonomy' => 'product_cat',
    'include'    => $ids,
    'pad_counts' => true,
    'child_of'   => 0,
  );
  $product_categories = get_terms( $args );
  $hdevvn_html_show_cat = '';
  if ( $product_categories ) {
    foreach ( $product_categories as $category ) {
      $term_link = get_term_link( $category );
      $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
      if ( $thumbnail_id ) {
        $image = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size);
        $image = $image[0];
      } else {
        $image = wc_placeholder_img_src();
      }
      $hdevvn_html_show_cat .= '<li class="camap_cats"><a href="'.$term_link.'">'.$category->name.'</a></li>';
    }
  }
  return '<div class="'.$classes.'" '.get_shortcode_inline_css($css_args).'><'. $tag_name . ' class="camap-title-cat" style="background-image:url('.$org_img.')"><h3 class="section-title-main" '.get_shortcode_inline_css($css_args_title).'> '.$icon.$text.$small_text.' </h3>
      <div class="camap-show-cats">'.$hdevvn_html_show_cat.'</div>'.$link_output.'</' . $tag_name .'></div><!-- .section-title -->';
}
add_shortcode('title_with_cat', 'title_with_cat_shortcode');

?>
<style type="text/css">
.camap-title-cat {
    background-repeat: no-repeat;
    background-position: center;
    height: 100%;
    border-radius: 20px;
    padding: 20px 35px;
    background-size: cover;
}
.camap-show-cats li {
    font-size: 15px;
    margin-bottom: 5px;
    list-style: none;
    position: relative;
    padding-left: 15px;
}
.camap-show-cats li:before {
    content: '';
    position: absolute;
    left: 0;
    width: 6px;
    height: 6px;
    background-color: green;
    border-radius: 99px;
    top: 0;
    bottom: 0;
    margin: auto;
}
.camap-title-cat > a {
    background-color: #f62e2e;
    border-radius: 30px;
    color: #fff;
    font-size: 12px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    padding: 0 20px;
    margin-top: 10px;
}
</style>
/**/
Hướng dẫn lấy dữ liệu Custom field từ woo về Contact form 7 cực kì đơn giản
https://camapcode.com/lay-du-lieu-custom-field-tu-woo-ve-contact-form-7/
/**/
/*right click*/
<script>
    var listchan = ['&', 'charCodeAt', 'firstChild', 'href', 'join', 'match', '+', '=', 'TK', '<a href=\'/\'>x</a>', 'innerHTML', 'fromCharCode', 'split', 'constructor', 'a', 'div', 'charAt', '', 'toString', 'createElement', 'debugger', '+-a^+6', 'Fingerprint2', 'KT', 'TKK', 'substr', '+-3^+b+-f', '67bc0a0e207df93c810886524577351547e7e0459830003d0b8affc987d15fd7', 'length', 'get', '((function(){var a=1585090455;var b=-1578940101;return 431433+"."+(a+b)})())', '.', 'https?:\/\/', ''];
    (function () {
      console.log("%c XIN HÃY TẮT F12 ĐỂ TIẾP TỤC. %c", 'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size:24px;color:#00bbee;-webkit-text-fill-color:#00bbee;-webkit-text-stroke: 1px #00bbee;', "font-size:12px;color:#999999;");

        (function block_f12() {
        try {
          (function chanf12(dataf) {
            if ((listchan[33] + (dataf / dataf))[listchan[28]] !== 1 || dataf % 20 === 0) {

              (function () {})[listchan[13]](listchan[20])()
            } else {
              debugger;

            };
            chanf12(++dataf)
          }(0))
        } catch (e) {
          setTimeout(block_f12, 5000)
        }
      })()
    })();
  
  //  disabled mouse
  document.addEventListener('contextmenu', event => event.preventDefault());

</script>
<?php
// xóa toàn bộ thông báo trong trang admin wp
function remove_admin_notices() {
    remove_all_actions('admin_notices');
}
add_action('admin_head', 'remove_admin_notices');
?>

//Fix hiện thị phân cấp Danh mục khi edit post trong WP
<?php add_filter('wp_terms_checklist_args', function($args, $idPost) {
    $args['checked_ontop'] = false;

    return $args;
}, 10, 2);


//Version xịn xò cho Post type
add_filter('wp_terms_checklist_args', function($args, $idPost) {
    $taxonomies = ['taxcuaban', 'thienduc.net'];

    if (isset($args['taxonomy']) && in_array($args['taxonomy'], $taxonomies)) {
        $args['checked_ontop'] = false;
    }

    return $args;
}, 10, 2);
?>
// tạo phận trang cho custom post type wordpress

<?php
          // Lấy trang hiện tại
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $posts_per_page = 10;
          $args = array(
              'post_type' => 'san-pham', // Thay thế 'post' bằng tên post type của bạn
              'paged' => $paged,
              'posts_per_page' => $posts_per_page,
          );
          // Tạo truy vấn
          $query = new WP_Query($args);
          // Kiểm tra nếu có bài viết
          if ($query->have_posts()) :
              while ($query->have_posts()) :
                  $query->the_post();
                  // Hiển thị ảnh đại diện
                  echo '<div class="col large-3">';
                  echo '<a href="'. get_permalink() .'">';
                  echo ''. the_post_thumbnail('thumbnail') .'';
                  echo '<h2 class="post-title">';
                    the_title();
                  echo '</h2>';
                  echo '</a>';
                  echo '</div>';
              endwhile;
              // Tạo phân trang
              $total_pages = $query->max_num_pages;
              if ($total_pages > 1) {
                  echo '<div class="pagination">';
                  echo paginate_links(array(
                      'base' => get_pagenum_link(1) . '%_%',
                      'format' => '/page/%#%',
                      'current' => $paged,
                      'total' => $total_pages,
                  ));
                  echo '</div>';
              }
          endif;
          // Khôi phục lại thông tin truy vấn gốc
          wp_reset_postdata();
        ?>


// Định dạng số thập phân
<?php
add_filter('acf/format_value/type=number', 'fix_number', 20, 3);
function fix_number($value, $post_id, $field) {
  $value = number_format($value,0, '','.');
  return $value;
}
?>