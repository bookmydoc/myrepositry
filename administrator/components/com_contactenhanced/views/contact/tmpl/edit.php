<?php
/**
 * @package		com_contactenhanced
* @copyright	Copyright (C) 2006 - 2010 Ideal Custom Software Development
 * @author     Douglas Machado {@link http://ideal.fok.com.br}
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
<!--
	function submitbutton(task)
	{
		if (task == 'contact.cancel' || document.formvalidator.isValid(document.id('contact-form'))) {
		}
		// @todo Deal with the editor methods
		submitform(task);
	}
// -->
</script>

<form action="<?php JRoute::_('index.php?option=com_contactenhanced'); ?>" method="post" name="adminForm" id="contact-form" class="form-validate">
	<div class="width-60 fltlft">
	<?php echo  JHtml::_('sliders.start', 'contact-slider2'); ?>
			<?php echo JHtml::_('sliders.panel',JText::_('COM_CONTACTENHANCED_CONTACT_PUBLISHING_INFO'), 'publishing-info'); ?>
		
		<fieldset class="adminform">
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('name'); ?>
			<?php echo $this->form->getInput('name'); ?></li>

			<li><?php echo $this->form->getLabel('alias'); ?>
			<?php echo $this->form->getInput('alias'); ?></li>

			<li><?php echo $this->form->getLabel('user_id'); ?>
			<?php echo $this->form->getInput('user_id'); ?></li>
			
			<li><?php echo $this->form->getLabel('access'); ?>
			<?php echo $this->form->getInput('access'); ?></li>

			<li><?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?></li>

			<li><?php echo $this->form->getLabel('catid'); ?>
			<?php echo $this->form->getInput('catid'); ?></li>

			<li><?php echo $this->form->getLabel('ordering'); ?>
			<?php echo $this->form->getInput('ordering'); ?></li>

			<li><?php echo $this->form->getLabel('language'); ?>
			<?php echo $this->form->getInput('language'); ?></li>

			<li><?php echo $this->form->getLabel('featured'); ?>
			<?php echo $this->form->getInput('featured'); ?></li>

			<li><?php echo $this->form->getLabel('id'); ?>
			<?php echo $this->form->getInput('id'); ?></li>
			</ul>
		<?php echo JHtml::_('sliders.panel',JText::_('COM_CONTACTENHANCED_CONTACT_MISC_INFO'), 'misc-info'); ?>
			<?php echo $this->form->getLabel('misc'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('misc'); ?>
		<?php echo JHtml::_('sliders.panel',JText::_('COM_CONTACTENHANCED_CONTACT_SIDEBAR'), 'sidebar'); ?>
			<?php echo JText::_('COM_CONTACTENHANCED_FIELD_INFORMATION_SIDEBAR_DESC'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('sidebar'); ?>
			
			<?php echo $this->loadTemplate('extrafields'); ?>
		</fieldset>
			
		<?php echo JHtml::_('sliders.end'); ?>
	</div>

	<div class="width-40 fltrt">
		<?php echo  JHtml::_('sliders.start', 'contact-slider'); ?>
			<?php echo JHtml::_('sliders.panel',JText::_('COM_CONTACTENHANCED_CONTACT_DETAILS'), 'basic-options'); ?>
			<fieldset class="panelform">
				<p><?php echo empty($this->item->id) ? JText::_('COM_CONTACTENHANCED_DETAILS') : JText::sprintf('COM_CONTACTENHANCED_EDIT_DETAILS', $this->item->id); ?></p>

				<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('image'); ?>
				<?php echo $this->form->getInput('image'); ?></li>

				<li><?php echo $this->form->getLabel('con_position'); ?>
				<?php echo $this->form->getInput('con_position'); ?></li>

				<li><?php echo $this->form->getLabel('email_to'); ?>
				<?php echo $this->form->getInput('email_to'); ?></li>

				<li><?php echo $this->form->getLabel('address'); ?>
				<?php echo $this->form->getInput('address'); ?></li>

				<li><?php echo $this->form->getLabel('suburb'); ?>
				<?php echo $this->form->getInput('suburb'); ?></li>

				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>

				<li><?php echo $this->form->getLabel('postcode'); ?>
				<?php echo $this->form->getInput('postcode'); ?></li>

				<li><?php echo $this->form->getLabel('country'); ?>
				<?php echo $this->form->getInput('country'); ?></li>

				<li><?php echo $this->form->getLabel('telephone'); ?>
				<?php echo $this->form->getInput('telephone'); ?></li>

				<li><?php echo $this->form->getLabel('mobile'); ?>
				<?php echo $this->form->getInput('mobile'); ?></li>

				<li><?php echo $this->form->getLabel('fax'); ?>
				<?php echo $this->form->getInput('fax'); ?></li>
				
				<li><?php echo $this->form->getLabel('skype'); ?>
				<?php echo $this->form->getInput('skype'); ?></li>
				
				<li><?php echo $this->form->getLabel('twitter'); ?>
				<?php echo $this->form->getInput('twitter'); ?></li>

				<li><?php echo $this->form->getLabel('facebook'); ?>
				<?php echo $this->form->getInput('facebook'); ?></li>
				
				<li><?php echo $this->form->getLabel('linkedin'); ?>
				<?php echo $this->form->getInput('linkedin'); ?></li>

				<li><?php echo $this->form->getLabel('webpage'); ?>
				<?php echo $this->form->getInput('webpage'); ?></li>

				<li><?php echo $this->form->getLabel('sortname1'); ?>
				<?php echo $this->form->getInput('sortname1'); ?></li>

				<li><?php echo $this->form->getLabel('sortname2'); ?>
				<?php echo $this->form->getInput('sortname2'); ?></li>

				<li><?php echo $this->form->getLabel('sortname3'); ?>
				<?php echo $this->form->getInput('sortname3'); ?></li>
				</ul>
			</fieldset>
			<?php echo $this->loadTemplate('map'); ?>
			<?php echo $this->loadTemplate('params'); ?>

			<?php echo $this->loadTemplate('metadata'); ?>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>