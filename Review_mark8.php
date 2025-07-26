<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #181818ff;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 50px;
    }

    #transaction-popup {
     position: fixed;
     top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(24, 24, 24, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeOut 1s 2s forwards;
    }

    .popup-content {
        background-color: #121212;
        padding: 30px 50px;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        text-align: center;
        font-size: 20px;
        color: #b5f34d;
        animation: popIn 0.5s ease-out;
    }

    @keyframes popIn {
    from {
    transform: scale(0.6);
    opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
    }

    @keyframes fadeOut {
    to {
        opacity: 0;
        visibility: hidden;
    }
    }


    .card {
      background-color: #000000a2;
      border-radius: 24px;
      padding: 30px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    
    form 
    {
      display: flex;
      flex-direction: column;
      align-items: center;
     }

    form label,
    form input[type="text"],
    form input[type="number"],
    form textarea,
    form .stars,
    
    form button
      {
        width: 100%;
        max-width: 320px;
        text-align: left;
      }


    h2 
    {
      text-align: center;
      font-size: 26px;
      margin-bottom: 25px;
      color: #ffffff;
    }

    label
    {
      display: block;
      font-size: 14px;
      margin-bottom: 6px;
      color: #cccccc;
    }

    input[type="text"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      background: #2a2a2a;
      border: 1px solid #333;
      border-radius: 16px;
      color: #fff;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    .stars {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
      margin: 10px 0 25px;
    }

    .stars input {
      display: none;
    }

    .stars label {
      font-size: 30px;
      color: #555;
      cursor: pointer;
      padding: 0 4px;
      transition: 0.2s;
    }

    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
      color: #f3dd4dff;
    }

    .btn {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      background-color: #b5f34d;
      color: #121212;
      border: none;
      border-radius: 16px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.2s;
    }

    .btn:hover {
      background-color: #ffd500ff;
    }

    .btn-black {
      margin-top: 15px;
      width: 100%;
      padding: 14px;
      font-size: 16px;
      background-color: #2a2a2a;
      color: #ffffff;
      border: 1px solid #444;
      border-radius: 16px;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-black:hover {
      background-color: #3a3a3a;
    }

    .result {
      margin-top: 30px;
      background: #232323;
      padding: 20px;
      border-radius: 16px;
    }

    .rating-output {
      color: #b5f34d;
      font-size: 20px;
    }

    footer {
      margin-top: 60px;
      width: 100%;
      max-width: 800px;
      background: #121212;
      color: #fff;
      padding: 30px;
      border-radius: 24px;
    }
  </style>
</head>
<body>

<?php
$reviews_file = "reviews.txt";


$submissionResult = "";
if (isset($_POST['submit'])) 
    {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $stars = isset($_POST['stars']) ? intval($_POST['stars']) : 0;
    $comment = htmlspecialchars(trim($_POST['comment']));

    if ($stars < 1 || $stars > 5) 
        {
        $submissionResult = "<div class='result'>⚠️ Please select a valid star rating.</div>";
    } 
    else 
        {
        $review = [
            'name' => $name,
            'phone' => $phone,
            'stars' => $stars,
            'comment' => $comment
        ];

    
        file_put_contents($reviews_file, json_encode($review) . PHP_EOL, FILE_APPEND);

        $submissionResult = "<div class='result'>
                <strong>👤 Name:</strong> $name<br>
                <strong>📞 Phone:</strong> $phone<br>
                <strong>⭐ Rating:</strong> <span class='rating-output'>" . str_repeat("★", $stars) . "</span><br>
                <strong>📝 Comment:</strong> $comment
              </div>";
    }
}
?>

<div id="transaction-popup">
  <div class="popup-content">
    <p>🔄 Loading </p>
  </div>
</div>



<div class="card">
  <h2>Leave a Review</h2>

  <form method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required>

    <label for="phone">Phone Number</label>
    <input type="number" name="phone" id="phone" required>

    <label>Rating</label>
    <div class="stars">
      <?php
      for ($i = 5; $i >= 1; $i--)
         {
        echo "<input type='radio' name='stars' id='star$i' value='$i'>
              <label for='star$i'>★</label>";
      }
      ?>
    </div>

    <label for="comment">Comment</label>
    <textarea name="comment" id="comment" rows="4" required></textarea>

    <button class="btn" type="submit" name="submit">Submit Review</button>
    <button class="btn-black" type="reset">Reset Form</button>
  </form>


  <?php echo $submissionResult; ?>
</div>


<footer>
  <h2 style="text-align: center; color: #b5f34d;">All Reviews</h2>
  <div class="result">
    <?php
    if (file_exists($reviews_file))
         {
        $lines = file($reviews_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) 
            {
            $review = json_decode($line, true);
            echo "<div style='margin-bottom: 20px; border-bottom: 1px dashed #444; padding-bottom: 10px;'>
                    <strong>👤 {$review['name']}</strong><br>
                    <strong>📞 {$review['phone']}</strong><br>
                    <strong>⭐</strong> <span style='color: #b5f34d; font-size: 18px;'>" . str_repeat("★", $review['stars']) . "</span><br>
                    <strong>📝</strong> {$review['comment']}
                  </div>";
        }
    }
     else 
        {
        echo "<p style='text-align:center;'>No reviews yet.</p>";
    }
    ?>
  </div>
</footer>

</body>
</html>
