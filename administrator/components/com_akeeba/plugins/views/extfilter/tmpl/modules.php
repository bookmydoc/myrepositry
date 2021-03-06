<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2013 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 *
 * @since 2.1
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

JLoader::import('joomla.html.html');
JHtml::_('behavior.framework');

?>
<div class="alert alert-info">
	<strong><?php echo JText::_('CPANEL_PROFILE_TITLE'); ?>: #<?php echo $this->profileid; ?></strong>
	<?php echo $this->profilename; ?>
</div>

<table class="table table-striped" width="100%">
	<thead>
		<tr>
			<th width="50px"><?php echo JText::_('EXTFILTER_LABEL_STATE'); ?></th>
			<th><?php echo JText::_('EXTFILTER_LABEL_MODULE'); ?></th>
			<th><?php echo JText::_('EXTFILTER_LABEL_AREA'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$i = 0;
	foreach($this->modules as $module):
	$i++;
	$link = JURI::base().'index.php?option=com_akeeba&view=extfilter&task=toggleModule&item='.$module['item'].'&root='.$module['root'].'&random='.time();
	$area = ($module['root'] == 'frontend') ? JText::_('EXTFILTER_LABEL_FRONTEND') : JText::_('EXTFILTER_LABEL_BACKEND');
	if($module['status'])
	{
		if(version_compare(JVERSION, '3.0', 'lt')) {
			$image = JHTML::_('image.administrator', 'admin/publish_x.png');
		} else {
			$image = '<i class="icon-unpublish"></i>';
		}
		$html = '<b>'.$module['name'].'</b>';
	}
	else
	{
		if(version_compare(JVERSION, '3.0', 'lt')) {
			$image = JHTML::_('image.administrator', 'admin/tick.png');
		} else {
			$image = '<i class="icon-publish"></i>';
		}
		$html = $module['name'];
	}

	?>
		<tr class="row<?php echo $i%2; ?>">
			<td style="text-align: center;"><a href="<?php echo $link ?>"><?php echo $image ?></a></td>
			<td><a href="<?php echo $link ?>"><?php echo $html ?></a></td>
			<td><?php echo $area ?></td>
		</tr>
	<?php
	endforeach;
	?>
	</tbody>
</table>