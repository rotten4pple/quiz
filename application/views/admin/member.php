<div id="adminpanel">
	<?php echo validation_errors(); ?>
	<h1>Member-admin</h1>

	<h2>Add new member</h2>
	<?php echo form_open('admin/addMember');?>
		<label for="membername">Stagename</label>
		<input type="text" name="membername">
		<label for="imgname">Imagename</label>
		<input type="text" name="imgname">
		<label for="birthname">Surname</label>
		<input type="text" name="surname">
		<label for="birthname">Firstname</label>
		<input type="text" name="birthname">
		<label for="birthdate">Birthdate</label>
		<input type="date" name="birthdate"><br>
		<div class="radiobuttons">
			<input type="radio" name="gender" value="Male" checked>Male
			<input type="radio" name="gender" value="Female">Female
		</div><br>
		<label for="height">Height</label>
		<input type="text" name="height">
		<label for="weight">Weight</label>
		<input type="text" name="weight">

		<label for="bloodtype">Bloodtype</label>
		<select name="bloodtype">
			<option value="">- -</option>
			<?php foreach($bloodtypes as $bloodtype): ?>
		    <option value="<?php echo $bloodtype['idBloodtype']; ?>"><?php echo $bloodtype['Bloodtypename']; ?></option>
		    <?php endforeach; ?>
		</select>

		<label for="nationality">Nationality</label>
		<select name="nationality">
			<option value="">- -</option>
			<?php foreach($nationalitys as $nationality): ?>
		    <option value="<?php echo $nationality['idNationality']; ?>"><?php echo $nationality['Nationalityname']; ?></option>
		    <?php endforeach; ?>
		</select>

		<div class="radiobuttons">
			<input type="radio" name="active" value="1" checked>Active
			<input type="radio" name="active" value="0">Inactive
		</div><br>

		<label for="group">Group</label>
		<select name="group">
			<option value="">- -</option>
			<?php foreach($groups as $group): ?>
		    <option value="<?php echo $group['idGroup']; ?>"><?php echo $group['Groupname']; ?></option>
		    <?php endforeach; ?>
		</select>

		<input type="submit" value="Add">
	</form>

	<table>
		<tr>
			<th>Stagename</th>
			<th>Surname</th>
			<th>Firstname</th>
			<th>Group</th> 
			<th>Birthdate</th>
			<th>Gender</th>
			<th>Height</th>
			<th>Weight</th>
			<th>Bloodtype</th>
			<th>Nationality</th>
		</tr>
		<?php foreach($members as $member): ?>
		<tr>
			<td><?php echo $member['Idolname']; ?></td>
			<td><?php echo $member['Surname']; ?></td>
			<td><?php echo $member['Birthname']; ?></td>
			<td><?php echo $member['Groupname']; ?></td>
			<td><?php echo $member['Birthdate']; ?></td>
			<td><?php echo $member['Gender']; ?></td>
			<?php if ($member['Height'] == 0): ?>
			<td><?php echo "Unkwown"; ?></td>
			<?php else : ?>
			<td><?php echo $member['Height']; ?></td>
			<?php endif; ?>
			<?php if ($member['Weight'] == 0): ?>
			<td><?php echo "Unkwown"; ?></td>
			<?php else : ?>
			<td><?php echo $member['Weight']; ?></td>
			<?php endif; ?>
			<td><?php echo $member['Bloodtypename']; ?></td>
			<td><?php echo $member['Nationalityname']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<!--
	<pre>
		<?php print_r($members); ?>
	</pre>
	-->
</div>