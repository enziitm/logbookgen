<link rel="stylesheet" type="text/css" href="style.css">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_km = intval($_POST["start_km"]);
    $end_km = intval($_POST["end_km"]);
    $start_date = strtotime($_POST["start_date"]);
    $end_date = strtotime($_POST["end_date"]);

    if ($start_km >= $end_km || $start_date >= $end_date) {
        echo "Ending KM must be greater than Starting KM, and End Date must be later than Start Date.";
    } else {
        // Initialize current odometer reading and current date
        $current_odometer = $start_km;
        $current_date = $start_date;

        // Initialize the $results array
        $results = array();

        // Generate random trips and add them to the $results array
        while ($current_odometer < $end_km && $current_date < $end_date) {
            $random_distance = rand(5, 167); // Generate random trip length between 5km and 167km
            $remaining_distance = $end_km - $current_odometer;

            $random_days = rand(1, 10); // Generate a random number of days between 1 and 10
            $current_date = strtotime("+$random_days days", $current_date);

            // Ensure that the random distance does not exceed the remaining distance
            $random_distance = min($random_distance, $remaining_distance);

            $current_odometer += $random_distance;

            $results[] = array(
                "date" => $current_date,
                "distance" => $random_distance,
                "current_odometer" => $current_odometer
            );
        }

        // Display user input for Starting KM and Ending KM
        echo "<h2 class='trip-title'>Generated Trips</h2>";
        echo "<div class='km-box'>";
        echo "<p>Start KM: $start_km</p>";
        echo "<p>End KM: $end_km</p>";
        echo "</div>";

        // Display results in a table
        echo "<table>";
        echo "<tr><th>Date</th><th>Distance (KM)</th><th>Current Odometer</th></tr>";
        foreach ($results as $index => $trip) {
            echo "<tr>";
            echo "<td>" . date("Y-m-d", $trip["date"]) . "</td>";
            echo "<td>" . $trip["distance"] . "</td>";
            echo "<td>" . $trip["current_odometer"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

function generateRandomTrips($current_odometer, $end_km, $current_date, $end_date) {
    $results = array();
    
    while ($current_odometer < $end_km && $current_date < $end_date) {
        $random_distance = rand(5, 167); // Generate random trip length between 5km and 167km
        $remaining_distance = $end_km - $current_odometer;
        
        $random_days = rand(1, 10); // Generate a random number of days between 1 and 10
        $current_date = strtotime("+$random_days days", $current_date);
        
        // Ensure that the random distance does not exceed the remaining distance
        $random_distance = min($random_distance, $remaining_distance);

        $current_odometer += $random_distance;

        $results[] = array(
            "date" => $current_date,
            "distance" => $random_distance,
            "current_odometer" => $current_odometer
        );
    }
    
    return $results;
}
?>
