<?php
namespace AMI\ProductBreadcrumbs\Plugin;

use Magento\Catalog\ViewModel\Product\Breadcrumbs as OriginalBreadcrumbs;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Registry;

class BreadcrumbsPlugin
{
    protected $categoryRepository;
    protected $registry;
    protected $categoryCollectionFactory;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        Registry $registry,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->registry = $registry;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function afterGetJsonConfigurationHtmlEscaped(OriginalBreadcrumbs $subject, $result)
    {
        // Decode existing breadcrumb JSON
        $breadcrumbsData = json_decode($result, true);

        // Add "Home" as the first breadcrumb
        $breadcrumbsData['breadcrumbs'] = [
            [
                'label' => 'Home',
                'link'  => '/',
                'title' => 'Home'
            ]
        ];

        // Get current product and associated categories
        $product = $this->registry->registry('current_product');
        if ($product) {
            $categoryIds = $product->getCategoryIds();
            if (!empty($categoryIds)) {
                // Load all categories, including parent categories in the path
                $categories = $this->categoryCollectionFactory->create()
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('url')
                    ->addFieldToFilter('entity_id', ['in' => $categoryIds])
                    ->addFieldToFilter('is_active', 1)
                    ->addPathFilter('1/2') // Filter to exclude root and unassigned categories
                    ->addOrderField('path'); // Order by path to ensure correct hierarchy

                foreach ($categories as $category) {
                    $breadcrumbsData['breadcrumbs'][] = [
                        'label' => $category->getName(),
                        'link'  => $category->getUrl(),
                        'title' => $category->getName()
                    ];
                }
            }

            // Add the product name as the last breadcrumb
            $breadcrumbsData['breadcrumbs'][] = [
                'label' => $product->getName(),
                'link'  => '',
                'title' => $product->getName()
            ];
        }

        // Return the modified JSON
        return json_encode($breadcrumbsData);
    }
}