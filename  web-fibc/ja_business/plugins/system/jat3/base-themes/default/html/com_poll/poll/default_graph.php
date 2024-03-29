<?php


defined('_JEXEC') or die('Restricted access');
?>

<dl class="poll clearfix">
	<div><dt><?php echo JText::_( 'Number of Voters' ); ?>:</dt></div>
	<div><dd><?php echo $this->votes[0]->voters; ?></dd><br /></div>
	<div><dt><?php echo JText::_( 'First Vote' ); ?>:</dt></div>
	<div><dd><?php echo $this->first_vote; ?></dd><br /></div>
	<div><dt><?php echo JText::_( 'Last Vote' ); ?>:</dt></div>
	<div><dd><?php echo $this->last_vote; ?></dd></div>
</dl>

<h3>
	<?php echo $this->escape($this->poll->title); ?>
</h3>

<table class="pollstableborder">
	<tr class="sectiontableheader">
		<th id="itema" class="td_1"><?php echo JText::_( 'Hits' ); ?></th>
		<th id="itemb" class="td_2"><?php echo JText::_( 'Percent' ); ?></th>
		<th id="itemc" class="td_3"><?php echo JText::_( 'Graph' ); ?></th>
	</tr>
	<?php for ( $row = 0; $row < count( $this->votes ); $row++ ) :
		$vote = $this->votes[$row];
	?>
	<tr>
		<td colspan="3" id="question<?php echo $row; ?>" class="question">
			<?php echo $vote->text; ?>
		</td>
	</tr>
	<tr class="sectiontableentry<?php echo $vote->odd; ?>">
		<td headers="itema question<?php echo $row; ?>" class="td_1">
			<?php echo $vote->hits; ?>
		</td>
		<td headers="itemb question<?php echo $row; ?>" class="td_2">
			<?php echo $vote->percent.'%' ?>
		</td>
		<td headers="itemc question<?php echo $row; ?>" class="td_3">
			<div class="<?php echo $vote->class; ?>" style="height:<?php echo $vote->barheight; ?>px;width:<?php echo $vote->percent; ?>% !important"></div>
		</td>
	</tr>
	<?php endfor; ?>
</table>
