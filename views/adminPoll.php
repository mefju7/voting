<div><fieldset>
<legend>Editing poll </legend>
<form method="post">
<label for="pt">Poll title:</label>
<input class="fullwidth" id="pt" type="text" name="pt" 
value="<?php e($pollTitle); ?>"></input>
</form>
</fieldset>
<fieldset>
<legend>Links</legend>
<ul>
<li><a href="<?php e($editMotionLink); ?>">edit motions</a></li>
<li><a href="<?php e($showResultsLink); ?>">show results</a></li>
</ul>
</fieldset>
<fieldset>
<legend>Add voters</legend>
<form method="post">
<label for="av">Add voter's email, one at a line - invitations will be send immediately</label>
<textarea id="av" name="av" rows="60" class="fullwidth">
</textarea>
<div class="right">
<input  type="submit" value="Add & Send"></input>
</div>
</form>
</fieldset>
</div>
