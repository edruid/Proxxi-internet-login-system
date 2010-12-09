<h1><?=$group?></h1>
<?php
$this->_register('caption', 'Gruppmedlemmar');
UserC::_display('_list');
$this->_print_child();
?>
