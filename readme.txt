=== Customers Viewed Ultimately Purchased for WooCommerce ===
Contributors: scott.deluzio
Tags: woocommerce, related products, upsell
Requires at least: 4.9.6
Tested up to: 5.3.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Dynamically update the related products shown on WooCommerce product pages so that customers see what others actually purchased.

== Description ==
One of the best ways to get customers to purchase a product is to show them what other customers who have viewed the same products as they are viewing have purchased.

Customers Viewed Ultimately Purchased for WooCommerce does just that. It keeps track of the products that a customer views during their visit to your site. Then, when a customer completes their purchase, it keeps a running tally of products that were viewed for each product that was ultimately purchased.

Once it collects enough information, it will update the related products with products that other customers have actually purchased after viewing that product.

This is a great way to increase sales on the products in your store.

== Installation ==
1. Download archive and unzip in wp-content/plugins or install via Plugins > Add New.
2. Activate the plugin through the Plugins menu in WordPress.
3. Navigate to WooCommerce > Settings > Advanced tab > Customers viewed ultimately purchased link.
4. Select the length of time that the plugin should track the products that customers have viewed. (Note this only sets the expiration date for a cookie that is set in the customer's browser. It does not store any information on the site).

== Frequently Asked Questions ==
= How Does Customers Viewed Ultimately Purchased for WooCommerce Work? =
The plugin sets a small cookie on the customer's browser, which stores a list of product ID numbers that the customer has viewed. When the customer completes a purchase, the plugin loops through each product in the customer's cart and updates a running count of the products viewed before that product was purchased. The list of related products shown on your shop's product pages will then get updated with a list of products that customers have actually purchased.

= How is this better than the built in related products in WooCommerce? =
The built in related products grabs random products based on your product categories. It isn't a very "smart" list of products. Rather it is a relatively random list that may or may not have any relevance to the product the customer is actually looking at.

= Is it complicated to set up the plugin? =
No! If you can install a WordPress plugin, then you can set this plugin up. There is only one setting you need to worry about, and that is the setting that controls how long the plugin will track the products your customer has viewed. By default this is set to 1 week, so even if you do nothing other than install and activate the plugin it will start working right away.

= I don't see related products being updated, what's wrong? =
To save your site from constantly looking up related products, we save the product recommendations in the database and update what is shown on your product pages once per day. This is the same way that WooCommerce updates the random related products that they show. This ensures that your shop pages will continue to load quickly for your customers!

= I want to change the "Related Products" heading text. How can I do that? =
Depending on your theme, that text might be hard coded. In WooCommerce 3.9 a new filter was introduced that allows us to modify that heading text. We have used that filter to set the heading text to "Customers who viewed this product ultimately purchased".

If you wish to change the value you can use the following code:
remove_filter( 'woocommerce_product_related_products_heading', 'cvup_related_products_heading' );
add_filter( 'woocommerce_product_related_products_heading', 'my_custom_related_products_heading' );
function my_custom_related_products_heading(){
    return 'Your custom heading text here';
}

If your theme does not use this filter, and you want to edit the heading:
* Use an FTP program, or your host's file manager to navigate to wp-content/plugins/woocommerce/templates/single-product/related.php
* Copy that file.
* Navigate to your active theme's directory.
* Create a woocommerce directory inside your theme's directory.
* Create a single-product directory inside the woocommerce directory you just created.
* Paste the related.php file inside of wp-content/themes/[your-theme]/woocommerce/single-product/
* Open related.php with a text editor, and change the Related Products text to whatever you want it to say.

== Changelog ==
= 1.0.0 =
* Initial release