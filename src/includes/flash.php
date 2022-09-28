<?php

// flash message
function flash($message)
{
    $_SESSION['flash'] = [
        'message' => $message,
    ];
}