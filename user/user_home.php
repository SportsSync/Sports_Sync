<?php
echo  '<div class="container">
    <h2>Elite Grounds</h2>
     
    <div class="container mt-3">
      <div class="row justify-content-center align-items-center g-2">

       <!-- Search Bar -->
        <div class="col-md-8">
         <div class="input-group search-bar">
           <span class="input-group-text">
             <i class="bi bi-search"></i>
           </span>
             <input type="text" id="search-item" class="form-control" placeholder="Search Here">
            <span class="input-group-text mic-btn">
             <i class="bi bi-mic-fill"></i>
            </span>
          </div>
        </div>

        <!-- Dropdown 1 -->
        <div class="col-md-2">
         <select id="locationFilter" class="form-select">
          <option value="all">All Locations</option>
          <option value="surat">Surat</option>
          <option value="mumbai">Mumbai</option>
         </select>
        </div>

        <!-- Dropdown 2 -->
        <div class="col-md-2">
         <select id="sportFilter" class="form-select">
           <option value="all">All Sports</option>
           <option value="football">Football</option>
           <option value="cricket">Cricket</option>
           <option value="pickleball">Pickleball</option>
         </select>
        </div>
     </div>
   </div>
</div>


    <div class="row mt-5">
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
