<?php

require 'Lib/OvhRequest.php';

$data = (new OvhRequest())->absoluteFullRequest('0388205784', true);

var_dump($data);