# Magento 2 Short breadcrumbs with category

Full categories product breadcrumb for Magento 2 Module

This module provides a simplified breadcrumb trail on product pages by showing only the product’s immediate category. Unlike traditional breadcrumbs that display the full category hierarchy, this module enhances user experience by focusing on a concise, straightforward path: Home > Category > Product.

When customers land on a product page, the breadcrumb clearly indicates the product's primary category, helping users understand the product’s context within the store without the distraction of an extended breadcrumb trail. This clean navigation solution keeps the product page uncluttered and improves usability for shoppers.

Add module to app/code

<strong>Magento Commands</strong><br />
php bin/magento setup:upgrade<br />
php bin/magento setup:compile<br />
php bin/magento cache:clean<br />


<strong>If not visible, update breacrumbs file in theme</strong><br />
app/design/frontend/vendor/theme/Magento-catalog/view/frontend/templates/product/breadcrumbs.phtml

<strong>Example of breadcrumbs below</strong><br /> 
Home > Sub Category > Product <br />
![example](https://github.com/user-attachments/assets/fadb1e0e-e733-4dd2-9398-65c6cb39c361)
