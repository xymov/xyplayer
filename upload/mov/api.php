
<?php
include ('config.php');
exit(filter_input(INPUT_GET, 'callback') . '(' . json_encode($CONFIG['js_config']) . ');');