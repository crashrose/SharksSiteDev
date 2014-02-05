<?php defined('_JEXEC') or die('Restricted access');

// Show team-players as defined
if (!empty($this->rows))
{
	$k=0;
	$position='';
	$totalEvents=array();

	// Layout of the columns in the table
	//  1. Position number  (optional : $this->config['show_player_numbers'])
	//  2. Player picture   (optional : $this->config['show_player_icon'])
	//  3. Country flag     (optional : $this->config['show_country_flag'])
	//  4. Player name
	//  5. Injured/suspended/away icons
	//  6. Birthday         (optional : $this->config['show_birthday'])
	//  7. Games played     (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_games_played'])
	//  8. Starting line-up (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	//  9. In               (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	// 10. Out              (optional : $this->overallconfig['use_jl_substitution'] && $this->config['show_substitution_stats'])
	// 10. Event type       (optional : $this->config['show_events_stats'] && count($this->playereventstats) > 0,
	//                       multiple columns possible (depends on the number of event types for the position))
	// 11. Stats type       (optional : $this->config['show_stats'] && isset($this->stats[$row->position_id]),
	//                       multiple columns possible (depends on the number of stats types for the position))

	$positionHeaderSpan = 0;
	$totalcolspan = 0;
	if ($this->config['show_player_numbers'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	if ($this->config['show_player_icon'] || $this->config['show_staff_icon'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	if ($this->config['show_country_flag'] || $this->config['show_country_flag_staff'])
	{
		$positionHeaderSpan++;
		$totalcolspan++;
	}
	// Player name and injured/suspended/away columns are always there
	$positionHeaderSpan += 2;
	$totalcolspan       += 2;
	if ($this->config['show_birthday'] || $this->config['show_birthday_staff'])
	{
		$totalcolspan++;
	}
	if ($this->overallconfig['use_jl_substitution'])
	{
		if ($this->config['show_games_played'])
		{
			$totalcolspan++;
		}
		if ($this->config['show_substitution_stats'])
		{
			$totalcolspan += 3;
		}
	}
	?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align: center;">
	<?php
	foreach ($this->rows as $position_id => $players)
	{
		// position header
		$row=current($players);
		$position=$row->position;
		$k=0;
		?>
	<thead>
	<tr class="sectiontableheader rosterheader">
		<th width="60%" colspan="<?php echo $positionHeaderSpan; ?>">
			<?php echo '&nbsp;'.JText::_($row->position); ?>
		</th>
		<?php
		if ($this->config['show_birthday'] > 0)
		{ ?>
		<th class="td_c">
		  <?php
				switch ( $this->config['show_birthday'] )
				{
					case 	1:			// show Birthday and Age
						$outputStr = 'COM_JOOMLEAGUE_PERSON_BIRTHDAY_AGE';
						break;

					case 	2:			// show Only Birthday
						$outputStr = 'COM_JOOMLEAGUE_PERSON_BIRTHDAY';
						break;

					case 	3:			// show Only Age
						$outputStr = 'COM_JOOMLEAGUE_PERSON_AGE';
						break;

					case 	4:			// show Only Year of birth
						$outputStr = 'COM_JOOMLEAGUE_PERSON_YEAR_OF_BIRTH';
						break;
				}
				echo JText::_( $outputStr );
				?>
		</th>
		<?php
		}
		elseif ($this->config['show_birthday_staff'] > 0)
		{
			// Put empty column to keep vertical alignment with the staff table
			?>
		<th class="td_c">&nbsp;</th><?php
		}
		if ($this->overallconfig['use_jl_substitution']==1)
		{
			if ($this->config['show_games_played'])
			{ ?>
		<th class="td_c"><?php
				$imageTitle=JText::_('COM_JOOMLEAGUE_ROSTER_PLAYED');
				echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/played.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
			<?php
			}
			if ($this->config['show_substitution_stats'])
			{ ?>
		<th class="td_c"><?php
				$imageTitle=JText::_('COM_JOOMLEAGUE_ROSTER_STARTING_LINEUP');
				echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/startroster.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
		<th class="td_c"><?php
				$imageTitle=JText::_('COM_JOOMLEAGUE_ROSTER_IN');
				echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/in.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
		<th class="td_c"><?php
				$imageTitle=JText::_('COM_JOOMLEAGUE_ROSTER_OUT');
				echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/out.png',
				$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		?></th>
			<?php
			}
		}
		if ($this->config['show_events_stats'])
		{
			if ($this->positioneventtypes)
			{
				if (isset($this->positioneventtypes[$row->position_id]) &&
					count($this->positioneventtypes[$row->position_id]))
				{
					foreach ($this->positioneventtypes[$row->position_id] AS $eventtype)
					{
						if (empty($eventtype->icon))
						{
							$eventtype_header = JText::_($eventtype->name);
						}
						else
						{
							$iconPath=$eventtype->icon;
							if (!strpos(' '.$iconPath,'/'))
							{
								$iconPath='images/com_joomleague/database/events/'.$iconPath;
							}
							$eventtype_header = JHtml::image($iconPath, JText::_($eventtype->name),
																array(	'title'=> JText::_($eventtype->name),
																		'align'=> 'top',
																		'hspace'=> '2'));
						}
						?>
		<th class="td_c">
			<?php echo $eventtype_header;?>
		</th>
						<?php
					}
				}
			}
		}
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
				if ($stat->showInRoster())
				{
				    if ($stat->position_id==$row->position_id)
				    {
					?>
		<th class="td_c"><?php echo $stat->getImage(); ?></th>
					<?php
				    }
				}
			}
		}
		?>
	</tr>
	</thead>
	<!-- end position header -->
	<!-- Players row-->
	<?php
	foreach ($players as $row)
	{
		?>
	<tr class="<?php echo ($k==0)? $this->config['style_class1'] : $this->config['style_class2']; ?>">
		<?php
		$pnr = ($row->position_number !='') ? $row->position_number : '&nbsp;';
		if ($this->config['show_player_numbers'])
		{
			if ($this->config['player_numbers_pictures'])
			{
				$value = JHtml::image(JURI::root().'components/com_joomleague/helpers/shirt.php?text='.$pnr.'&picpath='.urlencode($this->config['player_numbers_picture']), $pnr, array('title'=>$pnr));
			}
			else
			{
				$value = $pnr;
			}
			?>
		<td width="30" class="td_c"><?php echo $value;?></td><?php
		}
		$playerName = JoomleagueHelper::formatName(null, $row->firstname,
													$row->nickname,
													$row->lastname,
													$this->config["name_format"]);
		if ($this->config['show_player_icon'])
		{
			$picture = $row->picture;
			if ((empty($picture)) || ($picture == JoomleagueHelper::getDefaultPlaceholder("player") ))
			{
				$picture = $row->ppic;
			}
		?>
		<td width="40" class="td_c" nowrap="nowrap"><?php
			echo JoomleagueHelper::getPictureThumb($picture, $playerName,
													$this->config['player_picture_width'],
													$this->config['player_picture_height'],0);
			?>
		</td><?php
		}
		elseif ($this->config['show_staff_icon'])
		{
			// Put empty column to keep vertical alignment with the staff table
			?>
		<td width="40" class="td_c" nowrap="nowrap">&nbsp;</td><?php
		}
		if ($this->config['show_country_flag'])
		{ ?>
		<td width="16" nowrap="nowrap" style="text-align:center; ">
			<?php echo Countries::getCountryFlag($row->country);?>
		</td><?php
		}
		elseif ($this->config['show_country_flag_staff'])
		{
			// Put empty column to keep vertical alignment with the staff table
			?>
		<td width="16" nowrap="nowrap" style="text-align:center; ">&nbsp;</td><?php
		}
		?>
		<td class="td_l"><?php
		if ($this->config['link_player']==1)
		{
			$link=JoomleagueHelperRoute::getPlayerRoute($this->project->slug,$this->team->slug,$row->slug);
			echo JHtml::link($link,'<span class="playername">'.$playerName.'</span>');
		}
		else
		{
			echo '<span class="playername">'.$playerName.'</span>';
		}
		?></td>
		<td width="5%" style="text-align: left;" class="nowrap">&nbsp; <?php
		$model = $this->getModel();
		$this->assignRef('playertool',$model->getTeamPlayer($this->project->current_round,$row->playerid));
		if (!empty($this->playertool[0]->injury))
		{
			$imageTitle=JText::_('COM_JOOMLEAGUE_PERSON_INJURED');
			echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/injured.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		if (!empty($this->playertool[0]->suspension))
		{
			$imageTitle=JText::_('COM_JOOMLEAGUE_PERSON_SUSPENDED');
			echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/suspension.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		if (!empty($this->playertool[0]->away))
		{
			$imageTitle=JText::_('COM_JOOMLEAGUE_PERSON_AWAY');
			echo JHtml::image('images/com_joomleague/database/events/'.$this->project->fs_sport_type_name.'/away.gif',
								$imageTitle,array('title'=> $imageTitle,'height'=> 20));
		}
		?></td>
		<?php
		if ($this->config['show_birthday'] > 0)
		{
			?>
		<td width="10%" nowrap="nowrap" style="text-align: center;"><?php
			if ($row->birthday !="0000-00-00")
			{
				switch ($this->config['show_birthday'])
				{
					case 1:	 // show Birthday and Age
						$birthdateStr = JHtml::date($row->birthday, JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE'), $this->overallconfig['time_zone']);
						$birthdateStr.="&nbsp;(".JoomleagueHelper::getAge($row->birthday,$row->deathday).")";
						break;
					case 2:	 // show Only Birthday
						$birthdateStr = JHtml::date($row->birthday, JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE'), $this->overallconfig['time_zone']);
						break;
					case 3:	 // show Only Age
						$birthdateStr = "(".JoomleagueHelper::getAge($row->birthday,$row->deathday).")";
						break;
					case 4:	 // show Only Year of birth
						$birthdateStr = JHtml::date($row->birthday, 'Y', $this->overallconfig['time_zone']);
						break;
					default:
						$birthdateStr = "";
						break;
				}
			}
			else
			{
				$birthdateStr="-";
			}
			// deathday
			if ( $row->deathday !="0000-00-00" )
			{
				$birthdateStr .= ' [&dagger; '.JHtml::date($row->deathday, JText::_('COM_JOOMLEAGUE_GLOBAL_DAYDATE'), $this->overallconfig['time_zone']).']';
			}

			echo $birthdateStr;
		?>
		</td><?php
		}
		elseif ($this->config['show_birthday_staff'] > 0)
		{
			?>
		<td width="10%" nowrap="nowrap" style="text-align: left;">&nbsp;</td><?php
		}
		if ($this->overallconfig['use_jl_substitution'])
		{
			// Events of COM_JOOMLEAGUE_substitutions are shown
			$model = $this->getModel();
			$this->assignRef('InOutStat',$model->getInOutStats($row->pid));
			if (isset($this->InOutStat) && ($this->InOutStat->played > 0))
			{
				$played  = $this->InOutStat->played;
				$started = ($this->InOutStat->started > 0 ? $this->InOutStat->started : $this->overallconfig['zero_events_value']);
				$subIn   = ($this->InOutStat->sub_in > 0 ? $this->InOutStat->sub_in : $this->overallconfig['zero_events_value']);
				$subOut  = ($this->InOutStat->sub_out > 0 ? $this->InOutStat->sub_out : $this->overallconfig['zero_events_value']);
			}
			else
			{
				$played  = $this->overallconfig['zero_events_value'];
				$started = $this->overallconfig['zero_events_value'];
				$subIn   = $this->overallconfig['zero_events_value'];
				$subOut  = $this->overallconfig['zero_events_value'];
			}
			if ($this->config['show_games_played'])
			{
				?>
		<td class="td_c" nowrap="nowrap"><?php echo $played;?></td>
				<?php
			}
			if ($this->config['show_substitution_stats'])
			{
				?>
		<td class="td_c"><?php echo $started;?></td>
		<td class="td_c"><?php echo $subIn;?></td>
		<td class="td_c"><?php echo $subOut;?></td>
				<?php
			}
		}
		if ($this->config['show_events_stats'])
		{
			if ($this->positioneventtypes)
			{
				if (isset($this->positioneventtypes[$row->position_id]) &&
						count($this->positioneventtypes[$row->position_id]))
				{
					// Use same order of events as done for creation of the table header row!!!
					foreach ($this->positioneventtypes[$row->position_id] AS $eventtype)
					{
				$stat = $this->playereventstats[$row->pposid][$eventtype->eventtype_id][$row->pid]->value;
				?>
		<td class="td_c"><?php
				echo ($stat > 0) ? number_format($stat, 0, '', '.') : $this->overallconfig['zero_events_value'];
				?>
		</td>
				<?php
					}
				}
			}
		}
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
			    if ($stat->showInRoster() && ($stat->position_id==$row->position_id))
				{
					if (isset($this->playerstats[$row->position_id][$stat->id][$row->pid]) &&
						isset($this->playerstats[$row->position_id][$stat->id][$row->pid]->value))
					{
						$value = $this->playerstats[$row->position_id][$stat->id][$row->pid]->value;
					}
					else
					{
						if ($stat->_name == 'percentage')
						{
							// Check if one of the denominator statistics is greater than 0.
							// If so, show percentage, otherwise show "-"
							$nonZeroDen = false;
							$dens = $stat->getSids();
							if (isset($dens['den']) && count($dens['den']) > 0)
							{
								foreach($dens['den'] as $den)
								{
									if (isset($this->playerstats[$row->position_id][$den][$row->pid]) &&
										isset($this->playerstats[$row->position_id][$den][$row->pid]->value) &&
										$this->playerstats[$row->position_id][$den][$row->pid]->value)
									{
										$nonZeroDen = true;
										break;
									}
								}
								$value = $nonZeroDen ? 0 : "-";
							}
						}
						else
						{
							$value = $this->overallconfig['zero_events_value'];
						}
					}
					if (is_numeric($value))
					{
						$precision = $stat->getPrecision();
						$value = number_format($value, $precision, ',', '.');
						if ($stat->_name == 'percentage')
						{
							$value .= "%";
						}
					}
					?>
		<td class="td_c" class="hasTip" title="<?php echo JText::_($stat->name); ?>">
			<?php echo $value; ?>
		</td>
					<?php
			    }
			}
		}
		?>
	</tr>
	<?php
	$k=(1-$k);
	}
	?>
	<!-- end players rows -->
	<!-- position totals -->
	<?php
	if ($this->config['show_totals'] && ($this->config['show_stats'] || $this->config['show_events_stats']))
	{
		?>
	<tr class="<?php echo ($k==0)? $this->config['style_class1'] : $this->config['style_class2']; ?> totals">
		<td class="td_r" colspan="<?php echo $totalcolspan; ?>"><b><?php echo JText::_('COM_JOOMLEAGUE_ROSTER_TOTAL'); ?></b></td>
		<?php
		if ($this->config['show_events_stats'])
		{
			if (isset($this->positioneventtypes[$row->position_id]))
			{
				foreach ($this->positioneventtypes[$row->position_id] AS $eventtype)
				{
					$stat = $this->playereventstats[$row->pposid][$eventtype->eventtype_id]["totals"]->value;
					?>
		<td class="td_c"><?php echo ($stat > 0 ? number_format($stat, 0, '', '.') : $this->overallconfig['zero_events_value']); ?></td>
					<?php
				}
			}
		}
		if ($this->config['show_stats'] && isset($this->stats[$row->position_id]))
		{
			foreach ($this->stats[$row->position_id] as $stat)
			{
			    if ($stat->showInRoster() && $stat->position_id==$row->position_id)
				{
					$value = $this->playerstats[$row->position_id][$stat->id]['totals']->value;
					if (is_numeric($value))
					{
						$precision = $stat->getPrecision();
						$value = number_format($value, $precision, ',', '.');
						if ($stat->_name == 'percentage')
						{
							$value .= "%";
						}
					}
					?>
		<td class="td_c"><?php echo ($value > 0 ? $value : $this->overallconfig['zero_events_value']); ?></td>
					<?php
				}
			}
		}
		?>
	</tr>
	<?php
	}
	?>
	<!-- total end -->
	<?php
	$k=(1-$k);
	}
	?>
</table>
	<?php
}
?>
