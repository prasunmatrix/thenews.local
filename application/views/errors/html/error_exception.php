<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;font-family: auto;">

<h4>An uncaught Exception was encountered</h4>

<p style="font-family: auto;">Type: <?php echo get_class($exception); ?></p>
<p style="font-family: auto;">Message: <?php echo $message; ?></p>
<p style="font-family: auto;">Filename: <?php echo $exception->getFile(); ?></p>
<p style="font-family: auto;">Line Number: <?php echo $exception->getLine(); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px;font-family: auto;">
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>