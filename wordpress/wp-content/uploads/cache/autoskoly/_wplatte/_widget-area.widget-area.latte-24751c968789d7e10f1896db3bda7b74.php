<?php //netteCache[01]000588a:2:{s:4:"time";s:21:"0.68336100 1483839965";s:9:"callbacks";a:4:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"E:\autoskoly\wordpress\wp-content\themes\directory2\ait-theme\elements\widget-area\widget-area.latte";i:2;i:1483717659;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:22:"released on 2014-08-28";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:15:"WPLATTE_VERSION";i:2;s:5:"2.9.1";}i:3;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:17:"AIT_THEME_VERSION";i:2;s:5:"1.0.1";}}}?><?php

// source file: E:\autoskoly\wordpress\wp-content\themes\directory2\ait-theme\elements\widget-area\widget-area.latte

?><?php
// prolog NCoreMacros
list($_l, $_g) = NCoreMacros::initRuntime($template, 'jhkxcju37o')
;
// prolog NUIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return NUIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
NCoreMacros::includeTemplate($el->common('header'), $template->getParameters(), $_l->templates['jhkxcju37o'])->render() ?>

<div id="<?php echo NTemplateHelpers::escapeHtml($htmlId, ENT_COMPAT) ?>" class="<?php echo NTemplateHelpers::escapeHtml($htmlClass, ENT_COMPAT) ?>">

<?php if ($wp->isWidgetAreaActive($el->option->area->sidebar)) { ?>
		<div class="widget-area-container">
<?php dynamic_sidebar($el->option->area->sidebar) ?>
		</div>
<?php } else { ?>
		<div class="widget-area-container">
			<div class="alert alert-info">
				<?php echo NTemplateHelpers::escapeHtml(_x('Widget Area', 'name of element', 'wplatte'), ENT_NOQUOTES) ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo NTemplateHelpers::escapeHtml(__('Info: There are no widgets in selected area, add some please.', 'wplatte'), ENT_NOQUOTES) ?>

			</div>
		</div>
<?php } ?>

<?php NCoreMacros::includeTemplate(WpLatteMacros::getTemplatePart("ait-theme/elements/widget-area/javascript", ""), array() + get_defined_vars(), $_l->templates['jhkxcju37o'])->render() ?>
</div>
