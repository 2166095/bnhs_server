<?php
require 'app/model/connection.php';

class studentFunct {

	public function __construct() {
		$this->conn = new Connection;
		$this->conn = $this->conn->connect();
	}
/************** DASHBOARD **********************/

	public function getStatus() {
		$query = $this->conn->prepare("SELECT * from student join accounts on student.accc_id = accounts.acc_id join section on student.secc_id = section.sec_id where accounts.acc_id = ?");
        $query->bindParam(1, $_SESSION['accid']);
		$query->execute();
        $getRowCount = $query->rowCount();
    		while($row = $query->fetch()) {
                $status = $row['stud_status'];
				$attendancelink = URL.'student-attendance';
					echo "<div class='contin'>
						<p>".$row['stud_status']." in this school year: <span class='text-bold'> ".$row['school_year']."</span></p>
						<p>Grade ".$row['year_level']." - ".$row["sec_name"]."</p>
						<p>See <a href='$attendancelink'>absences/tardiness!</a></p>
						</div> ";
			}
	}

    public function getAnnouncement() {
        $query = $this->conn->prepare("SELECT post, concat(fac_fname, ' ', fac_midname, '. ', fac_lname) as fname, attachment FROM announcements an JOIN faculty f ON an.post_facid = f.fac_id JOIN schedsubj ss ON f.fac_id = ss.fw_id JOIN subject ON subject.subj_id = ss.schedsubja_id GROUP BY ann_id");
        $query->execute(); 
        $result = $query->fetchAll();
        foreach ($result as $row) {
            $html = '<div class="continue">';
            $html .= '<p>'.$row['post'].' by '.$row['fname'].'';
            $html .= $row['attachment'] !== null ? '</p> <a href="attachments/'.$row['attachment'].'" download> &nbsp;- download attachment</a></p>' : '';
            $html .= '</div>';
            echo $html;
        }
    }

    /*<a href="downloadNotes?file='.urldecode($attachment).'">Download</a>*/

	public function getPerformance(){
        $query = $this->conn->prepare("SELECT year_level, Round(avg(grade), 2) as Average from student join accounts on student.accc_id = accounts.acc_id join grades on stud_id = studd_id where accounts.acc_id =?");
        $query->bindParam(1,$_SESSION['accid']);
        $query->execute();
        $getRowNum = $query->rowCount();
        if ($getRowNum > 0) {
            while($row = $query->fetch()){
                echo "<tr>
					<td><span>Grade ".$row['year_level']."</span></td>
										<td><span> ".$row['Average']." </span></td>
										<td><span>3</span></td>
									</tr>";
            }
        }
    }

	

/************** ATTENDANCE **********************/

	public function studAttendance() {
		$query = $this->conn->prepare("SELECT att_date, remarks, subject.subj_name FROM attendance att JOIN student stud ON stud.stud_id = att.stud_ida JOIN subject ON subject.subj_id = att.subjatt_id JOIN accounts acc ON stud.accc_id = acc.acc_id where acc.acc_id = ? ");
        $query->bindParam(1, $_SESSION['accid']);
		$query->execute();
		$getRowCount = $query->rowCount();
        if($getRowCount > 0){
            $html = '<table class="display" id="stud-attendance-table">
                    <tr>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Tardy/Absent</th>
                    </tr>';
                echo $html;
            while($row = $query->fetch()) {       
                $html = '<tr>
                    <td><span>' .$row['subj_name']. '</span></td>
                        <td><span>' .$row['att_date']. '</span></td>
                        <td><span>' .$row['remarks']. '</span></td>
                    </tr>';
                echo $html;
            }
            echo '</table>';
        }else{
            echo "<p>No absences! Keep it up!</p>";
	}
        }

    

/************** Statements of Account **********************/
	public function getBalance() {
		$query = $this->conn->prepare("SELECT * from balance join student on balance.stud_idb = student.stud_id join accounts on student.accc_id = accounts.acc_id where accounts.acc_id = ?");
        $query->bindParam(1, $_SESSION['accid']);
		$query->execute();
		$getRowCount = $query->rowCount();
		$today = date("F d, Y");
		if ($getRowCount > 0) {
    		while($row = $query->fetch()) {
    			echo "".number_format($row['bal_amt'], 2)." as of ".$today." ";
    		}
    	}
	}

	public function getPaymentHisto() {
		$query = $this->conn->prepare("SELECT date_format(p.pay_date, '%M %d, %Y') as 'pay_date', p.pay_amt as 'amt_paid' from balance b join payment p on p.balb_id = b.bal_id join student s on b.stud_idb = s.stud_id join accounts a on s.accc_id = a.acc_id where a.acc_id = ?");
        $query->bindParam(1, $_SESSION['accid']);
		$query->execute();
		$getRowCount = $query->rowCount();
		if ($getRowCount > 0) {
            $row = $query->fetchAll();
            $array = array();
            for($c = 0; $c < $getRowCount; $c++){
                    $datePaid = $row[$c]['pay_date'];
                    $amtPaid = $row[$c]['amt_paid'];
                    array_push($array, $amtPaid);
                    echo '<tr>
                            <td>'.$datePaid.'</td>
                            <td class="align-right">&#8369;&nbsp;'.number_format($amtPaid, 2).'</td>
                        </tr>';          
                }
            $total = array_sum($array);
            echo '<tr><td class="bold">Total</td><td class="total">&#8369;&nbsp;'.number_format($total, 2).'</td></tr>';
            
        }
            
	}

