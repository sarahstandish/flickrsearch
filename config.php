<?php

$google_api_key = 'AIzaSyAr7uAWzNf62vbQYuX8kiJULqgQ01JsErE';
$flickr_api_key = '7441a4ff83fda0c1e35cbd7c4016210f';


function get_lat_and_lng($google_api_key, $location) {

    $location = urlencode($_POST['location']);

    $maps_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$location&key=$google_api_key";

    $maps_json = file_get_contents($maps_url);

    $maps_array = json_decode($maps_json, true);

    $latitude = $maps_array['results'][0]['geometry']['location']['lat'];
    $longitude = $maps_array['results'][0]['geometry']['location']['lng'];

    return [$latitude, $longitude];

}

function display_photos($photo_array, $flickr_api_key) {


    if (empty($photo_array)) {
        $result = false;
    } else {
        foreach($photo_array as $photo) {
            $server_id = $photo['server'];
            $photo_id = $photo['id'];
            $photo_secret = $photo['secret'];
            $photo_owner = $photo['owner'];
    
            if (!empty($_POST['dpi']) && checkDPI($_POST['dpi'], $photo_id, $photo_secret, $flickr_api_key)) {
                    echo "<a href='https://www.flickr.com/photos/$photo_owner/$photo_id' target='_blank'><img src='https://live.staticflickr.com/$server_id/" . $photo_id . "_" . "$photo_secret.jpg'></a>";
                    $result = true;
            } if (isset($_POST['search_term']) && empty($_POST['dpi'])) {
                echo "<a href='https://www.flickr.com/photos/$photo_owner/$photo_id' target='_blank'><img src='https://live.staticflickr.com/$server_id/" . $photo_id . "_" . "$photo_secret.jpg'></a>";
                $result = true;
            }
        }
    }

    if (!$result) {
        echo "No photos match your search.";
    }


}

function checkDPI($dpi, $photo_id, $photo_secret, $flickr_api_key) {

    set_time_limit(0);

    $photo_url = "https://www.flickr.com/services/rest/?method=flickr.photos.getExif&api_key=$flickr_api_key&photo_id=$photo_id&secret=$photo_secret&format=json&nojsoncallback=1";
    
    $photo_json = file_get_contents($photo_url);

    $one_photo_array = json_decode($photo_json, true);

    if (in_array('photo', array_keys($one_photo_array))) {
        foreach ($one_photo_array['photo']['exif'] as $item) {
        
            if (in_array('X-Resolution', $item, true)) {
                if ($item['raw']['_content'] >= $dpi) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    } else {
        return false;
    }


}


function defaultChecked($n) {
    if (isset($_POST['licenses']) && in_array($n, $_POST['licenses'])) {
        return "checked='checked'";
    } else if (isset($_POST['licenses']) && !in_array($n, $_POST['licenses'])) {
        return "";
    } else {
        return "checked='checked'";
    }
}

function defaultUnchecked($n) {
    if (isset($_POST['licenses']) && in_array($n, $_POST['licenses'])) {
        return "checked='checked'";
    } else if (isset($_POST['licenses']) && !in_array($n, $_POST['licenses'])) {
        return "";
    } else {
        return "";
    }
}


?>