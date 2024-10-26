<?php
include_once '../common/common-function.php';

// Get all products and categories
$categories = get_all_categories() ?? [];
$products_with_offers = [];

// Fetch all active products
function get_active_products() {
    $all_products = get_all_products();
    return array_filter($all_products, function($product) {
        return $product['product_status'] == '1';
    });
}

// handle filter product by cat id
if (isset($_POST['cat_id'])) {
    header('Content-Type: application/json'); 
    // Get cat id from form data
    $cat_id = $_POST['cat_id'];
    $filter_products = [];

    // Fetch all products
    if ($cat_id == 0) {
        // Fetch all active products
        $filter_products = get_active_products();
    } else {
        // Fetch products by category
        $filter_products = get_product_by_catId($cat_id);
        // Filter to active products
        $filter_products = array_filter($filter_products['products'], function($product) {
            return $product['productStatus'] == 1;
        });
    }

    foreach ($filter_products as $filter) {
        $offer = get_offers_details_by_productId($filter['id']); 
        $filter['offer'] = $offer ?: null;
        $products_with_offers[] = $filter; 
    }

    // Return the products with offers
    echo json_encode($products_with_offers);
    exit(); 
}

// Fetch active products 
$products = get_active_products();
?>

<!doctype html>
<html lang="en">
<?php include_once 'layout/head.php'?>

<body>
    <?php include_once 'layout/header.php'?>

    <section class="inv-banner">
        <div class="container-wrap">
            <div class="inv-heading">
                <h2>Shop</h2>
                <p>InventoryMax simplifies stock control, reduces errors, and enhances efficiency, helping your business run smoothly and profitably.</p>
            </div>
        </div>
    </section>

    <section class="product-list">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col3">
                    <div class="product-side">
                        <h4>Categories</h4>
                        <ul class="product-filter">
                            <li class="tablinks active" data-id="0">All Products</li>
                            <?php foreach ($categories as $category): if($category['status']==1): ?>
                                <li class="tablinks" data-id="<?= $category['cat_id'] ?>"><?= $category['name'] ?></li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="col-8">
                    <div class="row-wrap" id="product-list">
                        <?php foreach ($products as $val): ?>
                        <div class="col4 product-item" data-category-id="<?= $val['cat_id'] ?>">
                            <div class="item-box">
                                <div class="item-img">
                                    <a href="product-detail.php?id=<?= $val['id'] ?>">
                                        <img src="../manager/uploads/<?= $val['image']; ?>" alt="image" title="img">
                                    </a>
                                </div>
                                <a href="product-detail.php?id=<?= $val['id'] ?>">
                                    <div class="item-info">
                                        <h3><?= $val['product_name']; ?></h3>
                                    </a>
                                    <div class="price">
                                        <?php $offer = get_offers_details_by_productId($val['id']) ?: null; ?>
                                        <?php if ($offer && isset($offer['discount_percentage'])): ?>
                                            <h4 class="price1">$<?= $val['product_price']; ?></h4>
                                            <h4>$<?= number_format($val['product_price'] - $offer['discount_percentage'], 2); ?></h4>
                                        <?php else: ?>
                                            <h4>$<?= $val['product_price']; ?></h4>
                                        <?php endif; ?>
                                    </div>
                                    <a class="btns" href="product-detail.php?id=<?= $val['id'] ?>">Detail's</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="newsletters">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col-6">
                    <div class="newsletter-left">
                        <h2>Subscribe Our Newsletter</h2>
                        <p>Subscribe to our newsletter to receive early discount offers, updates and info</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="newsletter-right">
                        <form action="">
                            <div class="input-field">
                                <input type="email" placeholder="Enter Your Email">
                                <button>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            function fetchProducts(catId) {
                $.ajax({
                    url: 'shop.php',
                    type: 'POST',
                    data: {
                        cat_id: catId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#product-list').empty();
                        if (data.length > 0) {
                            $.each(data, function(index, product) {
                                $('#product-list').append(`
                                    <div class="col4 product-item" data-category-id="${product.cat_id}">
                                        <div class="item-box">
                                            <div class="item-img">
                                                <a href="product-detail.php?id=${product.id}">
                                                    <img src="../manager/uploads/${product.image}" alt="image" title="img">
                                                </a>
                                            </div>
                                            <a href="product-detail.php?id=${product.id}">
                                                <div class="item-info">
                                                    <h3>${product.product_name}</h3>
                                                    <div class="price">
                                                        ${product.offer && product.offer.discount_percentage ? `
                                                            <h4 class="price1">$${product.product_price}</h4>
                                                            <h4>$${(product.product_price - product.offer.discount_percentage).toFixed(2)}</h4>
                                                        ` : `
                                                            <h4>$${product.product_price}</h4>
                                                        `}
                                                    </div>
                                                    <a class="btns" href="product-detail.php?id=${product.id}">Detail's</a>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            $('#product-list').append('<p>No products found.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    }
                });
            }
            // Load all products
            fetchProducts(0);
            // On clicking a category
            $('.tablinks').on('click', function() {
                var catId = $(this).data('id');
                // Remove active class 
                $('.tablinks').removeClass('active');
                $(this).addClass('active');
                // Fetch products for the selected category
                fetchProducts(catId);
            });
        });
    </script>

    <?php include_once 'layout/footer.php'?>
</body>
</html>
