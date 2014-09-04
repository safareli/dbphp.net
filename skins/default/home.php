<?php


    $skins['shop.slider.top'] = "
    <section class='row-fluid'>
      <section class='span12 slider'>
        <section class='main-slider'>
          <div class='bb-custom-wrapper'>
            <div id='bb-bookblock' class='bb-bookblock'>
            {items}
            </div>
          </div>
          <nav class='bb-custom-nav'> <a href='#' id='bb-nav-prev' class='left-arrow'>Previous</a> <a href='#' id='bb-nav-next' class='right-arrow'>Next</a> </nav>
        </section>
        <span class='slider-bottom'><img src='{theme_image}/slider-bg.png' alt='Shadow'/></span> </section>
    </section>
    ";

    $skins['shop.slider.top.item'] = "
    <div class='bb-item'>
      <div class='bb-custom-content'>
        <div class='slide-inner'>
          <div class='span4 book-holder'> <a href='{link}'><img src='{image}' alt='Book' /></a>
            <div class='cart-price'> <a class='cart-btn2' href='cart.html'>Add to Cart</a> <span class='price'>{cost}</span> </div>
          </div>
          <div class='span8 book-detail'>
            <h2>{heading}</h2>
            <strong class='title'>{subtitle}</strong> <span class='rating-bar'> <img src='{theme_image}/raing-star2.png' alt='Rating Star' /> </span> <a href='book-detail.html' class='shop-btn'>SHOP NOW</a>
            <div class='cap-holder'>
              <p><img src='{theme_image}/image27.png' alt='Best Choice' align='right'/>{about}</p>
              <a href='{link}'>Read More</a> </div>
          </div>
        </div>
      </div>
    </div>
    ";

    $skins['shop.slider.sale'] = "
    <section class='row-fluid '>
    {items}
    </section>
    ";

    $skins['shop.slider.sale.item'] = "
      <figure class='span4 s-product'>
        <div class='s-product-img'><a href='{link}'><img src='{image}' alt='{heading}'/></a></div>
        <article class='s-product-det'>
          <h3><a href='book-detail.html'>{heading}</a></h3>
          <p>{about}</p>
          <span class='rating-bar'><img src='{theme_image}/rating-star.png' alt='Rating Star'/></span>
          <div class='cart-price'> <a href='cart.html' class='cart-btn2'>Add to Cart</a> <span class='price'>{cost}</span> </div>
          <span class='sale-icon'>Sale</span> </article>
      </figure>
    ";


?>