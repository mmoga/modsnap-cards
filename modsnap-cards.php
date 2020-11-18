<?php
/**
 * Plugin Name: Modsnap Custom Cards
 * Description: A custom plugin made for Dindy with ❤️. This imitates AWSM Team cards, but makes it more adpated for what Modsnap needs.
 * Version: 1.0
 * Author: Matthew Mogavero
 * Author URI: https://mogavero.dev
 * Text domain: modsnap-cards
 *
 * @package modsnap-custom-cards
 */

add_action("wp_enqueue_scripts", "modsnap_cards_external");
function modsnap_cards_external()
{
  wp_enqueue_style("modsnap-cards", plugin_dir_url(__FILE__) . "/css/ms-cards.css");
  wp_enqueue_script("modsnap-cards", plugin_dir_url(__FILE__) . "/js/drawer.js");
}


/*add_action("wp_footer", "mfp_Add_Text");
function mfp_Add_Text()
{
  echo "<p>TEST</p>";
  $query = new WP_Query(["post-type" => "modsnap_card"]);
  if ($query->have_posts()) {
    echo "<div>";
    while ($query->have_posts()) {
      $query->the_post(); ?>
<div>
  <?php the_post_thumbnail("thumbnail"); ?>
</div>
<?php
    }
    echo "</div>";
  }
}*/
// Register card post type
add_action("init", "modsnap_register_post_type");
function modsnap_register_post_type()
{
  $labels = [
    "name" => __("Cards"),
    "singular_name" => __("Card"),
    "add_new" => __("Add New", "modsnap-cards"),
    "add_new_item" => __("Add New Card"),
    "featured_image" => "Card Image",
    "set_featured_image" => "Add Card Image",
  ];
  $args = [
    "labels" => $labels,
    "has_archive" => true,
    "public" => true,
    "hierarchical" => false,
    "supports" => [
      "title",
      "editor",
      // 'excerpt',
      // 'custom-fields',
      "thumbnail",
      // 'page-attributes',
    ],
    "rewrite" => ["slug" => "cards"],
    "show_in_rest" => true,
    "show_in_admin_bar" => false,
    "show_in_nav_menus" => false,
    "publicly_queryable" => false,
    "query_var" => false,
    "menu_position" => 20,
    "menu_icon" => "dashicons-grid-view",
  ];
  register_post_type("modsnap_card", $args);
}

function modsnap_get_backend_preview_thumb($post_ID)
{
  $post_thumbnail_id = get_post_thumbnail_id($post_ID);
  if ($post_thumbnail_id) {
    $post_thumbnail_img = wp_get_attachment_image_src(
      $post_thumbnail_id,
      "thumbnail"
    );
    return $post_thumbnail_img[0];
  }
}

add_filter("manage_modsnap_card_posts_columns", "modsnap_filter_posts_columns");
function modsnap_filter_posts_columns($columns)
{
  $columns = [
    "cb" => '<input type="checkbox" />',
    "featured_image" => __("Image", "modsnap-cards"),
    "title" => __("Name", "modsnap-cards"),
    "subheading" => __("Subheading", "modsnap-cards"),
    "taxonomy-modsnap_category" => __("Categories", "modsnap-cards"),
    "date" => __("Date"),
  ];
  return $columns;
}

add_action(
  "manage_modsnap_card_posts_custom_column",
  "modsnap_card_column",
  10,
  2
);
function modsnap_card_column($column, $post_id)
{
  // Image column
  if ("featured_image" === $column) {
    echo get_the_post_thumbnail($post_id, [80, 80]);
  }
  // Subheader column
  if ("subheader" === $column) {
    $price = get_post_meta($post_id, "price_per_month", true);

    if (!$price) {
      _e("n/a");
    } else {
      echo '$ ' . number_format($price, 0, ".", ",") . " p/m";
    }
  }
}

add_action("init", "modsnap_register_taxonomy");
function modsnap_register_taxonomy()
{
  $labels = [
    "name" => __("Categories"),
    "singular_name" => __("Category"),
    "search_items" => __("Search Categories"),
    "all_items" => __("All Categories"),
    "edit_item" => __("Edit Category"),
    "update_item" => __("Update Categories"),
    "add_new_item" => __("Add New Category"),
    "new_item_name" => __("New Category Name"),
    "menu_name" => __("Categories"),
  ];

  $args = [
    "labels" => $labels,
    "hierarchical" => true,
    "sort" => true,
    "args" => ["orderby" => "term_order"],
    "rewrite" => ["slug" => "category"],
    "show_admin_column" => true,
    "show_in_rest" => true,
  ];

  register_taxonomy("modsnap_category", ["modsnap_card"], $args);
}
/*
// Hook our custom function to the pre_get_posts action hook
add_action("pre_get_posts", "add_article_to_frontpage");
// Alter the main query
function add_article_to_frontpage($query)
{
  if (is_home() && $query->is_main_query()) {
    $query->set("post_type", ["post", "modsnap_card"]);
  }
  return $query;
}
*/

/**
 * Setup query to show the ‘services’ post type with all posts filtered by 'home' category.
 * Output is linked title with featured image and excerpt.
 */

// $args = [
//   "post_type" => "modsnap_card",
//   "post_status" => "publish",
//   "posts_per_page" => -1,
//   "orderby" => "title",
//   "order" => "ASC",
//   //   "cat" => "home",
// ];

// $loop = new WP_Query($args);

// while ($loop->have_posts()):
//   $loop->the_post();
//   $featured_img = wp_get_attachment_image_src($post->ID);
//   print the_title();
//   // if ( $feature_img ) {
//   //    < img src="print $featured_img['url']" width=”print $featured_img['width']" height="print $featured_img['height']" />
//   // }
//   the_content();
// endwhile;

// wp_reset_postdata();

// add_action('after_setup_theme', 'modsnap_resize_img');
// function modsnap_resize_img() {
//   add_image_size( 'ms-grid-card', 220, 220, array( 'center', 'center' ) );
// }

add_action("wp_footer", "modsnap_test_footer");
function modsnap_test_footer()
{
  $args = [
    "post_type" => "modsnap_card",
    "post_status" => "publish",
    // Do you want to add a limit?
    // "posts_per_page" => 3,
  ];
  $the_query = new WP_Query($args);
  
  if ($the_query->have_posts()) { ?>
<div class="ms-cards__container">
  <div class="ms-cards__wrapper">
    <?php
        while ($the_query->have_posts()) {
    
          $the_query->the_post();
          $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), "medium");
          
          ?>
    <div class="ms-card">
      <?php if (
          get_the_post_thumbnail()
        ):/* Show the featured image if there is one */  ?>
      <figure>
        <img src="<?php echo esc_url(
            $featured_img_url
          ); ?>" alt="" width="300" height="300" />
        <figcaption>
          <h3><?php the_title(); ?></h3>
          <p>Something goes here</p>
        </figcaption>
      </figure>
      <?php endif; ?>
      <div class="ms-card-details">
        <h3><?php the_title(); ?></h3>
        <?php the_content(); ?>
      </div>
    </div>
    <?php
        } ?>
  </div>
</div>
<?php
  }

  wp_reset_postdata();
}