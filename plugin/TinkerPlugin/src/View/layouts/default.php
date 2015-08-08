<?php //header('Content-type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html>
	<head>
		<link href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css" rel="stylesheet">
		<style>
			body{
				padding: 0;
				margin: 0;
				background: #000;
			}
			
			.wrapper{
				background: #fff;
				margin: 0 auto;
				max-width: 960px;

			}
			
			nav,
			footer,
			.content{
				padding: 8px;
			}
			
			nav,
			footer{
				background: #efefef;
			}
			
			footer{
				font-size: 83%;
			}
			
		</style>
	</head>
	<body>
		<div class="wrapper">
			<nav>TinkerMVC</nav>
			<div class="content"><?php echo $View->getOutput(); ?></div>
			<footer>
				<?php echo 'Hi, it took Apache ' . $View->BuildTime->end() . ' seconds to render this page.'; ?>
			</footer>
		</div>
	</body>
</html>