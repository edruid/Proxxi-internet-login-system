<h1>Närvarorapport</h1>
<?php
$this->_register('caption', "Närvarande $date");
UserC::_display('_list');
$this->_print_child();
?>
