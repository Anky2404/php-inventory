<?php
include_once '../common/common-function.php';
// Get all products and categories
$products =get_offers_products();
$categories = get_all_categories() ?? [];



?>
<!doctype html>
<html lang="en">

<?php include_once('layout/head.php') ?>

<body>

<?php include_once('layout/header.php') ?>

    <section class="home-1">
    
                    
                    <div class="owl-carousel owl-theme">
                        <div class="item" style="background-image: url(images/banner2.jpg);">
                            <div class="colleft">
                                <span>Simplify Stock, Maximize Profit</span>
                            <h2>Revolutionize Your Stock Control Accurate, Efficient, Hassle-Free!</h2>
                            <p>Take control of your stock with InventoryMax—Australia's leading inventory management solution. Streamline your inventory processes, reduce costs, and never miss a sale again with our intuitive and powerful platform designed for businesses of all sizes.</p>
                                <a href="register.php">Get Started Today !</a>
            
                            </div>
                        </div>
                        <div class="item"  style="background-image: url(images/banner-img.jpg);">
                            <div class="colleft">
                                
                                <span>Streamline Your Inventory, Boost Your Efficiency</span>
                            <h2>Expert Tips for Managing Your Inventory Like a Pro!</h2>
                            <p>Unlock valuable insights into your inventory performance with our customizable reports and analytics tailored to meet your unique business needs. Our  advanced reporting tools allow you to track key metrics such as stock levels turnover rates, and demand trends.</p>
                                <a href="contact.php">Contact Us !</a>
                            </div>
                        </div>
                        <div class="item" style="background-image: url(images/banner3.jpg);">
                            <div class="colleft">
                                <span>Take Control of Your Stock, Anytime, Anywhere.</span>
                                <h2>Simplify Stock Management with Our Advanced System</h2>
                                <p>From real-time tracking to automated reordering, our solution ensures you never run out of stock or overstock. With advanced inventory management features, you can monitor stock levels across multiple locations, receive alerts for low inventory.</p>
                                    <a href="about.php">Discover More !</a>
                            </div>
                        </div>
               
                    
                   
                  
                </div>
                
   
    </section>


  

    <section class="product-list">
        <div class="container-wrap">
         
                    <div class="owl-carousel owl-theme" id="product-list">
                        <?php foreach ($products as $key => $val) { ?>
                            <div class="item">
                            <div class="product-item" data-category-id="<?= $val['cat_id'] ?>">
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
                                        <h4 class="price1">$<?= $val['product_price']; ?></h4>
                                        <h4>$<?= number_format($val['product_price']-$val['discount_percentage'], 2); ?></h4>
                                        </div>
                        
                                       
                                      
                                        <a class="btns" href="product-detail.php?id=<?= $val['id'] ?>">Detail's</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } ?>
                    </div>
          
  
    </section>


    <section class="home-2">
        <div class="container-wrap">
            <div class="row-wrap">
                <div class="col-6">
                    <div class="about-left">
                        <img src="images/about-img.jpg" alt="about-img" title="about-img">
                    </div>
                </div>
                <div class="col-6">
                    <div class="about-right">
                        <span>About Us</span>
                        <h2>Your Trusted Partner in Inventory Management</h2>
                        <p>At InventoryMax, we are dedicated to transforming how businesses in Australia manage their inventory. With our cutting-edge, user-friendly platform. </p>
                        <div class="row-wrap">
                            <div class="col-6">
                                <div class="about-box active">
                                    <h4>Vision</h4>
                                    <p>Our vision is to be the leading inventory management platform in Australia, known for our reliability, innovation approch.</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="about-box">
                                    <h4>Mission</h4>
                                    <p>Our mission is to provide Australian businesses with powerful and intuitive inventory management solutions that streamline operations.</p>
                                </div>
                            </div>
                        </div>
                        <a href="about.html">Learn More About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <section class="home-3">
        <div class="container-wrap">
            <div class="services">
                <div class="row-wrap">

                    <div class="col-6">
                        <div class="service-heading">

                            <span>Our Services</span>
                            <h2>Innovative Inventory Solutions Tailored for Your Business</h2>
                        </div>
                    </div>
                    <div class="col-6">
                        <p>At InventoryMax, we offer a comprehensive suite of inventory management solutions designed to help Australian businesses operate more efficiently and effectively. </p>
                    </div>
                </div>
            </div>

            <div class="services-bottom">
                <div class="row-wrap">
                    <div class="col4">
                        <a href="#">
                            <div class="about-box active">
                                <h4>Real-Time Inventory Tracking</h4>
                                <p>Stay on top of your inventory levels with real-time tracking across all your locations. InventoryMax provides instant updates on stock movements.</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="about-box">
                                <h4>Automated Reordering System</h4>
                                <p>Never run out of stock again with our automated reordering system. InventoryMax automatically analyzes your inventory data.</p>
                            </div>
                        </a>

                    </div>
                    <div class="col4">
                        <div class="services-img">
                            <img src="images/services.jpg" alt="services" title="services">
                        </div>
                    </div>
                    <div class="col4">
                        <a href="#">
                            <div class="about-box">
                                <h4>Comprehensive Reporting </h4>
                                <p>Make smarter business decisions with detailed inventory reports and analytics. InventoryMax provides insights into inventory performance, sales trends, and demand forecasting.</p>
                            </div>
                        </a>
                        <a href="#">

                            <div class="about-box">
                                <h4>Multi-Channel Inventory </h4>
                                <p>Manage inventory across multiple sales channels with ease. Whether you sell online, in-store, or both, InventoryMax synchronizes your inventory levels in real-time.</p>
                            </div>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </section>
    <section class="home-4">
        <div class="container-wrap">
            <div class="services">
                <div class="row-wrap">

                    <div class="col-6">
                        <div class="service-heading">

                            <span>Why Choose Us</span>
                            <h2>Why InventoryMax is the Smart Choice for Your Business</h2>
                        </div>
                    </div>
                    <div class="col-6">
                        <p>InventoryMax is more than just an inventory management platform; it's a trusted partner that helps Australian businesses streamline their operations and boost profitability.</p>
                    </div>
                </div>
            </div>
            <div class="choose-us">
                <div class="row-wrap">
                    <div class="col-6">
                        <ul>
                            <li>
                           <div class="choose-left">
                            <i class="fa-solid fa-chart-simple"></i>
            
                           </div>
                           <div class="choose-right">
                            <h4>Reliable Real-Time Insights</h4>
                            <p>Make informed decisions with real-time insights into your inventory. InventoryMax offers accurate and up-to-date information on stock levels, sales, and trends, helping you stay ahead in a competitive market.</p>
                           </div>
                        </li>
                        <li>
                            <div class="choose-left">
                                <i class="fa-solid fa-laptop"></i>
             
                            </div>
                            <div class="choose-right">
                             <h4>User-Friendly Interface</h4>
                             <p>Our platform is designed with simplicity in mind, ensuring that users of all technical levels can easily navigate and manage their inventory. </p>
                            </div>
                         </li>
                         <li>
                            <div class="choose-left">
                                <i class="fa-solid fa-headphones"></i>
             
                            </div>
                            <div class="choose-right">
                             <h4>Dedicated Customer Support</h4>
                             <p>We are committed to your success. Our dedicated customer support team is available to assist you with any questions or challenges.</p>
                            </div>
                         </li>

                         
                    </ul>
                    </div>
                    <div class="col-6">
                           <div class="choose-img">
                            <img src="images/choose-us.png" alt="">
                           </div>
                    </div>
                </div>
   
            </div>
        </div>
 </section>

    <section class="home-5">
        <div class="container-wrap">
            <div class="heading">
                
                <span>Testimonials</span>
                <h2>What Our Clients Say About InventoryMax</h2>
                <p>We pride ourselves on delivering exceptional inventory management solutions that help Australian businesses thrive. </p>
            </div>
            <div class="testimonial-wrap">
            <div class="row-wrap">
              <div class="col4">
                <div class="testimonial-box">
                    <p>InventoryMax has completely transformed the way we manage our stock. The real-time tracking and automated reordering features have saved us so much time and money. Highly recommend it to any business looking to streamline their inventory processes!</p>
                     <ul><li>
                        <div class="testimonial-img">
                            <img src="images/client1.png" alt="">
                        </div>
                        <div class="testimonial-name">
                            <h4> Emma Roberts</h4>
                            <p>Customer</p>
                     </li></ul>
                </div>
              </div>
              <div class="col4">
                <div class="testimonial-box">
                    <p>We've been using InventoryMax for over a year now, and it's been a game-changer. The platform is incredibly easy to use, and the customer support team is always there when we need them. It's truly helped us grow our business. </p>
                     <ul><li>
                        <div class="testimonial-img">
                            <img src="images/client2.png" alt="">
                        </div>
                        <div class="testimonial-name">
                            <h4>James Peterson</h4>
                            <p>Customer</p>
                     </li></ul>
                </div>
              </div>
              <div class="col4">
                <div class="testimonial-box">
                    <p>The insights and analytics provided by InventoryMax have given us a much better understanding of our inventory needs. We’ve reduced overstock issues and improved our cash flow, thanks to this amazing tool! </p>
                     <ul><li>
                        <div class="testimonial-img">
                            <img src="images/client3.png" alt="">
                        </div>
                        <div class="testimonial-name">
                            <h4>Sarah Thompson</h4>
                            <p>Customer</p>
                     </li></ul>
                </div>
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
                        <h2>Stay Updated with InventoryMax</h2>
                        <p>Subscribe to our newsletter to receive the latest updates, expert tips, and exclusive offers on inventory management solutions.</p>
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
    
    <?php include_once('layout/footer.php') ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script>     $('.home-1 .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    </script>
        <script>     $('.product-list .owl-carousel').owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
    </script>
   
</body>

</html>