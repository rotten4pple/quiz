<div id="quizlist">

	<h1>Quizlist</h1>

	<div id="quizdetails">

		<?php foreach($quizzes as $quiz): ?>
			<h3><a href="<?php echo base_url(); ?>playquiz/<?php echo $quiz['idQuiz']; ?>"><?php echo $quiz['Quizname']; ?></a></h3>
		<?php endforeach; ?>

	</div>
</div>