<?php //netteCache[01]000568a:2:{s:4:"time";s:21:"0.48074100 1483783686";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:81:"D:\MANTRAN\autoskoly\wordpress\wp-content\themes\directory2\parts\breadcrumbs.php";i:2;i:1482236820;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.1";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"1.0.1";}}}?><?php

// source file: D:\MANTRAN\autoskoly\wordpress\wp-content\themes\directory2\parts\breadcrumbs.php

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'nvo6p61x4e')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($options->layout->general->showBreadcrumbs) { ?>
<div class="breadcrumb">
	<!-- <div class="grid-main"> -->
		<?php echo WpLatteMacros::breadcrumbs(array($options->theme->breadcrumbs)) ?>

	<!-- </div> -->
</div>
<?php } 