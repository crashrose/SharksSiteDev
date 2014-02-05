<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<table class="contentpaneopen">
	<tr>
		<td class="contentheading"><?php
		$pageTitle = 'COM_JOOMLEAGUE_MATCHREPORT_TITLE';
		if ( isset( $this->round->name ) )
		{
			echo '&nbsp;' . JText::sprintf(	$pageTitle,
			$this->round->name,
			JoomleagueHelper::getMatchDate($this->match, JText::_( 'COM_JOOMLEAGUE_MATCHREPORT_GAMES_DATE' )),
			JoomleagueHelperHtml::showMatchTime($this->match, $this->config, $this->overallconfig, $this->project) );
		}
		else
		{
			echo '&nbsp;' . JText::sprintf( $pageTitle, '', '', '' );
		}
		?></td>
	</tr>
</table>
