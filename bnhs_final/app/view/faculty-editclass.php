<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct() ?>
<div class="contentpage">
	<div class="row">	
		<div class="widget">	
			<div class="header">	
				<p>	<i class="fas fa-user-plus fnt"></i><span> Edit Class</span></p>
				<p>School Year: 2019-2020</p>
			</div>	
			<div class="editContent widgetcontent">
				<div class ="cont">
					<div class= "box1">
						<span>Grade Level & Section: </span>
						<select>
						<option value="Grade 7">Grade 7 - Hope</option>
						<option value="Grade 7">Grade 7 - Excellence</option>
						<option value="Grade 8">Grade 8 - Altruism</option>
						<option value="Grade 8">Grade 8 - Wisdom</option>
						<option value="Grade 9">Grade 9 - Dignity</option>
						<option value="Grade 9">Grade 9 - Righteousness</option>
						<option value="Grade 10">Grade 10 - Freedom</option>
						<option value="Grade 10">Grade 10 - Independence</option>
						</select>
					</div>
					<div class="box2">
						<span>Adviser: </span>
						<p>Sir Al J. Hon</p>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="cont3">
					<div class="table-scroll">	
						<div class="table-wrap">
							<table>
								<tr>
									<th>TIME</th>
									<th>MONDAY</th>
									<th>TUESDAY</th>
									<th>WEDNESDAY</th>
									<th>THURSDAY</th>
									<th>FRIDAY</th>
								</tr>
								<tr>
									<td>7:40 - 8:40</td>
									<?php $getFactFunct->editClass(); ?>
								</tr>
								<tr>
									<td>8:40 - 9:40</td>
								</tr>
								<tr>
									<td>9:40 - 10:00</td>
									<td>RECESS</td>
									<td>RECESS</td>
									<td>RECESS</td>
									<td>RECESS</td>
									<td>RECESS</td>
								</tr>
								<tr>
									<td>10:00 - 11:00</td>
								</tr>
								<tr>
									<td>11:00 - 12:00</td>
								</tr>
								<tr>
									<td>12:00 - 1:00</td>
									<td>LUNCH</td>
									<td>LUNCH</td>
									<td>LUNCH</td>
									<td>LUNCH</td>
									<td>LUNCH</td>
								</tr>
								<tr>
									<td>1:00 - 2:00</td>
								</tr>
								<tr>
									<td>2:00 - 3:00</td>
								</tr>
								<tr>
									<td>3:00 - 4:00</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="cont4">
						<button>Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>