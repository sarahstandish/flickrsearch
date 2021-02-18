<?php

include 'config.php';
include 'keys.php';

if (isset($_POST['search_term'])) {

    $search_term = urlencode($_POST['search_term']);
    $latitude = '%00';
    $longitude = '%00';
    $licenses = '%00';

    if (!empty($_POST['location'])) {

        $lat_and_lng = get_lat_and_lng($google_api_key, $_POST['location']);
        $latitude = $lat_and_lng[0];
        $longitude = $lat_and_lng[1];
    }

    if (isset($_POST['licenses'])) {

        $licenses = implode(",", $_POST['licenses']);

    }
    
    $flickr_url = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=$flickr_api_key&text=$search_term&content_type=1&per_page=500&format=json&nojsoncallback=1&sort=relevance&radius=32&lat=$latitude&lon=$longitude&license=$licenses";

    $flickr_json = file_get_contents($flickr_url);

    $flickr_array = json_decode($flickr_json, true);
    $photo_array = $flickr_array['photos']['photo'];

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
    <form action="" method="post">
        <label>Search term</label>
            <input type="text" name="search_term" value="<?php if (isset($_POST['search_term'])) { echo $_POST['search_term']; } ?>">
            <p class="explanation">Term to search on Flickr</p>
        <label>City</label>
            <input type="text" name="location" value="<?php if (isset($_POST['location'])) { echo $_POST['location']; } ?>">
            <p class="explanation">If specified, will return photos geotagged to within roughly 30km of the city center.</p>
        <label>Licenses</label>
            <ul>
                <li><input type='checkbox' name="licenses[]" value="0" <?php echo defaultUnchecked(0) ?>>  All Rights Reserved  </li>
                <li><input type='checkbox'  name="licenses[]" value="1" <?php echo defaultUnchecked(1) ?>>  Attribution-NonCommercial-ShareAlike License  <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="2" <?php echo defaultUnchecked(2) ?>>  Attribution-NonCommercial License  <a href="https://creativecommons.org/licenses/by-nc/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="3" <?php echo defaultUnchecked(3) ?>>  Attribution-NonCommercial-NoDerivs License  <a href="https://creativecommons.org/licenses/by-nc-nd/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="4" <?php echo defaultChecked(4) ?>>  Attribution License  <a href="https://creativecommons.org/licenses/by/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="5" <?php echo defaultChecked(5) ?>>  Attribution-ShareAlike License  <a href="https://creativecommons.org/licenses/by-sa/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="6" <?php echo defaultUnchecked(0) ?>>  Attribution-NoDerivs License  <a href="https://creativecommons.org/licenses/by-nd/2.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="7" <?php echo defaultChecked(7) ?>>  No known copyright restrictions  <a href="https://www.flickr.com/commons/usage/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="8" <?php echo defaultChecked(8) ?>>  United States Government Work  <a href="http://www.usa.gov/copyright.shtml" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="9" <?php echo defaultChecked(9) ?>>  Public Domain Dedication (CC0)  <a href="https://creativecommons.org/publicdomain/zero/1.0/" target="_blank">Learn more</a></li>
                <li><input type='checkbox' name="licenses[]" value="10" <?php echo defaultChecked(10) ?>>  Public Domain Mark<a href="https://creativecommons.org/publicdomain/mark/1.0/" target="_blank">Learn more</a></li>
            </ul>
        <p class="explanation">Default selection will return images licensed for commercial use and modifications.</p>
        <label>Minimum DPI</label>
            <input type="number" name="dpi" value="<?php if (isset($_POST['dpi'])) { echo $_POST['dpi']; } ?>">
        <button type="submit">Submit</button>
    </form>
    <div class="photos">
        <?php if (isset($_POST['search_term'])) { display_photos($photo_array, $flickr_api_key); } ?>
    </div>
</body>
</html>