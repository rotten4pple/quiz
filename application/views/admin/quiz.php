<div id="adminpanel">
	<!-- <h1>Quizname: <?php echo $quizzes[0]['Quizname']; ?></h1> -->

	<div id="validation_errors"><?php echo validation_errors(); ?></div>

	<h2>Add new question</h2>
	<label for="question">Question</label>
	<select name="question" id="question">
		<option value="">- -</option>
		<?php foreach($groups as $group): ?>
	    <option value="<?php echo $group['idGroup']; ?>"><?php echo $group['Groupname']; ?></option>
	    <?php endforeach; ?>
	</select>
	<input type="hidden" name="quiz" value="<?php echo $quizzes[0]['idQuiz']; ?>" id="quizId">
	<label for="answers">Answers</label>
	<select name="answers" id="answeramount">
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
	</select>

	<div id="answerinputs">
		<label for="answer1">Answer 1</label>
		<input type="text" name="answer1" class="answers" id="firstanswer" readonly>
		<label for="answer2">Answer 2</label>
		<input type="text" name="answer2" class="answers">
	</div>
	<button id="ajaxpost">Add</button>

	<div id="quizdetails">
		<?php foreach($quizzes as $quiz): ?>
			<div id="quizName">
				<h3 id="quizNameHeader"><?php echo $quiz['Quizname']; ?></h3>
				<button id="quizEdit">Edit</button>
				<a href="<?php echo base_url(); ?>admin/quiz/<?php echo $quiz['idQuiz']; ?>/delete"><button>Delete</button></a>
			</div>
			<div id="questionsList">
			<?php $countQuestion = 1; ?>
			<?php foreach($questions as $question): ?>
				<?php if ($quiz['idQuiz'] == $question['Quiz_idQuiz']): ?>
				<hr>
				<p class="question">Question <?php echo $countQuestion ?>: <?php echo $question['Groupname']; ?></p>
				<button class="questionDelete" data-questionid="<?php echo $question['idQuestion']; ?>">Delete</button>
				<?php $countQuestion++; ?>
				<?php endif; ?>
				<?php $countAnswer = 1; ?>
				<?php foreach($answers as $answer): ?>
					<?php if ($question['idQuestion'] == $answer['Question_idQuestion'] && $quiz['idQuiz'] == $question['Quiz_idQuiz']): ?>
						<div class="answers-inline">
						<?php if ($answer['Correct'] == 0): ?>
							<p class="answer" id="answer<?php echo $answer['idAnswer']; ?>">Answer <?php echo $countAnswer ?>: <?php echo $answer['AnswerValue']; ?></p>
							<button class="answerEdit" data-answerid="<?php echo $answer['idAnswer']; ?>">Edit</button>
							<button class="answerDelete" data-answerid="<?php echo $answer['idAnswer']; ?>">Delete</button>
						<?php elseif ($answer['Correct'] == 1): ?>
							<p class="answercorrect">Answer <?php echo $countAnswer ?>: <?php echo $answer['AnswerValue']; ?></p>
						<?php endif; ?>
						</div>
						<?php $countAnswer++; ?>
					<?php endif; ?>
				<?php endforeach; ?> <!-- end answerloop -->
				<?php if ($countAnswer <= 6): ?>
					<div class="answers-inline">
						<p class="answer">Answer <?php echo $countAnswer ?>:</p>
						<button class="addAnswer" data-questionid="<?php echo $question['idQuestion']; ?>">Add</button>
					</div>
				<?php endif; ?>
			<?php endforeach; ?> <!-- end questionloop -->
			</div>
		<?php endforeach; ?> <!-- end quizloop -->
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/quiz.js'); ?>"></script>
