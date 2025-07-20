<html>
<head>
  <title>Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="whole.css" rel="stylesheet">
  <style>
    :root {
      --bg-dark: #1C1C1C;
      --highlight: #D1FF71;
      --card-bg: #F7F6F2;
      --divider: #A9745B;
      --border: #BDBDBD;
    }
    body {
      margin:0;
      padding: 0;
      overflow-x: hidden;
      background-color: var(--bg-dark);
      color: var(--card-bg);
      font-family: Arial, sans-serif;
    }
    h2 {
     color: var(--highlight);
      text-align: center;
    }
    p {
     color: #BDBDBD;
      text-align: center;
    }
    #sliderImage {
      border-radius: 10px;
      border: 2px solid var(--highlight);
      box-shadow: 0 0 10px var(--highlight);
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
    }
    .hero-stats {
    margin-top: 3rem;
}

.stat-item {
    text-align: center;
    margin-bottom: 1rem;
}

.stat-item i {
    font-size: 1.5rem;
    color:  var(--highlight);
    margin-bottom: 0.5rem;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--highlight);
}

.stat-label {
    font-size: 0.9rem;
    color:var(--card-bg);
}


.sports-section {
    background: var(--card-bg);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color:  var(--bg-dark);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
}


.sports-section {
  background: var(--card-bg);
  padding-inline: 1rem;
}

.sport-card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 2rem 1rem;
    text-align: center;
    box-shadow:  0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid var(--border);;
}

.sport-card:hover {
    transform: translateY(-8px);
    box-shadow:  0 6px 16px rgba(0,0,0,0.2);
    border-color: var(--highlight);
}

.sport-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
}

.sport-card:hover .sport-icon {
    transform: scale(1.1);
}

.sport-card h5 {
    font-weight: 600;
    color: var(--bg-dark);
    margin: 0;
}

.how-it-works {
    background: var(--card-bg);
}

.step-card {
    padding: 2rem 1rem;
}

.step-icon {
    position: relative;
    width: 80px;
    height: 80px;
    background: var(--highlight);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color:var(--bg-dark);
}

.step-number {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--divider);
    color:  white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 800;
}

.step-card h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--bg-dark);
    margin-bottom: 1rem;
}

.step-card p {
    color: #6b7280;
    line-height: 1.6;
}

