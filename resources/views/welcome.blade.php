@extends('layouts.guest')
@section('content')
@include('backend.partials.header')

    <div class="site-section site-section-sm bg-light">
      <div class="container">
      
        <div class="row mb-5">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_1.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">625 S. Berendo St</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 625 S. Berendo St Unit 607 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">7,000</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_2.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite active"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">871 Crenshaw Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 1 New York Ave, Warners Bay, NSW 2282</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">1,620</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-info">Lease</span>
                </div>
                <img src="{{asset('template/images/img_3.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">853 S Lucerne Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 853 S Lucerne Blvd Unit 101 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">5,500</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_4.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">625 S. Berendo St</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 625 S. Berendo St Unit 607 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">7,000</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_5.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">871 Crenshaw Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 1 New York Ave, Warners Bay, NSW 2282</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">1,620</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-info">Lease</span>
                </div>
                <img src="{{asset('template/images/img_6.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">853 S Lucerne Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 853 S Lucerne Blvd Unit 101 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">5,500</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_7.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">625 S. Berendo St</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 625 S. Berendo St Unit 607 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">7,000</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-danger">Sale</span>
                  <span class="offer-type bg-success">Rent</span>
                </div>
                <img src="{{asset('template/images/img_8.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">871 Crenshaw Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 1 New York Ave, Warners Bay, NSW 2282</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">1,620</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.html" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-info">Lease</span>
                </div>
                <img src="{{asset('template/images/img_1.jpg')}}" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.html">853 S Lucerne Blvd</a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> 853 S Lucerne Blvd Unit 101 Los Angeles, CA 90005</span>
                <strong class="property-price text-primary mb-3 d-block text-success">$2,265,500</strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number">2 <sup>+</sup></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number">2</span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number">5,500</span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>
        </div>
     
        
      </div>
    </div>
    <!-- <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Recent Blog</h2>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="#"><img src="images/img_4.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
            <a href="#"><img src="images/img_2.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="300">
            <a href="#"><img src="images/img_3.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>

        </div>

      </div>
    </div> -->
    @include('backend.partials.footer')
  </div>
  @endsection
    