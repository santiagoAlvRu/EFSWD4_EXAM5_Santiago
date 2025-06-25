<?php

function cleanInputs($input)
{

    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}

function fileUpload($picture, $source = "user")
{
    if ($picture["error"] == 4) {

        if ($source == "pet") {
            $pictureName = "pet.png";
        }

        $message = "No picture has been chosen, but you can upload an image later :)";
    } else {
        $checkIfImage = getimagesize($picture["tmp_name"]);
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if ($message == "Ok") {
        $ext = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION));
        $pictureName = uniqid("") . "." . $ext;
        $destination = "img/{$pictureName}";
        if ($source == "pet") {
            $destination = "../img/{$pictureName}";
        }
        move_uploaded_file($picture["tmp_name"], $destination);
    }

    return [$pictureName, $message];
}
