<?="<?xml version=\"1.0\" encoding=\"utf-8\"?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?=$this->_get('title')?></title>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<link type="text/css" rel="stylesheet" href="/style.css" />
		<script type="text/javascript" src="/js/sort.js"></script>
	</head>
	<body>
		<?php
			new MenuC('menu');
			$this->_print_child();
		?>
		<div id="messages">
			<?php
				new MessageC('index');
				$this->_print_child();
			?>
		</div>
		<div id="content">
			<?php
				$this->_print_child();
			?>
		</div>
	</body>
</html>

