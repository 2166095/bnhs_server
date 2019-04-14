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
						<?php $run->getChildGrade($_SESSION['accid']); ?>
				</table>
			</div>
		</div>
		<div class="legend"> 
			<p class="bold"><span>Legend</span></p>
			<table id = "soatable">
					<tr>
						<th>Description</th>
						<th>Grading Scale</th>
						<th>Remarks</th>
					</tr>
					<tr>
						<td>Outstanding</td>
						<td>90-100</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Very Satisfactory</td>
						<td>85-89</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Satisfactory</td>
						<td>80-84</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Fairly Satisfactory</td>
						<td>75-79</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Did Not Meet Expectations</td>
						<td>Below 75</td>
						<td>Failed</td>
					</tr>
				</table>
		</div>
	</div>