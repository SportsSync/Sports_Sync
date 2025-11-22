<?php
echo  '<div class="container">
    <h2>Elite Grounds</h2>

    <div class="row my-4 justify-content-center">
      <div class="col-md-3">
        <select id="locationFilter" class="form-select">
          <option value="all">All Locations</option>
          <option value="surat">Surat</option>
          <option value="mumbai">Mumbai</option>
        </select>
      </div>
      <div class="col-md-3">
        <select id="sportFilter" class="form-select">
          <option value="all">All Sports</option>
          <option value="football">Football</option>
          <option value="cricket">Cricket</option>
          <option value="pickleball">Pickleball</option>
        </select>
      </div>
    </div>


    <div class="row">
      <div class="col-md-4 mb-4 turf-card">
        <div class="card">
          <img src="../images/football.png" class="card-img-top" alt="Turf">
          <div class="card-body">
            <h5 class="card-title">Green Turf Arena</h5>
            <p class="card-text" data-location="surat" data-sport="football">
              Location: Surat<br>Sport: Football
            </p>
            <div class="text-center">
              <a href="#" class="btn btn-success">View</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>'
?>
