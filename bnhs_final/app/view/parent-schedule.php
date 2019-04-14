<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
	<div class="contentpage">
		<div class="row">
			<div id="widget">
				<div class="header">
					<p>	
						<i class="fas fa-user fnt"></i>
						<span>Class Schedule</span>
					</p>			
				</div>
				<?php $run->getChildSchedule(); ?>
			</div>
		</div>
	</div>