<div id="adminpanel">
	<?php echo validation_errors(); ?>
	<h1>Group-admin</h1>

	<h2>Add new group</h2>
	<?php echo form_open('admin/addGroup');?>
		<label for="groupname">Group name</label>
		<input type="text" name="groupname">
		<label for="imgname">Image name</label>
		<input type="text" name="imgname">
		<label for="label">Label</label>
		<select name="label">
			<option value="">- -</option>
			<?php foreach($labels as $label): ?>
		    <option value="<?php echo $label['idLabel']; ?>"><?php echo $label['Labelname']; ?></option>
		    <?php endforeach; ?>
		</select>
		<label for="debutdate" value="12-20-2012">Debut date</label>
		<input type="date" name="debutdate"><br>
		<div class="radiobuttons">
			<input type="radio" name="active" value="1" checked>Active
			<input type="radio" name="active" value="0">Inactive
		</div><br>
		<label for="fanclub">Fanclub</label>
		<input type="text" name="fanclub" value="Unknown">
		<label for="color">Color</label>
		<input type="text" name="color" value="Unknown">

		<input type="submit" value="Add">
	</form>

	<table>
		<tr>
			<th>Groupname</th>
			<th>Imagename</th> 
			<th>Debut</th>
			<th>Active</th>
			<th>Fanclub</th>
			<th>Color</th>
			<th>Labelname</th>
		</tr>
		<?php foreach($groups as $group): ?>
		<tr>
			<td><?php echo $group['Groupname']; ?></td>
			<td><?php echo $group['Imgname']; ?></td>
			<td><?php echo $group['Debut']; ?></td>
			<td><?php echo $group['Active']; ?></td>
			<td><?php echo $group['Fanclub']; ?></td>
			<td><?php echo $group['Color']; ?></td>
			<td><?php echo $group['Labelname']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<!--
	<pre>
		<?php print_r($groups); ?>
		<?php print_r($labels); ?>
	</pre>
	-->
</div>