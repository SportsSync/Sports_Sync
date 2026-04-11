<?php
session_start();
$conn = new mysqli("localhost:3306", "root", "", "turf_booking_system");

if ($conn->connect_error) {
    die("DB Error");
}

// Fetch plans
$plans = $conn->query("SELECT * FROM ad_plans ORDER BY priority_score ASC");

// Handle AJAX request
if(isset($_POST['buy_plan'])) {

    $plan_id = $_POST['plan_id'];
    $turf_id = $_SESSION['turf_id'];
    $vendor_id = $_SESSION['vendor_id'];

    $plan = $conn->query("SELECT * FROM ad_plans WHERE id=$plan_id")->fetch_assoc();

    $start = date('Y-m-d H:i:s');
    $end = date('Y-m-d H:i:s', strtotime("+{$plan['duration_days']} days"));

    $conn->query("
        INSERT INTO turf_ads (turf_id, vendor_id, plan_id, start_date, end_date, is_active, payment_status)
        VALUES ($turf_id, $vendor_id, $plan_id, '$start', '$end', 1, 'paid')
    ");

    echo "success";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boost Turf</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at 20% 20%, #1a0033, #050510 70%);
            color: white;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Background glow blobs */
        .bg-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(155,0,255,0.3), transparent);
            filter: blur(120px);
            z-index: 0;
        }

        .glow1 { top: -100px; left: -100px; }
        .glow2 { bottom: -100px; right: -100px; }

        .header {
            text-align: center;
            margin: 80px 0 40px;
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(90deg, #7b2ff7, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: #aaa;
        }

        .plan-card {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(255,255,255,0.08);
            overflow: hidden;
        }

        /* Neon border effect */
        .plan-card::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1px;
            background: linear-gradient(45deg, #7b2ff7, transparent, #00c6ff);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .plan-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 0 40px rgba(155,0,255,0.4);
        }

        .plan-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .price {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 20px 0;
        }

        .features {
            font-size: 0.9rem;
            color: #bbb;
            margin-bottom: 25px;
        }

        /* Futuristic button */
        .btn-neon {
            position: relative;
            padding: 12px 30px;
            border-radius: 30px;
            color: white;
            border: none;
            background: linear-gradient(45deg, #7b2ff7, #00c6ff);
            overflow: hidden;
            transition: 0.3s;
        }

        .btn-neon::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: translateX(-100%);
        }

        .btn-neon:hover::before {
            transform: translateX(100%);
            transition: 0.6s;
        }

        .btn-neon:hover {
            transform: scale(1.05);
        }

        /* Best plan emphasis */
        .best {
            transform: scale(1.08);
            box-shadow: 0 0 30px rgba(0, 119, 255, 0.5);
        }

        .badge-best {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, rgb(173, 1, 4), #7b2ff7);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

    </style>
</head>

<body>

<div class="bg-glow glow1"></div>
<div class="bg-glow glow2"></div>

<div class="container">

    <div class="header">
        <h1>Boost Visibility</h1>
        <p>Get discovered. Get booked. Dominate listings.</p>
    </div>

    <div class="row justify-content-center">

        <?php 
        $i = 0;
        while($row = $plans->fetch_assoc()) { 
            $isBest = ($i == 1);
        ?>

        <div class="col-md-4 mb-4">

            <div class="plan-card <?php echo $isBest ? 'best' : ''; ?>">

                <?php if($isBest) { ?>
                    <div class="badge-best">POPULAR</div>
                <?php } ?>

                <div class="plan-title">
                    <?php echo $row['name']; ?>
                </div>

                <div class="price">
                    ₹<?php echo $row['price']; ?>
                </div>

                <div class="features">
                    ⚡ <?php echo $row['duration_days']; ?> Days Boost<br>
                    🚀 Top Listing Priority<br>
                    📈 More Bookings
                </div>

                <button 
                    class="btn-neon buy-btn"
                    data-id="<?php echo $row['id']; ?>"
                >
                    Activate Boost
                </button>

            </div>

        </div>

        <?php $i++; } ?>

    </div>

</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center bg-dark text-white">

      <div class="modal-body p-5">
        <h2 style="color:#00ffcc;">🚀 BOOST ACTIVE</h2>
        <p>Your turf is now dominating the listings.</p>
        <button class="btn-neon" data-bs-dismiss="modal">Continue</button>
      </div>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(".buy-btn").click(function() {

    let plan_id = $(this).data("id");

    $.ajax({
        url: "",
        method: "POST",
        data: {
            buy_plan: true,
            plan_id: plan_id
        },
        success: function(res) {

            if(res.trim() === "success") {
                let modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            }
        }
    });

});
</script>

</body>
</html>