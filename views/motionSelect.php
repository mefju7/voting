<form method="get">
<?php printHidden($selArray); ?>
Goto motion/election: <select name="m" onchange="submit();">
<?php 
printOptions($motionTitles,$motion);
?>
</select>
</form>
