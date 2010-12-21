<h1>Användare</h1>
<?php
$this->_register('caption', 'Medlemmar');
UserC::_display('_list');
$this->_print_child();
?>
