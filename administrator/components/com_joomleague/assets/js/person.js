/**
 * @copyright Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license GNU/GPL, see LICENSE.php Joomla! is free software. This version may
 *          have been modified pursuant to the GNU General Public License, and
 *          as distributed it includes or is derivative of works licensed under
 *          the GNU General Public License or other free or open source software
 *          licenses. See COPYRIGHT.php for copyright notices and details.
 */

Joomla.submitbutton = function(pressbutton) {
	var res = true;
	var validator = document.formvalidator;
	var form = $('adminForm');

	if (pressbutton == 'person.cancel') {
		Joomla.submitform(pressbutton);
		return;
	}

	// do field validation
	if (validator.validate(form.lastname) === false) {
		alert(Joomla.JText._('COM_JOOMLEAGUE_ADMIN_PERSON_CSJS_NO_NAME'));
		res = false;
	}
	if (res) {
		Joomla.submitform(pressbutton);
	} else {
		return false;
	}
}

function projectSelected() {
	var adminForm = window.top.document.forms.adminForm; 
	adminForm.elements.project_id.value 	= $('prjid').getSelected().get('value');
	adminForm.elements.project_name.value 	= $('prjid').getSelected().get('text');
	adminForm.elements.team_id.value 		= $('xtid').getSelected().get('value');
	adminForm.elements.team_name.value 		= $('xtid').getSelected().get('text');
	adminForm.elements.assignperson.value 	= '1';
	window.parent.SqueezeBox.close();
}
