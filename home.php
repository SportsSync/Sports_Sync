<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1A2730;
      color: #B0CEE2;
      font-family: Arial, sans-serif;
    }
    h2 {
      color: #B0CEE2;
      text-align: center;
    }
    p {
      color: #669dc2;
      text-align: center;
    }
    #sliderImage {
      border-radius: 10px;
      border: 2px solid #B0CEE2;
      box-shadow: 0 0 10px #B0CEE2;
      width: 100%;
      height: auto;
    }
  </style>
</head>
<body onload="startSlider();">
  <h2>Find the Best Grounds. Feel the Real Game</h2>
  <p>Game-ready grounds. Pro-level amenities. Real action.</p>
  <p>Where passion meets performance.</p>

  <div class="container my-4">
    <img id="sliderImage" src="turf.jpg" alt="Slider Image">
  </div>

  
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
          function startSlider() {
      let images = ["1.jpg", "2.jpeg", "3.jpg", "4.jpg","turf.jpg"];
      let index = 0;
      let img = document.getElementById("sliderImage");

      setInterval(() => {
        index = (index + 1) % images.length;
        img.src = images[index];
      }, 1000);
    }
  </script>
</body>
</html>
