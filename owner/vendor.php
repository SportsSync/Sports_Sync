<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
     <form>
      <h2>Turf Details</h2>

       <div class="mb-3">
         <label for="fname" class="form-label"><span class="warning">* </span>Turf Name:</label>
        <input type="text" class="form-control" id="fname" placeholder="Enter Your Turf Name">
      </div><br>

      <div class="mb-3">
         <label for="address" class="form-label" style="display: block; margin-bottom: 5px;"><span class="warning">* </span>Turf Address:</label>
        <textarea id="address" name="address" rows="4" cols="40" placeholder="Enter your Full Address"></textarea>
      </div><br>

      <div class="mb-3">
         <label for="time" class="form-label"><span class="warning">* </span>Choose Time Slots:</label>
        <div class="time-row">
            <div class="time-field"><label for="fromtime">From :</label><input type="time" class="form-control" id="fromtime"></div>
            <div class="time-field"><label for="totime">To :</label><input type="time" class="form-control" id="totime"></div>
        </div>
      </div><br>

      <div class="mb-3">
        <label for="imageUpload"><span class="warning">* </span>Upload an Image:</label>
       <input type="file" id="imageUpload" name="image" multiple accept="image/*">
      </div><br>

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


      <button type="button" class="btn btn-custom w-100">Register</button>
    </form>
    </div>
</body>
</html>