<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Jacob">
    <meta name="description" content="HomePage">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLDR: Home Page</title>
    <link rel="stylesheet" href="style/home-page.css" />
    <script src="scripts/home.js" defer></script>
</head>

<body>
    <h1 class="page-title" id="home-page-header">
        <div class="dropdown">
            <button class="dropbtn">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>

            </button>
            <div class="dropdown-content">
                <a href="drives.php">View Drives</a>
                <a href="learners/view-cbta.php">CBTA</a>
                <a href="learners/my-account.php">Account</a>
                
            </div>
        </div>
        <label>Home Page</label>
    </h1>
    <?php
    $id = $_SESSION["userID"];
    $licenseNo = "";
    $sql = "SELECT firstName, lastName, licenseNo FROM Users WHERE id = '$id';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $licenseNo = $row["licenseNo"];
            echo "<p>Welcome " . $row["firstName"] . " " . $row["lastName"] . ".</p>";
        }
    }

    $all_minutes = array();

    // Daytime
    $sql = "SELECT sum(hour(duration)), sum(minute(duration)) FROM Drives WHERE learnerLicenseNo = '$licenseNo' AND daytime = '1';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $hours = $row["sum(hour(duration))"];
                $minutes = $row["sum(minute(duration))"];
                $minutes = $minutes + ($hours * 60);
                $all_minutes["day"] = $minutes;
            }
        }
    }

    // Nighttime
    $sql = "SELECT sum(hour(duration)), sum(minute(duration)) FROM Drives WHERE learnerLicenseNo = '$licenseNo' AND daytime = '0';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $hours = $row["sum(hour(duration))"];
                $minutes = $row["sum(minute(duration))"];
                $minutes = $minutes + ($hours * 60);
                $all_minutes["night"] = $minutes;
            }
        }
    }

    $all_minutes["total"] = $all_minutes["day"] + $all_minutes["night"];

    $cbta = 0;

    $sql = "SELECT count(*) FROM LogbookCBTA WHERE driverID = '$id' AND completed = '1';";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cbta = $row["count(*)"];
        }
    }

    ?>
    <ul style="list-style: none; padding-left: 0px">
    <li>
        <!-- Logbook Drives Total Progress -->
        <div class="progress-container">
            <div class="progress-label">Total Progress</div>
            <div class="progress-bar" style="
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(green <?php echo round(($all_minutes["total"] / 4500) * 100, 2); ?>%, #d1fff1 0);">
                <p><?php echo round(($all_minutes["total"] / 4500) * 100, 2); ?>%</p>
            </div>
        </div>
    </li>
    <li>
        <!-- Logbook Drives Night Progress -->
        <div class="progress-container">
            <div class="progress-label">Night Progress</div>
            <div class="progress-bar" style="   
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(#383836 <?php echo round(($all_minutes["night"] / 900) * 100, 2); ?>%, #d1fff1 0);">
                <p><?php echo round(($all_minutes["night"] / 900) * 100, 2); ?>%</p>
            </div>
        </div>
    </li>
    <li>
        <!-- Logbook CBTA Progress -->
        <div class="progress-container">
            <div class="progress-label">CBTA Progress</div>
            <div class="progress-bar" style="
                background: 
                    radial-gradient(closest-side, white 79%, transparent 80% 100%),
                    conic-gradient(#e6d150 <?php echo round(($cbta / 48) * 100, 2); ?>%, #d1fff1 0);">
                <p><?php echo round(($cbta / 48) * 100, 2); ?>%</p>
            </div>
        </div>
    </li>
</ul>


</body>

</html>