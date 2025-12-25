<?php
    include ("db.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){

        $turf_name=$_POST['turf_name'];
        $location=$_POST['turf_add'];
        $description=$_POST['description'];
        $starttime=$_POST['fromtime'];
        $endtime=$_POST['totime'];
        //temp apne session use karvanu che
        $owner_id=1;

        $sql="Insert into turftb(owner_id,turf_name,location,description) values(?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $owner_id, $turf_name, $location, $description);
        mysqli_stmt_execute($stmt);
        
        $turf_id=mysqli_insert_id($conn);

        //slot
        $sql2 = "INSERT INTO turf_price_slotstb
        (turf_id, start_time, end_time, price_per_hour, is_weekend)
        VALUES (?, ?, ?, 0, 0)";

            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "iss", $turf_id, $starttime, $endtime);
            mysqli_stmt_execute($stmt2);

        //      if (!empty($_POST['sports'])) {
        //     foreach ($_POST['sports'] as $sport_id) {
        //         $sql3 = "INSERT INTO turf_sportstb (turf_id, sport_id)
        //              VALUES (?, ?)";
        //         $stmt3 = mysqli_prepare($conn, $sql3);
        //         mysqli_stmt_bind_param($stmt3, "ii", $turf_id, $sport_id);
        //         mysqli_stmt_execute($stmt3);
        //     }
        // }
        //    if (!empty($_FILES['turf_images']['name'][0])) {

        // foreach ($_FILES['turf_images']['name'] as $key => $img_name) {

        //     $tmp_name = $_FILES['turf_images']['tmp_name'][$key];
        //     $folder   = "turf_images/";
        //     $newName  = time() . "_" . $img_name;

        //     move_uploaded_file($tmp_name, $folder . $newName);

        //     $sql4 = "INSERT INTO turf_imagestb (turf_id, image_path)
        //              VALUES (?, ?)";
        //     $stmt4 = mysqli_prepare($conn, $sql4);
        //     mysqli_stmt_bind_param($stmt4, "is", $turf_id, $newName);
        //     mysqli_stmt_execute($stmt4);
    //     }
    // }
    }
?>
<html>
<head>
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
          body {
            background-image: url('https://images.unsplash.com/photo-1617696618050-b0fef0c666af?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #F1F1F1;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 40px;
            border-radius: 16px;
            max-width: 450px;
            margin: 60px auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
        }

        h1 {
            text-align: center;
            color: #eb7e25;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 2.2rem;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-custom {
            background-color: #eb7e25;
            color: #000;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #eb7e25;
            color: #fff;
        }

        .time-row{
            display: flex;
            gap: 15px;
        }

        .time-field{
            flex: 1;
        }

        .time-field label{
            display: block;
            font-size: 14px;
            margin-bottom: 4px;
            color: #ccc;
        }

        .warning {
            color: red;
            font-size: 13px;
        }

    </style>
     <link href="../whole.css" rel="stylesheet">
</head>
<body>
    <div class="form-container">
     <form method="post" action="vendor.php" enctype="multipart/form-data">
      <h2>Turf Details</h2>

       <div class="mb-3">
         <label for="fname" class="form-label"><span class="warning">* </span>Turf Name:</label>
        <input type="text" class="form-control" name="turf_name" id="turf_name" placeholder="Enter Your Turf Name">
      </div><br>

      <div class="mb-3">
         <label for="address" class="form-label" style="display: block; margin-bottom: 5px;"><span class="warning">* </span>Turf Address:</label>
        <textarea id="turf_add" name="turf_add" rows="4" cols="40" placeholder="Enter your Full Address"></textarea>
      </div><br>

      <div class="mb-3">
         <label for="time" class="form-label"><span class="warning">* </span>Choose Time Slots:</label>
        <div class="time-row">
            <div class="time-field"><label for="fromtime">From :</label><input type="time" class="form-control" name="fromtime" id="fromtime"></div>
            <div class="time-field"><label for="totime">To :</label><input type="time" class="form-control" name="totime" id="totime"></div>
        </div>
      </div><br>

      <div class="mb-3">
        <label for="imageUpload"><span class="warning">* </span>Upload an Image:</label>
       <input type="file" id="imageUpload" name="imageUpload" multiple accept="image/*">
      </div><br>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control" placeholder="About your turf" required></textarea><br>
    </div>

      <div class="mb-3">
        <label class="form-label">Select your Amenities:</label><br>

        <input type="checkbox" id="cafe" name="cafe" value="Cafeteria">
        <label for="hobby1">Cafeteria</label><br>

        <input type="checkbox" id="wash" name="wash" value="Washroom">
        <label for="hobby2">Washroom</label><br>

        <input type="checkbox" id="sit" name="sit" value="Sitting Area">
        <label for="hobby3">Sitting Area</label><br>

        <input type="checkbox" id="equip" name="equip" value="Sports Equipment">
        <label for="hobby4">Sports Equipment</label>
      
        </div><br>

      <button type="submit" class="btn btn-custom w-100">Register</button>
    </form>
    </div>
</body>
</html>