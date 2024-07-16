<?php

$con = mysqli_connect("localhost", "dckap", "Dckap2023Ecommerce", "user_management");

if (mysqli_connect_error()) {
    echo "failed to connect " . mysqli_connect_error();
}
