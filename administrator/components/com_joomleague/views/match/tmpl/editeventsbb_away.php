<fieldset class="adminform">
			<legend>
				<?php
				echo $this->teams->team2; 
				?>
			</legend>
	<table class="adminlist">
		<thead>
			<tr>
				<td colspan="2">
					<span class="red">
					<?php
						if($this->preFillSuccess) {
							echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_PREFILL_DONE') . '<br /><br />';
						}
					?>
					</span>
				</td>
			</tr>
			<tr>
				<th style="text-align: left; width: 10px;"></th>
				<th style="text-align: left; "><?php echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_EEBB_PERSON' ); ?></th>
				<?php
				foreach ( $this->events as $ev)
				{
					?>
					<th style="text-align: center;">
					<?php
					if ( JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.$ev->icon ) )
					{
						$imageTitle = JText::sprintf( '%1$s', JText::_( $ev->text ) );
						$iconFileName = $ev->icon;
						echo JHtml::_( 'image', $iconFileName, $imageTitle, 'title= "' . $imageTitle . '"' );
					} else {
						echo JText::_( $ev->text ) ;
					}
					?>
					</th>
					<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			$k = 0;
			$teap = 0;
			$model = $this->getModel();
			for( $i=0 , $n = count( $this->awayRoster ); $i < $n; $i++ )
			{
					$row =& $this->awayRoster[$i];
					if($row->value == 0) continue;
					?>
					<tr class="row<?php echo $k;?>">
						<td class="left">
						<input type="hidden" name="player_id_a_<?php echo $i;?>" value="<?php echo $row->value;?>" />
						<input type="hidden" name="team_id_a_<?php echo $i;?>" value="<?php echo $row->projectteam_id;?>" />
						<input type="checkbox" id="cb_a<?php echo $i;?>" name="cid_a<?php echo $i;?>" value="cb_a" onclick="isChecked(this.checked);" />
						</td>
						<td class="left">
						<?php 
						if($row->jerseynumber>0) {
							echo ' ('.$row->jerseynumber.')';
						}
						switch ($this->default_name_dropdown_list_order)
						{
		                	case 'lastname':
		                    case 'firstname':
								echo  JoomleagueHelper::formatName(null, $row->firstname, $row->nickname, $row->lastname, $this->default_name_format);
		                        break;
		               
							case 'position':
		                    	echo '('.JText::_($row->positionname).') - '.JoomleagueHelper::formatName(null, $row->firstname, $row->nickname, $row->lastname, $this->default_name_format);
								break;
		                  }
						?>
						</td>
						<?php
						//total events away player
						$teap = 0;
						foreach ( $this->events as $ev)
						{
							$teap++;	
							$this->assignRef( 'evbb', $model->getPlayerEventsbb( $row->value, $ev->value ) );
							?>
							<td class="leftdashed">
							<input type="hidden" name="event_type_id_a_<?php echo $i.'_'.$teap;?>" value="<?php echo $ev->value;?>" />
							<input type="hidden" name="event_id_a_<?php echo $i.'_'.$teap;?>" value="<?php echo $this->evbb[0]->id;?>" />
                            <input type="text" size="1" class="inputbox" name="event_sum_a_<?php echo $i.'_'.$teap; ?>" value="<?php echo (($this->evbb[0]->event_sum > 0) ? $this->evbb[0]->event_sum : '' ); ?>" title="<?php echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_EE_VALUE_SUM' )?>" onchange="document.getElementById('cb_a<?php echo $i;?>').checked=true" />
                            <input type="text" size="2" class="inputbox" name="event_time_a_<?php echo $i.'_'.$teap; ?>" value="<?php echo (($this->evbb[0]->event_time > 0) ? $this->evbb[0]->event_time : '' ); ?>" title="<?php echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_EE_TIME' )?>" onchange="document.getElementById('cb_a<?php echo $i;?>').checked=true" />
                            <input type="text" size="3" class="inputbox" name="notice_a_<?php echo $i.'_'.$teap; ?>" value="<?php echo ((strlen($this->evbb[0]->notice) > 0) ? $this->evbb[0]->notice : '' ); ?>" title="<?php echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_EE_MATCH_NOTICE' )?>" onchange="document.getElementById('cb_a<?php echo $i;?>').checked=true" />
                            &nbsp;&nbsp;
                            </td>

						<?php 
						}
						?>
					</tr>
					<?php
					$k=1 - $k;
			}
			?>
		</tbody>
	</table>		
	<input type="hidden" name="total_a_players" value="<?php echo $i;?>" />
	<input type="hidden" name="teap" value="<?php echo $teap;?>" />
</fieldset>
