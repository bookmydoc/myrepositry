<?php
/**
 * @copyright	Copyright (C) 2006 - 2010 Ideal Custom Software Development
 * @author     Douglas Machado {@link http://ideal.fok.com.br}
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Contacts component
 *
 * @package		com_contactenhanced
* @since		1.5
 */
class ContactenhancedViewMessages extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		//require_once JPATH_COMPONENT.'/helpers/contact.php';
		$this->state		= $this->get('state');
		$this->items		= $this->get('items');
		$this->pagination	= $this->get('pagination');
		

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Preprocess the list of items to find ordering divisions.
		// TODO: Complete the ordering stuff with nested sets
		foreach ($this->items as &$item) {
			$item->order_up = true;
			$item->order_dn = true;
		}
		
		$canDo	= CEHelper::getActions($this->state->get('filter.category_id'));
		$this->assignRef('canDo',	$canDo);
		
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{

		JToolBarHelper::title(JText::_('CE_MSG_MANAGER'), 'message.png');

		if ($this->canDo->get('core.create')) {
			JToolBarHelper::addNew('message.add','JTOOLBAR_NEW');
		}
		if ($this->canDo->get('core.edit')) {
			JToolBarHelper::editList('message.edit','JTOOLBAR_EDIT');
		}
		if ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('messages.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('messages.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('messages.archive','JTOOLBAR_ARCHIVE');
		}
		/*if(JFactory::getUser()->authorise('core.manage','com_checkin')) {
			JToolBarHelper::custom('messages.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}*/
		if ($this->state->get('filter.published') == -2 && $this->canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'messages.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($this->canDo->get('core.edit.state')) {
			JToolBarHelper::trash('messages.trash','JTOOLBAR_TRASH');
		}
		if ($this->canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_contactenhanced');
      }
	/*	JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_CONTACTS_CONTACTS');*/
	}
}
