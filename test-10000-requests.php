<?php

require 'Lib/OvhRequest.php';


$request = 1;
do {

    $data = (new OvhRequest())->absoluteFullRequest('0237265811', true);
    var_dump($data);

    echo  "\n\n" . $request++ . "\n\n";
} while($data != false);



echo  "\n\n Crash after " . $request . " requests\n\n";