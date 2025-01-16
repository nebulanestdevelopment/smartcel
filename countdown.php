<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #countdown {
            font-size: 48px;
            margin: 20px;
        }
    </style>
</head>
<body>

    <div id="countdown">00:00</div>

    <script >
$(document).ready(function() {
    // Set the countdown time in minutes
    let countdownMinutes = 1; // Change this to set the countdown duration
    let totalSeconds = countdownMinutes * 60;

    // Function to update the countdown display
    function updateCountdown() {
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;

        // Format minutes and seconds to always show two digits
        minutes = String(minutes).padStart(2, '0');
        seconds = String(seconds).padStart(2, '0');

        $('#countdown').text(`${minutes}:${seconds}`);

        // Decrease total seconds
        if (totalSeconds > 0) {
            totalSeconds--;
        } else {
            clearInterval(countdownInterval);
            $('#countdown').text("Time's up!");
        }
    }

    // Update the countdown every second
    let countdownInterval = setInterval(updateCountdown, 1000);

    // Initial display
    updateCountdown();
});


    </script>
</body>
</html>
