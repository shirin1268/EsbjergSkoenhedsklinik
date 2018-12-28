<?php
function redirect_to( $location) {

    header("refresh:5; Location:" . $location);
    exit;
}