	public function getBreakdown() {
		$query= $this->conn->prepare("SELECT budget_name, total_amount from budget_info");
		$query->execute();
		$getRowCount = $query->rowCount();
        $row = $query->fetchAll();
        $array = array();
        for($c = 0; $c < count($row); $c++){
            $budgetAmount = $row[$c]['total_amount'];
            $budgetName = $row[$c]['budget_name'];
            array_push($array, $budgetAmount);
            echo '<tr>
                     <td>'.$budgetName.'</td>
                     <td class="align-right">&#8369;&nbsp;'.number_format($budgetAmount, 2).'</td>
                  </tr>';
        }
        $total = array_sum($array);
        echo '<tr><td class="bold">Total</td><td class="total">&#8369;&nbsp;'.number_format($total, 2).'</td></tr>';
	}

public function getChildGrade($id)
    {
        /*******************Get subject name*******************/
        $query = $this->conn->prepare("SELECT 
                    subj_name
                    FROM
                    grades
                    JOIN
                    student ON grades.studd_id = student.stud_id
                    JOIN
                    facsec fs ON grades.secd_id = fs.sec_idy
                    JOIN
                    schedsubj ss ON (grades.facd_id = ss.fw_id
                    && grades.secd_id = ss.sw_id)
                    JOIN
                    subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id)
                    JOIN
                    accounts ac ON student.accc_id = ac.acc_id
                    WHERE
                    ac.acc_id = ? 
                    group by 1 ORDER BY 1");
        $query->bindParam(1,$id);
        $query->execute();
        $subjects = $query->fetchAll();
        $acc_id  = $id; //sample
        /*$rowCount1 = $query1->rowCount();*/
        
        /*******************Get student grade*******************/
        for ($c = 0; $c < count($subjects); $c++) {
            $subject_name = $subjects[$c]['subj_name'];
            $first        = $this->getGrade($acc_id, $subject_name, '1st');
            $second       = $this->getGrade($acc_id, $subject_name, '2nd');
            $third        = $this->getGrade($acc_id, $subject_name, '3rd');
            $fourth       = $this->getGrade($acc_id, $subject_name, '4th');
            $average      = ($first + $second + $third + $fourth) / 4;
            echo '<tr>';
            echo '<td>' . $subject_name . '</td>';
            echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
            echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
            echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
            echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
            if ($first === 0 || $second === 0 || $third === 0 || $fourth === 0) {
                echo '<td></td>';
            } else {
                echo '<td>' . $average . '</td>';
            }
            echo '</tr>';
        }
    }
    
