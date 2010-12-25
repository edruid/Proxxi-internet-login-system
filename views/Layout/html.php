<?="<?xml version=\"1.0\" encoding=\"utf-8\"?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?=$this->_get('title')?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link type="text/css" rel="stylesheet" href="/style.css" />
		<script type="text/javascript" src="/js/sort.js"></script>
		<script type="text/javascript" src="/js/dom.js"></script>
	</head>
	<body>
		<?php
			new MenuC('menu');
			$this->_print_child();
		?>
		<div id="content">
			<div id="messages">
				<?php
					new MessageC('index');
					$this->_print_child();
				?>
			</div>
			<?php
				$this->_print_child();
			?>
		</div>
		<div id="footer">
			<p>Systemet är skapat av Eric Druid (druid at proxxi dot org) 0739586929</p>
		</div>
	</body>
</html>

