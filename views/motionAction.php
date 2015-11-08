<?php 
log2web(__FILE__);
if(!isset($noActionDiv)) echo '<div id="action">';
?>
<fieldset>
<legend>Vote in motion</legend>
<div class="tinyDate">
<?php date_default_timezone_set('UTC'); echo "vote retrieved at utc=".date("H:i:s"); ?>
</div>
<form name="voteForm">
<input type="hidden" name="req" value="<?php echo "p=$poll&v=$voter&m=$motion";?>" />
<table id="motion">
<tbody>
<tr><th>Rank</th><th>Proposal</th></tr>
<?php printVote() ;?>
</tbody>
</table>
<div class="instruction">
Click on the proposal to change its rank to 
<select name="changeRank2">
<?php printOptions($opsTable,$nextOps); ?>
</select>.
The rank will increase with each click, but you might adjust the value before clicking on a proposal.
Starting with 0 and clicking on the proposals in your preferred order will arrange them accordingly.
Rank 0 denotes your preferred proposal.
</div> </form>
<div class="right">
<form method="get">
<input type="hidden" name="p" value="<?php echo $poll;?>" />
<input type="hidden" name="v" value="<?php echo $voter;?>" />
<button type="submit" name="m" value="<?php echo $motion+1;?>">Goto next motion/election</button></form></div>
</fieldset>
<?php 
if(!isset($noActionDiv)) echo '</div >';

