<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage OrderStatus
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 5981 2012-05-01 23:51:25Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

AdminUIHelper::startAdminArea();

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div id="editcell">
		<table class="adminlist" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th width="10">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->orderStatusList); ?>);" />
			</th>

			<th>
			<?php echo $this->sort('order_status_name') ?>
			</th>
			<th>
			<?php echo $this->sort('order_status_code') ?>
			</th>
			<th>
				<?php echo JText::_('COM_VIRTUEMART_DESCRIPTION'); ?>
			</th>
			<th>
			<?php  echo $this->sort('ordering')  ?>
			<?php echo JHTML::_('grid.order',  $this->orderStatusList ); ?>
			</th>
			<th width="20">
				<?php echo JText::_('COM_VIRTUEMART_PUBLISHED'); ?>
			</th>
			<th><?php echo $this->sort('virtuemart_orderstate_id', 'COM_VIRTUEMART_ID')  ?></th>
		</tr>
		</thead>
		<?php
		$k = 0;
                $vmCoreStatusCode= $this->lists['vmCoreStatusCode'];
		for ($i = 0, $n = count($this->orderStatusList); $i < $n; $i++) {
			$row = $this->orderStatusList[$i];
			$published = JHTML::_('grid.published', $row, $i );
			$checked = JHTML::_('grid.id', $i, $row->virtuemart_orderstate_id);

                        $coreStatus = (in_array($row->order_status_code, $this->lists['vmCoreStatusCode']));
			$image = ((JVM_VERSION===1)) ? 'checked_out.png' : 'admin/checked_out.png';
			$image = JHtml::_('image.administrator', $image, '/images/', null, null, JText::_('COM_VIRTUEMART_ORDER_STATUS_CODE_CORE'));
			$checked = ($coreStatus) ?
				'<span class="hasTip" title="'. JText::_('COM_VIRTUEMART_ORDER_STATUS_CODE_CORE').'">'. $image .'</span>' :
				JHTML::_('grid.id', $i, $row->virtuemart_orderstate_id);

			$editlink = JROUTE::_('index.php?option=com_virtuemart&view=orderstatus&task=edit&cid[]=' . $row->virtuemart_orderstate_id);
			$deletelink	= JROUTE::_('index.php?option=com_virtuemart&view=orderstatus&task=remove&cid[]=' . $row->virtuemart_orderstate_id);
			$ordering = $row->ordering ;
		?>
			<tr class="row<?php echo $k ; ?>">
				<td width="10">
					<?php echo $checked; ?>
				</td>

				<td align="left">
					<a href="<?php echo $editlink; ?>"><?php echo JText::_($row->order_status_name); ?></a>
				</td>
				<td align="left">
					<?php echo $row->order_status_code; ?>
				</td>
				<td align="left">
					<?php echo JText::_($row->order_status_description); ?>
				</td>
				<td align="center" class="order">
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'orderUp', JText::_('COM_VIRTUEMART_MOVE_UP')); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderDown', JText::_('COM_VIRTUEMART_MOVE_DOWN')); ?></span>
					<input class="ordering" type="text" name="order[<?php echo $i?>]" id="order[<?php echo $i?>]" size="5" value="<?php echo $row->ordering; ?>" style="text-align: center" />
				</td>
				<td align="center"><?php echo $published; ?></td>
				<td width="10">
					<?php echo $row->virtuemart_orderstate_id; ?>
				</td>
			</tr>
			<?php
// 			<td class="order">
// 						<span><?php echo ShopFunctions::orderUpIcon( $i, true, 'orderup', 'Move Up' ); ></span>
// 						<span><?php echo ShopFunctions::orderDownIcon( $i, $n, true, 'orderdown', 'Move Down' ); ></span>
// 					<input class="ordering" type="text" name="order[]" size="5" value="<?php echo $row->ordering;>" class="text_area" style="text-align: center" />
// 				</td>
			$k = 1 - $k;
		}
		?><?php /* NO limit used in model
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		*/ ?>
	</table>
</div>

	<?php echo $this->addStandardHiddenToForm(); ?>
</form>

<?php AdminUIHelper::endAdminArea(); ?>
