<?php
include 'config.php';
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

    <label class="container">Public Domain Mark  <a href="https://creativecommons.org/publicdomain/mark/1.0/" target="_blank">Learn more</a>
        <input type='checkbox' name="licenses[]" value="10" <?php echo defaultChecked(10) ?>>  
        <span class="checkmark"></span>
    </label>
    
</body>
</html>