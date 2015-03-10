<div id="adminpanel">
	<?php echo validation_errors(); ?>
	<h1>Quiz-admin</h1>

	<h2>Add new quiz</h2>
	
	<label for="quizname">Quiz name</label>
	<input type="text" name="quizname" id="quizname">
	<button id="ajaxpost">Add</button>

	<label for="search">Search</label>
	<input type="text" name="search" id="search">
	
	<div id="quizdetails">

		<?php foreach($quizzes as $quiz): ?>
			<h3>Quizname: <a href="<?php echo base_url(); ?>admin/quiz/<?php echo $quiz['idQuiz']; ?>"><?php echo $quiz['Quizname']; ?></a></h3>
		<?php endforeach; ?>

	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/quizHome.js'); ?>"></script>
