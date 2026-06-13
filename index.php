<?php
$file = "votes.json";

if (!file_exists($file)) {
    file_put_contents($file, json_encode([
        "ketan" => 100,
        "sunny" => 0
    ]));
}

$data = json_decode(file_get_contents($file), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate = $_POST['candidate'];

    if ($candidate == "ketan") {
        $data['ketan']++;
    } elseif ($candidate == "sunny") {
        $data['sunny']++;
    }

    file_put_contents($file, json_encode($data));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vote for Your Favorite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:linear-gradient(135deg,#4f46e5,#9333ea);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .card{
            background:white;
            width:100%;
            max-width:500px;
            padding:30px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 15px 40px rgba(0,0,0,0.2);
        }

        h1{
            margin-bottom:25px;
            color:#222;
        }

        .candidate{
            margin:15px 0;
        }

        button{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            font-size:18px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .ketan{
            background:#2563eb;
            color:white;
        }

        .sunny{
            background:#f97316;
            color:white;
        }

        button:hover{
            transform:scale(1.03);
        }

        .results{
            margin-top:30px;
            text-align:left;
        }

        .bar{
            height:25px;
            border-radius:20px;
            margin-top:5px;
        }

        .blue{
            background:#2563eb;
        }

        .orange{
            background:#f97316;
        }

        .label{
            margin-top:15px;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>🗳 Vote Now</h1>

    <form method="POST">
        <div class="candidate">
            <button class="ketan" name="candidate" value="ketan">
                Vote for Ketan
            </button>
        </div>

        <div class="candidate">
            <button class="sunny" name="candidate" value="sunny">
                Vote for Sunny
            </button>
        </div>
    </form>

    <?php
    $total = $data['ketan'] + $data['sunny'];
    $ketanPercent = $total ? ($data['ketan'] / $total) * 100 : 0;
    $sunnyPercent = $total ? ($data['sunny'] / $total) * 100 : 0;
    ?>

    <div class="results">
        <h2>Results</h2>

        <div class="label">
            Ketan Gupta- <?php echo $data['ketan']; ?> votes
        </div>
        <div class="bar blue" style="width:<?php echo $ketanPercent; ?>%"></div>

        <div class="label">
            Sunny Bhagat- <?php echo $data['sunny']; ?> votes
        </div>
        <div class="bar orange" style="width:<?php echo $sunnyPercent; ?>%"></div>

        <p style="margin-top:20px;">
            Total Votes: <b><?php echo $total; ?></b>
        </p>
    </div>
</div>

</body>
</html>
