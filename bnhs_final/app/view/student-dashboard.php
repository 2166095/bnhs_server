<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

	<div class="contentpage">
		<div class="row">
			<div class="summary">
				<div class="head">
					<img src="public/images/common/logo.png" class="fl">
					<p class="fl">Bakakeng National High School </p> 
					<p class="text-left"> </br>&nbsp;&nbsp;&nbsp; Student Portal </p>
				</div>
			</div>

				<div class="eventwidget">
				<div class="contleft">
					<div class="header">
						<p>	
							<i class="fas fa-scroll"></i>
							<span>Announcements</span>
						</p>
					</div>
					<div class="cont">		
						<div class="conthead">
							<?php $run->getAnnouncement();?>
						</div>
					</div>
				</div>
				<div class="contright">
					<div class="innercont1">
						<div class="header">
							<p>	
								<i class="fas fa-user fnt"></i>
								<span>Student Status</span>
							</p>
						</div>
						<div class="eventcontent">
							<div class="echead">
								<p>Status</p>
							</div>
							<?php $run->getStatus(); ?>
							<div class="echead">
								<p>Academic Performance:</p>
							</div>
							<div class="contin">
								<table>
									<tr>
										<th>Grade Level</th>
										<th>Average</th>
										<th>Rank</th>
									</tr>
										<?php $run->getPerformance(); ?>
								</table>
							</div>
						</div>
					</div>
					<div class="innercont2">
						<div class="header">
							<p>	
								<i class="far fa-calendar-alt fnt"></i>
								<span>Event Calendar</span>
							</p>
						</div>
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
