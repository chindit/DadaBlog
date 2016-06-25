<?php

$options = [
    'cost' => 15,
];
echo password_hash("sandwich", PASSWORD_BCRYPT, $options);
