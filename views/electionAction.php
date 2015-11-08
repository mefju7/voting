<?php
 log2web(__FILE__);
if(!isset($noActionDiv)) echo '<div id="action">';
?>
<fieldset>
<legend>Vote in an election</legend>
<div class="tinyDate">
<?php date_default_timezone_set('UTC'); echo "vote retrieved at utc=".date("H:i:s"); ?>
</div>
<form name="voteForm">
<input type="hidden" name="req" value="<?php echo "p=$poll&v=$voter&m=$motion";?>" />
<table id="motion">
<tbody>
<tr><th>Candidate</th></tr>
<?php showVotes() ;?>
</tbody>
</table>
</form>
<div class="instruction">
Select the candidates of your choice. If you reach the number of allowed candidates, the remaining candidates get crossed out.
</div>
<div class="right">
<form method="get">
<input type="hidden" name="p" value="<?php echo $poll;?>" />
<input type="hidden" name="v" value="<?php echo $voter;?>" />
<button type="submit" name="m" value="<?php echo $motion+1;?>">Goto next motion/election</button></form></div>
</fieldset>
<?php 
if(!isset($noActionDiv)) echo '</div >';