    private function getGrade($acc_id, $subject, $grading)
    {
        $query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) JOIN accounts ac ON student.accc_id = ac.acc_id WHERE ac.acc_id = :acc_id AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
        $query->execute(array(
            ':acc_id' => $acc_id,
            ':subject' => $subject,
            ':grading' => $grading
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['grade'] : 0;
    }

    public function getSchedule($accid) {
        $querySchedule = $this->conn->prepare("SELECT CONCAT_WS(' - ', TIME_FORMAT(time_start, '%h:%i %p' ), TIME_FORMAT(time_end, '%h:%i %p' )) as 'time',
    subject.subj_name
FROM
    schedsubj ss
        JOIN
    subject ON ss.schedsubjb_id = subject.subj_id
        JOIN
    section ON section.sec_id = ss.sw_id
        JOIN
    student ON student.secc_id = section.sec_id
        JOIN
    accounts ac ON ac.acc_id = student.accc_id
WHERE
    acc_id = ?
ORDER BY 
    time_start");
        $querySchedule->bindParam(1, $accid);
        $querySchedule->execute();
        
        echo '<div class="widgetcontent">
        <table id="sched-table">
        <tr><th>Time/Day</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <tr>';
        while ($row = $querySchedule->fetch()){
            echo '<tr><td>'.$row[0].'</td>';
                for($i = 0; $i<=4; $i++){
                    echo '<td>'.$row[1].'</td>';
                }
            echo "</tr>";
        }
    }
/****************************STUDENT INFORMATION*******************************/
    public function studGeneralInfo(){
        $query = $this->conn->prepare("SELECT 
    gender,
    CONCAT(MONTHNAME(stud_bday),
            ' ',
            DAY(stud_bday)) AS 'Birthday',
    stud_address,
    Ethnicity,
    nationality,
    blood_type,
    medical_stat
FROM
    accounts
        JOIN
    student ON acc_id = accc_id
        JOIN
    guardian g ON student.guar_id = g.guar_id
WHERE
    accounts.acc_id =?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo '
                    <div class="continue">
                        <form>
								<label for="sexfield"><span>Gender:</span><input type="text" name="" value="'.$row[0].'"disabled></label>
								<label for="birthday"><span>Birthday:</span><input type="text" name="" value="'.$row['Birthday'].'" disabled></label>
								<label for="religion"><span>Ethnicity:</span><input type="text" name="" value="'.$row['Ethnicity'].'" disabled></label>
								<label for="nationality"><span>Nationality:</span><input type="text" name="" value="'.$row['nationality'].'" disabled></label>
                                <label for="nationality"><span>Blood Type:</span><input type="text" name="" value="'.$row['blood_type'].'" disabled></label>
                                <label for="nationality"><span>Medication</span><input type="text" name="" value="'.$row['medical_stat'].'" disabled></label>
                        </form>
                    </div>
						';
            }
        } else {
            echo '
            <div class="continue">
                        <form>             
                                <label for="birthday"><span>Birthday:</span><input type="text" name="" value="" disabled></label>
                                <label for="religion"><span>Religion:</span><input type="text" name="" value="" disabled></label>
                                <label for="nationality"><span>Nationality:</span><input type="text" name="" value="" disabled></label>
                                <label for="nationality"><span>Blood Type:</span><input type="text" name="" value="" disabled></label>
                                <label for="nationality"><span>Medication</span><input type="text" name="" value="" disabled></label>
                        </form>
                </div>
                ';
        }
    }

    public function studContactInfo() { 
        $query = $this->conn->prepare("SELECT 
    stud_address,
    CONCAT(g.guar_fname,
            ' ',
            g.guar_midname,
            ' ',
            g.guar_lname) AS guardian,
    g.guar_mobno,
    mother_name,
    father_name
FROM
    accounts
        JOIN
    student ON acc_id = accc_id
        JOIN
    guardian g ON student.guar_id = g.guar_id
WHERE
    accounts.acc_id =?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo '
                <div class="continue">
                        <form>
                            <label for="address"><span>Address:</span><input type="text" name="" value="'.$row['stud_address'].'" disabled></label>
                            <label for="fname"><span>Father Name:</span><input type="text" name="" value="'.$row['father_name'].'" disabled></label>
                            <label for="mname"><span>Mother Name:</span><input type="text" name="" value="'.$row['mother_name'].'" disabled></label>
                            <label for="guardian"><span>Guardian:</span><input type="text" name="" value="'.$row['guardian'].'" disabled></label>
                            <label for="cpno"><span>Cellphone Number:</span><input type="text" name="" value="'.$row['guar_mobno'].'" disabled></label>
                        </form>
                </div>    
					';
            }
        } else { echo '
                <div class="continue">
                    <form>
                        <label for="address"><span>Address:</span><input type="text" name="" value="" disabled></label>
                        <label for="fname"><span>Father Name:</span><input type="text" name="" value="" disabled></labelf>
                        <label for="mname"><span>Mother Name:</span><input type="text" name="" value="" disabled></label>
                        <label for="guardian"><span>Guardian:</span><input type="text" name="" value="" disabled></label>
                        <label for="telno"><span>Telephone Number:</span><input type="text" name="" value="" disabled></label>
                        <label for="cpno"><span>Cellphone Number:</span><input type="text" name="" value="" disabled></label>
                    </form>
                </div>
                    ';
                }

    }

    public function getName() { 
        $query = $this->conn->prepare("SELECT concat(first_name,' ', left(middle_name, 1), '.', ' ', last_name) as Name from accounts join student on acc_id = accc_id where accounts.acc_id=?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo ' '.$row['Name'].' ';
    }

    }
}

public function getAccountInfo() { 
        $query = $this->conn->prepare("SELECT username, concat(first_name, ' ', left(middle_name,1), '.', ' ', last_name) as Name, year_in from accounts join student on acc_id = accc_id where accounts.acc_id=?");
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo ' <div class="continue">
                        <form>             
                        <label for="username"><span>Username:</span><input type="text" name="" value="'.$row['username'].'"disabled></label> 
                                <label for="accountName"><span>Account Name:</span><input type="text" name="" value="'.$row['Name'].'" disabled></label>
                                <label for="dateRegistered"><span>Year entered:</span><input type="text" name="" value="'.$row['year_in'].'" disabled></label>
                        </form>
                </div> ';
    }

    }
}

    public function changePassword($currentPass, $newPass, $retypePass){ 
        $query = $this->conn->prepare("select password from accounts where acc_id = ?");
        $userid = $_SESSION['accid'];
        $query->bindParam(1, $userid);
        $query->execute(); 
        $row = $query->fetch();
        if(password_verify($currentPass, $row['password']) and ($newPass == $retypePass) and ($currentPass!=$newPass)){
            $queryUpdate = $this->conn->prepare("UPDATE accounts SET password =? WHERE acc_id=?");
            $newPassword = password_hash($newPass, PASSWORD_DEFAULT);
            $queryUpdate->bindParam(1, $newPassword);
            $queryUpdate->bindParam(2, $userid);
            $queryUpdate->execute();

            if($queryUpdate){
                echo "<script type='text/javascript'>alert('Password has been changed successfully!');</script>";
            }else{
                echo "<script type='text/javascript'>alert('Change password failed');</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Change password failed');</script>";
        }
    }

}




?>