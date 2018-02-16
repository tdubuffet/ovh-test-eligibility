<?php

require 'Lib/OvhRequest.php';

$data = (new OvhRequest())->absoluteFullRequest('0237265811', true);

var_dump($data);