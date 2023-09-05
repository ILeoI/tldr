<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Coby Murphy">
    <link rel="stylesheet" href="./style/drives.css" />
    <title>Drives</title>
</head>

<body>

    <div class="center" id="add-drive-form">
        <form id="add-drive" action="add-drive.php" method="POST">
            <h1>Add Drive</h1>
            <ul>
                <li>
                    <label for="date">Date</label><br>
                    <input type="date" name="date" required>
                </li>

                <li>
                    <label for="start-time">Start Time</label><br>
                    <input type="time" name="start-time" required>
                </li>

                <li>
                    <label for="end-time">End Time</label><br>
                    <input type="time" name="end-time" required>
                </li>

                <li>
                    <label for="start-location">Start Location</label><br>
                    <input type="text" name="start-location" class="text" placeholder="Suburb" required>
                </li>

                <li>
                    <label for="furthest-location">Furthest Location</label><br>
                    <input type="text" name="furthest-location" class="text" placeholder="Suburb" required>
                </li>

                <li>
                    <label>Road Type</label><br>
                    <input type="radio" name="sealed"><label>Sealed</label>
                    <input type="radio" name="unsealed"><label>Unsealed</label><br>
                    <input type="radio" name="quiet-street"><label>Quiet Street</label>
                    <input type="radio" name="busy-road"><label>Busy Road</label>
                    <input type="radio" name="multi-laned-road"><label>Multi-laned Road</label>
                </li>

                <li>
                    <label>Weather</label><br>
                    <input type="radio" name="dry"><label for="dry">Dry</label>
                    <input type="radio" name="wet"><label for="wet">Wet</label>
                </li>

                <li>
                    <label>Traffic Density</label><br>
                    <input type="radio" name="light"><label>Light</label>
                    <input type="radio" name="medium"><label>Medium</label>
                    <input type="radio" name="heavy"><label>Heavy</label>
                </li>

                <li>
                
                    <input type="radio" name="daytime"><label>Daytime</label>
                    <input type="radio" name="night-time"><label>Night-time</label>
                    
                </li>

            </ul>
            <input type="button" class="submit" value="Submit">

        </form>
    </div>


</body>

</html>
