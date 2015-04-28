<div class="container">
  <ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Pria</a></li>
    <li class="active">Sepatu</li>
  </ol>
</div>

<div class="container">
<div class="row">
    <div class="col-xs-12 col-lg-3" >
      <form role="form">
        <div class="form-group">
          <label for="textSearch">Keywords</label>
          <input type="text" class="form-control" id="textSearch" name="textSearch" placeholder"Keywords">
        </div>
        <div class="form-group">
          <label for="comboOption">Keywords</label>
          <select class="form-control" name="comboOption" id="comboOption">
            <option>Lowest to Highest Price</option>
            <option>Highest to Lowest Price</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
    </div>
    <div class="col-xs-12 col-lg-9" id="items_products">
        <div class="row">
          <?php for($i=1;$i<9;$i++){ ?>
          <div class="col-xs-6 col-md-4">
            <div class="thumbnail">
                <img style="height:300px;" src="<?php echo base_url("image/items/$i.jpg"); ?>" alt="...">
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
    </div>
</div>