.testimonials {
    background:linear-gradient(135deg, var(--bg-dark) 0%, #111827 100%);
}

.testimonial-card {
    background: rgba(247, 246, 242, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem;
    height: 100%;
}

.testimonial-rating {
    color: var(--highlight);
}

.testimonial-text {
    font-style: italic;
    color: var(--card-bg);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    align-items: center;
}

.testimonial-author img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    margin-right: 1rem;
    object-fit: cover;
    border: 2px solid var(--divider);
}

.testimonial-author h6 {
    color:  var(--highlight);
    margin: 0;
    font-weight: 600;
}

.testimonial-author small {
    color: var(--border);
}

 .btn-success {
      padding: 10px;
      margin: 20px;
       background-color: var(--highlight);
      color: var(--bg-dark);
      border: none;
    }
    .btn-success:hover {
      background-color: var(--highlight);
      box-shadow: 0 0 8px var(--highlight);
      color: var(--bg-dark);
    }
    .main-btn{
      text-align: center;
      padding: 10px;
      
    }
  </style>
</head>
<body onload="startSlider();">
  <h2>Find the Best Grounds. Feel the Real Game</h2>
  <p>Game-ready grounds. Pro-level amenities. Real action.</p>
  <p>Where passion meets performance.</p>

  <div class="main-btn">
    <a href="user.php" class="btn btn-success">Book Turf</a>
    <a href="#" class="btn btn-success">Become Vendor</a>
  </div>

    
    

  <div class="container my-4">
    <img id="sliderImage" src="images/turf.jpg" alt="Slider Image">
  </div>


    <section class="hero-stats row mt-5">
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <i class="bi bi-trophy-fill"></i>
          <div class="stat-number">500+</div>
          <div class="stat-label">Premium Turfs</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <i class="bi bi-people-fill"></i>
          <div class="stat-number">50K+</div>
          <div class="stat-label">Happy Players</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
        <i class="bi bi-geo-alt-fill"></i>
        <div class="stat-number">25+</div>
          <div class="stat-label">Cities Covered</div>
          </div>
        </div>
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <i class="bi bi-star-fill"></i>
          <div class="stat-number">4.8★</div>
          <div class="stat-label">Average Rating</div>
        </div>
      </div>
    </section>

     <section class="sports-section py-5">
        <div class="container">
            <div class="text-center mb-4">
                <p class="section-title">From cricket to pickleball, find the perfect turf for your favorite sport</p>
            </div>
        <div class="row">
          <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="sport-card">
            <div class="sport-icon">🏏</div>
            <h5>Cricket</h5>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <div class="sport-card">
            <div class="sport-icon">⚽</div>
            <h5>Football</h5>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <div class="sport-card">
            <div class="sport-icon">🏀</div>
            <h5>Basketball</h5>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <div class="sport-card">
            <div class="sport-icon">🏓</div>
            <h5>Pickleball</h5>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <div class="sport-card">
            <div class="sport-icon">🎾</div>
            <h5>Tennis</h5>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <div class="sport-card">
            <div class="sport-icon">🏸</div>
            <h5>Badminton</h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="testimonials py-5" style="background: linear-gradient(135deg, #1C1C1C 0%, #111827 100%); color: white;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title"style="color: #D1FF71;">What Our Players Say</h2>
                <p class="section-subtitle" style="color: #BDBDBD;">Join thousands of satisfied players who trust TurfBook Pro</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"TurfBook Pro made it so easy to find and book cricket grounds. The booking process is seamless!"</p>
                        <div class="testimonial-author">
                            <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Arjun Sharma">
                            <div>
                                <h6>Arjun Sharma</h6>
                                <small>Cricket Enthusiast</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                           <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i> 
                        </div>
                        <p class="testimonial-text">"Great platform with excellent turfs. The vendor communication feature is really helpful."</p>
                        <div class="testimonial-author">
                            <img src="https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Priya Singh">
                            <div>
                                <h6>Priya Singh</h6>
                                <small>Football Player</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                          <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"As a coach, I book multiple courts regularly. This platform saves me so much time!"</p>
                        <div class="testimonial-author">
                            <img src="https://images.pexels.com/photos/1681010/pexels-photo-1681010.jpeg?auto=compress&cs=tinysrgb&w=100" alt="Vikram Patel">
                            <div>
                                <h6>Vikram Patel</h6>
                                <small>Pickleball Coach</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Book your perfect turf in just three simple steps</p>
            </div>
            
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="step-card text-center">
            <div class="step-icon">
            <i class="bi bi-search"></i>
            <span class="step-number">01</span>
          </div>
          <h4>Search & Filter</h4>
          <p>Find turfs by location, sport, and amenities using our smart search</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="step-card text-center">
            <div class="step-icon">
            <i class="bi bi-calendar2-check-fill"></i>
            <span class="step-number">02</span>
          </div>
          <h4>Select & Book</h4>
          <p>Choose your preferred time slot and complete the booking process</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="step-card text-center">
            <div class="step-icon">
            <i class="bi bi-trophy-fill"></i>
            <span class="step-number">03</span>
          </div>
          <h4>Play & Enjoy</h4>
          <p>Receive confirmation and enjoy your game at the booked facility</p>
          </div>
        </div>
        </div>
        </div>
      </section>
       <?php
         include("footer.php");
      ?> 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
          function startSlider() {
      let images = ["images/1.jpg", "images/2.jpeg", "images/3.jpg", "images/4.jpg","images/turf.jpg"];
      let index = 0;
      let img = document.getElementById("sliderImage");

      setInterval(() => {
        index = (index + 1) % images.length;
        img.src = images[index];
      }, 3000);
    }
  </script>
</body>
</html>
