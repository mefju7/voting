<script type="text/javascript">
tinymce.init({
    selector: "#motionDesc",
    plugins: [
        "advlist lists link charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<fieldset>
<legend>Editing motion/election <?php echo $motion;?></legend>
<form method="post">
<?php printHidden($motionHiddenFields); ?>
<label for="motionTitle">Title</label>
<input class="fullwidth" id="motionTitle" type="text" name="mt" placeholder="enter title here" 
	value="<?php e($motionTitle); ?>"></input>
<label for="motionDesc">Description</label>
<textarea class="fullwidth" id="motionDesc" name="md" rows="20">
<?php e($motionDesc); ?>
</textarea>
<label for="proposals">Proposals/Candidates, one at a line</label>
<textarea class="fullwidth" id="proposals" name="mp" rows="10">
<?php e($motionProposals); ?>
</textarea>
<input type="checkbox" name="mr">Shuffle proposals/candidates?</input><br/>
<label for="motionOrElection">Motion or Election:</label>
<select id="motionOrElection" name="moe">
 <?php printOptions($motionSelectOptions,$moe); ?>
</select><br>
<div class="right">
<input type="submit" value="Save"></input>
</div>
</form>
</fieldset>
