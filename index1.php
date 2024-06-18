<?php
    if (!isset($_GET['location']) || trim($_GET['location']) === '') {
        echo '<div class="alert alert-danger">Please enter a location</div>';
    } else {
        $location = urlencode($_GET['location']);
        $apiKey = '50c63843f59ecb12e0e6bd80040aeed7'; // Replace with your actual API key
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$location&appid=$apiKey&units=metric";
        $weatherInfo = '';
    
        $opts = [
            'http' => [
                'method' => 'GET',
                'timeout' => 10, // Timeout in seconds
            ]
        ];
    
        $context = stream_context_create($opts);
    
        try {
            $response = @file_get_contents($apiUrl);
            if ($response === false) {
                if (isset($http_response_header)) {
                    $error = $http_response_header[0];
                    throw new Exception("API request failed with error: $error");
                }
                throw new Exception('API request failed without error message');
            }
    
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to decode JSON: ' . json_last_error_msg());
            }
    
            if (!isset($data['weather'])) {
                throw new Exception('Weather data not found in response');
            }
            
            $weatherInfo = "
                <div class='card mt-4'>
                    <div class='card-body text-center'>
                        <h5 class='card-title'>Weather in {$data['name']}, {$data['sys']['country']}</h5>
                        <img src='http://openweathermap.org/img/w/{$data['weather'][0]['icon']}.png' alt='Weather Icon'>
                        <p class='card-text'>Temperature: {$data['main']['temp']}°C</p>
                        <p class='card-text'>Humidity: {$data['main']['humidity']}%</p>
                        <p class='card-text'>Wind Speed: {$data['wind']['speed']} m/s</p>
                    </div>
                </div>
            ";
        } catch (Exception $e)
        {
            echo "<div class='alert alert-danger'>{$e->getMessage()}</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="icon" href="C:/xampp/htdocs/Code/node_modules/bootstrap-icons/icons/0-circle-fill.svg" type="image/png"> -->
    <style> 
        .wrapper{
                width: 100vh;
                margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <h1 class="text-center mt-4 mb-3">Weather Information</h1>

        <form action="index1.php" method="get" class="wrapper mt-4">
            <div class="input-group mt-4">
                <input type="text" name="location" id="locationInput" class="form-control" placeholder="Enter City or Zip Code">
                <button type="submit" id="searchButton" class="btn btn-primary">Search</button>
            </div>
        </form>


        <div id="weatherInfo">
            <?php echo $weatherInfo; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
</body>
</html>
