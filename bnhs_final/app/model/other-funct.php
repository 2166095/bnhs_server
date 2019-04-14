<?php 
class OtherMethods {
	/*
	* This method is ONLY accessible on this class.
	* This is used for displaying messages and this is display through the whole page.
	* $message ~ This variable contains the message you want to display.
	* $color ~ This is the color of the message examples (black, #000, rgb(0,0,0), rgba(0,0,0,0.5) etc.).
	* $page ~ This depends on action "If action is equal to redirect then it will redirect to that page".
	* $action ~ This can either be 'redirect', 'fadeout', 'none'. 
	*/
	public function Message($message, $color, $page, $action) {
		$newUrl = URL.$page;
		if ($action === 'redirect') {
			echo "<div data-type='message' style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999; overflow: hidden;'>
			<div style='width:100%; padding: 17px 0; background: ".$color."; color: #fff;'>
					<div class='modal-box' style='width: 100%;'>
						<p style='margin: 0; font-size: 16px;'>".$message." Wait <span class='count'>5</span> seconds or <a style='color: #4b4bff; text-decoration: underline;' href='".$newUrl."'>Click here</a></p>
					</div>
				</div>
			</div>
			<script>
			$('div[data-type=message]').appendTo('body');
			$('div[id*=\"_home\"]').addClass('modal-enabled');
			var sec = 4;
			var timer = setInterval(function() {
				$('.modal-box .count').text(sec--);
				if (sec == -1) {
					clearInterval(timer);
				}
			}, 1000);
			setTimeout(function(){
			   window.location = '".$newUrl."';
			}, 5000);
			</script>";
		} else if ($action === 'fadeout') {
			echo "<div data-type='message' style='position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999999; overflow: hidden;'>
			<div style='width:100%; padding: 17px 0; background: ".$color."; color: #fff;'>
					<div class='modal-box' style='width: 100%;'>
						<p style='margin: 0; font-size: 16px;'>".$message." Wait <span class='count'>5</span> seconds</p>
					</div>
				</div>
			</div>
			<script>
			$('div[data-type=message]').appendTo('body');
			$('div[id*=\"_home\"]').addClass('modal-enabled');
			var sec = 4;
			var timer = setInterval(function() {
				$('.modal-box .count').text(sec--);
				if (sec == -1) {
					clearInterval(timer);
				}
			}, 1000);
			setTimeout(function(){
			   $('div[data-type=message]').remove();
			   $('div[id*=\"_home\"]').removeClass('modal-enabled');
			}, 5000);
			</script>";
		}
	}
}
?>