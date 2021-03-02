<?php

include 'config.php';
include 'keys.php';

$license_error = "";
$location_error = "";
$post_array = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // $post_array = $_POST;

    if (empty($_POST['licenses'])) {
        $license_error = "Please select at least once license.";
    }

    // if (empty($_POST['location'])) {
    //     $location_error = "Please enter a location";
    // }

    if (isset($_POST['search_term']) && !empty($_POST['licenses'])) {

        //lat, lon, and licenses can be passed to the api call without triggering an error if empty
        $search_term = urlencode($_POST['search_term']);
        $latitude = '%00';
        $longitude = '%00';
        $licenses = implode(",", $_POST['licenses']);

        //if a location is specified, pass it to the google maps api to get the latitude and longitude of the location
        if (!empty($_POST['location'])) {

            list($latitude, $longitude) = get_lat_and_lng($google_api_key, $_POST['location']);
        }
    
        $photo_array = get_photo_array($flickr_api_key, $search_term, $latitude, $longitude, $licenses);

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jusuur Flickr Search</title>
    <link href="/flickrSearch/css/styles.css" type="text/css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Syne:wght@400;500&display=swap" rel="stylesheet"> 
</head>
<body>
    <h2>Flickr Search</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <label>Search term</label>
            <input type="text" name="search_term" value="<?php if (isset($_POST['search_term'])) { echo htmlspecialchars($_POST['search_term']); } ?>">
            <p class="explanation">Term to search on Flickr</p>
        <label>City</label>
            <input type="text" name="location" value="<?php if (isset($_POST['location'])) { echo htmlspecialchars($_POST['location']); } ?>">
            <p class="explanation">If specified, will return photos geotagged to within roughly 30km of the city center.</p>
            <span class="error"><?php echo $location_error; ?></span>
        <label>Licenses</label>
            <div class='licenses'>

            <label class="container">All Rights Reserved
                <input type='checkbox' name="licenses[]" value="0" <?php echo defaultUnchecked(0) ?>>
                <span class="checkmark"></span>
            </label>
            
            <label class="container">Attribution-NonCommercial-ShareAlike License  <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/" target="_blank">Learn more</a>
                <input type='checkbox'  name="licenses[]" value="1" <?php echo defaultUnchecked(1) ?>>
                <span class="checkmark"></span>
            </label>

            <label class="container">Attribution-NonCommercial License  <a href="https://creativecommons.org/licenses/by-nc/2.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="2" <?php echo defaultUnchecked(2) ?>>
                <span class="checkmark"></span>
            </label>

            <label class="container">Attribution-NonCommercial-NoDerivs License  <a href="https://creativecommons.org/licenses/by-nc-nd/2.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="3" <?php echo defaultUnchecked(3) ?>>
                <span class="checkmark"></span>
            </label>

            <label class="container">Attribution License  <a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="4" <?php echo defaultChecked(4) ?>>  
                <span class="checkmark"></span>
            </label>

            <label class="container">Attribution-ShareAlike License  <a href="https://creativecommons.org/licenses/by-sa/2.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="5" <?php echo defaultChecked(5) ?>>
                <span class="checkmark"></span>
            </label>

            <label class="container">Attribution-NoDerivs License  <a href="https://creativecommons.org/licenses/by-nd/2.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="6" <?php echo defaultUnchecked(6) ?>>  
                <span class="checkmark"></span>
            </label>

            <label class="container">No known copyright restrictions  <a href="https://www.flickr.com/commons/usage/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="7" <?php echo defaultChecked(7) ?>>  
                <span class="checkmark"></span>
            </label>

            <label class="container">United States Government Work  <a href="http://www.usa.gov/copyright.shtml" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="8" <?php echo defaultChecked(8) ?>>  
                <span class="checkmark"></span>
            </label>

            <label class="container">Public Domain Dedication (CC0)  <a href="https://creativecommons.org/publicdomain/zero/1.0/" target="_blank">Learn more</a>
                <input type='checkbox' name="licenses[]" value="9" <?php echo defaultChecked(9) ?>>  
                <span class="checkmark"></span>
            </label>
        </div>
        <label class="container">Public Domain Mark  <a href="https://creativecommons.org/publicdomain/mark/1.0/" target="_blank">Learn more</a>
            <input type='checkbox' name="licenses[]" value="10" <?php echo defaultChecked(10) ?>>  
            <span class="checkmark"></span>
        </label>
        <p class="explanation">Default selection will return images licensed for commercial use and modifications.</p>
        <span class="error"><?php echo $license_error; ?></span>
        <label>Minimum DPI</label>
            <input type="number" name="dpi" value="<?php if (isset($_POST['dpi'])) { echo htmlspecialchars($_POST['dpi']); } ?>">
        <button type="submit">Submit</button>
    </form>
    <p><?php print_r($post_array); ?></p>
    <div class="photos">
        <?php if (isset($_POST['search_term']) && !empty($_POST['licenses'])) { display_photos($photo_array, $flickr_api_key); } ?>
    </div>
</body>
</html>