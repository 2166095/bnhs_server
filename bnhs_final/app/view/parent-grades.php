<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
	<div class="row">
		<div id="widget">
			<div class="header">
				<p><i class="fas fa-file fnt"></i><span> Grades</span></p>
			</div>
			<div class="widgetcontent">
				<table>
					<tr>
						<th>Subject</th>
						<th>1st Grading</th>
						<th>2nd Grading</th>
						<th>3rd Grading</th>
						<th>4th Grading</th>
						<th>Final Grade</th>
						<th>Remarks</th>
					</tr>
						<?php $run->getChildGrade(); ?>
				</table>
			</div>
		</div>
	</div>