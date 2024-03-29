<?php defined( '_JEXEC' ) or die( 'Restricted access' );
$jinput = JFactory::getApplication() -> input;
if ($this->overallconfig['show_print_button'] == 1 &&
	$jinput -> get('print', 0, 'int') == 1) {
	$document = JFactory::getDocument();
	$content = "window.addEvent('domready', function(){ window.print(); });";
	$document->addScriptDeclaration($content);
}
$nbcols = 2;
if ( $this->overallconfig['show_project_picture'] ) {
	$nbcols++;
}
if ( $this->overallconfig['show_project_text'] ) {
	$nbcols++;
}
if ( $this->overallconfig['show_division_picture'] ) {
	$nbcols++;
}
if ( $this->overallconfig['show_division_text'] ) {
	$nbcols++;
}
if ( $this->overallconfig['show_project_heading'] == 1 && $this->project)
{
	if ($this->project && $this->project->project_type == 'DIVISIONS_LEAGUE') {
		$division_id = $jinput -> get('division',0,'int');;
		if(empty($this->division) && $division_id >0) {
			$model = JModelLegacy::getInstance('project', 'JoomLeagueModel');
			$division = $model->getDivision($division_id);
			$this->assignRef( 'division', $division );
		}
	}
	if($this->overallconfig['show_project_text'] ||
		$this->overallconfig['show_project_picture'] ||
		$this->overallconfig['show_division_picture'] ||
		($this->overallconfig['show_print_button'] == 1 && $jinput -> get('print', 0, 'int') != 1)
	) {
	?>
<div class="componentheading">
	<table class="contentpaneopen">
		<tbody>
			<?php
			if ( $this->overallconfig['show_project_country'] == 1 )
			{
				?>
			<tr class="contentheading">
				<td colspan="<?php echo $nbcols; ?>"><?php
				$country = $this->project->country;
				echo Countries::getCountryFlag($country) . ' ' . Countries::getCountryName($country);
				?>
				</td>
			</tr>
			<?php
			}
			?>
			<tr class="contentheading">
				<?php
				if ( $this->overallconfig['show_project_picture'] == 1 )
				{
					echo '<td>';
					echo JoomleagueHelper::getPictureThumb($this->project->picture,
															$this->project->name,
															$this->overallconfig['project_picture_width'],
															$this->overallconfig['project_picture_height'],
															2);
					echo '</td>';
				}
				if ( $this->overallconfig['show_project_text'] == 1 )
				{
					echo '<td>';
					echo $this->project->name;
					echo '</td>';
				}
				if (isset( $this->division))
				{
					if ( $this->overallconfig['show_division_picture'] == 1 )
					{
						echo '<td>';
						echo JoomleagueHelper::getPictureThumb($this->division->picture,
																$this->division->name,
																$this->overallconfig['division_picture_width'],
																$this->overallconfig['division_picture_height'],
																2);
						echo '</td>';
					}
					if ( $this->overallconfig['show_division_text'] == 1 )
					{
						echo '<td>';
						echo ' ' . $this->division->name;
						echo '</td>';
					}
				}
				if($this->overallconfig['show_print_button'] == 1) {
					if($jinput -> get('print', 0, 'int') != 1) {
						echo '<td>';
						$overallconfig = $this->overallconfig;
						echo '<td class="buttonheading">';
						echo JoomleagueHelper::printbutton(null, $overallconfig);
						echo '&nbsp;</td>';
					} else {

					}
				}
				echo '</td>';
				?>
			</tr>
		</tbody>
	</table>
</div>
<?php
	}
} else {
	if ($this->overallconfig['show_print_button'] == 1 && $jinput -> get('print', 0, 'int') != 1) {
	?>
<div class="componentheading">
	<table class="contentpaneopen">
		<tbody>
			<tr class="contentheading">
				<td class="buttonheading" align="right"><?php
				if($jinput -> get('print', 0, 'int') != 1) {
				  echo JoomleagueHelper::printbutton(null, $this->overallconfig);
				}
				?> &nbsp;</td>
			</tr>
		</tbody>
	</table>
</div>
<?php
	}
}
?>
<br />
