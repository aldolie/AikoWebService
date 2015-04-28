

    <!--Slider-->
  <div class="container" id="home_slider">
    <div id="mi-slider" class="mi-slider">
      <ul>
        <li><a href="#"><img src="<?php echo base_url('image/slider/1.jpg'); ?>" alt="img01"><h4>Boots</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/2.jpg'); ?>" alt="img02"><h4>Oxfords</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/3.jpg'); ?>" alt="img03"><h4>Loafers</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/4.jpg'); ?>" alt="img04"><h4>Sneakers</h4></a></li>
      </ul>
      <ul>
        <li><a href="#"><img src="<?php echo base_url('image/slider/5.jpg'); ?>" alt="img05"><h4>Belts</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/6.jpg'); ?>" alt="img06"><h4>Hats &amp; Caps</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/7.jpg'); ?>" alt="img07"><h4>Sunglasses</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/8.jpg'); ?>" alt="img08"><h4>Scarves</h4></a></li>
      </ul>
      <ul>
        <li><a href="#"><img src="<?php echo base_url('image/slider/9.jpg'); ?>" alt="img09"><h4>Casual</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/10.jpg'); ?>" alt="img10"><h4>Luxury</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/11.jpg'); ?>" alt="img11"><h4>Sport</h4></a></li>
      </ul>
      <ul>
        <li><a href="#"><img src="<?php echo base_url('image/slider/12.jpg'); ?>" alt="img12"><h4>Carry-Ons</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/13.jpg'); ?>" alt="img13"><h4>Duffel Bags</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/14.jpg'); ?>" alt="img14"><h4>Laptop Bags</h4></a></li>
        <li><a href="#"><img src="<?php echo base_url('image/slider/15.jpg'); ?>" alt="img15"><h4>Briefcases</h4></a></li>
      </ul>
      <nav>
        <a href="#">Shoes</a>
        <a href="#">Accessories</a>
        <a href="#">Watches</a>
        <a href="#">Bags</a>

      </nav>
    </div>
  </div>
    <!--Slider-->
    
    <!-- Newest Product -->
    <div class="container" id="home_newest_product">
      <div class="row">
        <?php for($i=1;$i<9;$i++){ ?>
        <div class="col-xs-6 col-md-3">
          <div class="thumbnail">
              <img src="<?php echo base_url("image/slider/$i.jpg"); ?>" alt="...">
              <div class="caption">
                <h3>Casual</h3>
                <p>Rp.180.000,-<p>
               <p>
                  <a href="#" class="btn btn-primary" role="button">Add To Cart</a> 
                  <a href="#" class="btn btn-default" role="button">View</a>
                </p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <!--Newest Product-->


    <!-- Customer Testimoni -->
    <div class="container" id="home_customer_testimony">
      <div class="row">
       <?php for($i=1;$i<5;$i++){ ?>
        <div class="col-xs-6 col-md-6">
          <div href="#" class="home_customer_testimonies">
            <img class="home_customer_testimony_image responsive-image" src="<?php echo base_url("image/testimony/sample$i.jpg"); ?>" alt="...">
            <div class="home_customer_testimony_column">
              <span class="home_customer_testimony_column_name">Lorem Ipsum</span>
              <p class="home_customer_testimony_column_content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
            </div>
          </div>
        </div>
         <?php } ?>
      </div>
    </div>

<script src="<?php echo base_url('js/jquery.catslider.js'); ?>"></script>
<script>
  $(document).ready(function(){
      $( '#mi-slider' ).catslider();

  });
</script>