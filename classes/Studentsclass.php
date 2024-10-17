<?php

use PhpOffice\PhpSpreadsheet\Shared\Trend\Trend;

class Studentsclass extends Mainclass
{
	public function get_wes_verification_list($ADMITTED_STUDENT_ID)
	{
		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
		$sql = "SELECT * FROM wes WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID'";
		//exit;
		$result = $this->db->select($sql);
		return $result;

	}
	public function setApplicationOfWES($ADMITTED_STUDENT_ID, $transaction_id, $ref_id, $wes_id)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$transaction_id = $this->fm->validation($transaction_id);
			$ref_id = $this->fm->validation($ref_id);


			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$transaction_id = mysqli_real_escape_string($this->db->link, $transaction_id);
			$ref_id = mysqli_real_escape_string($this->db->link, $ref_id);




			//if (empty($ADMITTED_STUDENT_ID) || empty($degree_awarded) || empty($exam_held_in) || empty($result_publish_date) || empty($number_of_page_trans)) {
			if (empty($transaction_id)) {

				$msg = "<div class='alert alert-danger'> Field Should not be Empty! </div>";
				return $msg;
			} else {

				if (filter_var($ADMITTED_STUDENT_ID, FILTER_VALIDATE_INT)) {
					$sql_i = "SELECT * FROM wes WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND wes_id ='$wes_id'";
					$result_i = $this->db->select($sql_i);
					if ($result_i) {

						$sqlup = "UPDATE wes SET transaction_id='$exam_year',ref_id='$roll_no' WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND wes_id='$wes_id' ";
						$result = $this->db->update($sqlup);
						if ($result) {
							$msg = "<div class='alert alert-success'> Update Successfully! </div>";
							return $msg;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}

					} else {
						$sql = "INSERT INTO wes (ADMITTED_STUDENT_ID,transaction_id,ref_id)
		  VALUES('$ADMITTED_STUDENT_ID','$transaction_id','$ref_id')";
						$result = $this->db->insert($sql);
						$lastid = mysqli_insert_id($this->db->link);
						if ($result) {

							//$msg = "<div class='alert alert-success'> Save Successfully! </div>";
							$result_data = array(
								'lastid' => $lastid,
								'ADMITTED_STUDENT_ID' => $ADMITTED_STUDENT_ID
							);
							return $result_data;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}
					}

				} else {
					$msg = "<div class='alert alert-danger'> Student Id is not an integer. </div>";
					return $msg;
				}
			}

		} catch (Exception $e) {

		}
	}

	public function checkSpacialPermission($exam_id, $ADMITTED_STUDENT_ID)
	{
		$isPermitted = false;
		$permission_id = 0;
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

		$selectQ = "SELECT `id` FROM `special_exam_permission` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID`='$exam_id' AND `IS_FORM_FILLUP`='0' AND `STATUS`='1';";
		$result = $this->db->select($selectQ);

		if ($result->num_rows > 0) {
			$row123 = $result->fetch_assoc();
			$permission_id = $row123['id'];
		}
		if ($permission_id != 0) {
			$isPermitted = true;
		}

		return $isPermitted;
	}

	public function checkTransaction($transaction_id)
	{
		$transaction_payment_id = '';
		$transaction_id = $this->fm->validation($transaction_id);
		$transaction_id = mysqli_real_escape_string($this->db->link, $transaction_id);
		$sql = "SELECT * FROM transcripts WHERE transaction_id= '$transaction_id' LIMIT 1";
		$result = $this->db->select($sql);
		//$row=mysql_fetch_assoc($result);
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$transaction_payment_id = $row['transaction_id'];
			}
		}
		return $transaction_payment_id;
	}
	public function updateDraftCopyStatus($ADMITTED_STUDENT_ID, $transcripts_id)
	{
		$transcripts_id = $this->fm->validation($transcripts_id);
		$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);
		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

		$sql = "UPDATE transcripts SET draft_copy_status=1 WHERE ADMITTED_STUDENT_ID='$ADMITTED_STUDENT_ID' AND trannscript_id ='$transcripts_id'";
		$result = $this->db->update($sql);
		return $result;
	}

	public function updatePaymentStatus($ADMITTED_STUDENT_ID, $transcripts_id)
	{
		$transcripts_id = $this->fm->validation($transcripts_id);
		$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);
		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

		$sql = "UPDATE transcripts SET payment_status=1 WHERE ADMITTED_STUDENT_ID='$ADMITTED_STUDENT_ID' AND trannscript_id ='$transcripts_id'";
		$result = $this->db->update($sql);
		return $result;
	}

	public function get_trs_comment_list($transcript_id)
	{
		$transcript_id = $this->fm->validation($transcript_id);
		$transcript_id = mysqli_real_escape_string($this->db->link, $transcript_id);
		$sql = "SELECT * FROM comment WHERE trs_id = '$transcript_id'";
		$result = $this->db->select($sql);
		return $result;
	}

	public function get_transcript_list($ADMITTED_STUDENT_ID)
	{
		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
		$sql = "SELECT * FROM transcripts WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND APPLICATION_TYPE='TRANSCRIPT'";
		$result = $this->db->select($sql);
		return $result;

	}

	public function get_certificate_list($ADMITTED_STUDENT_ID)
	{
		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
		$sql = "SELECT * FROM transcripts WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND APPLICATION_TYPE='CERTIFICATE'";
		$result = $this->db->select($sql);
		return $result;

	}
	public function get_marksheet_list($ADMITTED_STUDENT_ID)
	{

		$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
		$sql = "SELECT * FROM transcripts WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND APPLICATION_TYPE='MARKSHEET'";
		$result = $this->db->select($sql);


		return $result;

	}


	public function getReferred_ImranHosen_ResultByYearId($ADMITTED_STUDENT_ID, $transcripts_id, $COURSE_YEAR_ID)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
			$transcripts_id = $this->fm->validation($transcripts_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
			$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);

			if (!empty($ADMITTED_STUDENT_ID) && !empty($COURSE_YEAR_ID) && !empty($transcripts_id)) {

				$sql = "SELECT * FROM transcript_details WHERE trs_year_id_im = '$COURSE_YEAR_ID' AND trannscript_id  = '$transcripts_id' AND  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID'";
				//exit;
				$result = $this->db->select($sql);
				return $result;
			}
		} catch (Exception $e) {

		}

	}
	public function student_type_get($type)
	{
		$type = mysqli_real_escape_string($this->db->link, $type);

		if ($type == '1') {
			return "Regular";
		} else if ($type == '2') {
			return "Improvement";
		}
	}
	public function checkStudentFormFillUpEligible($exam_id)
	{
		try {
			$exam_id = $this->fm->validation($exam_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$sql = "SELECT * FROM registered_exam WHERE REGISTERED_EXAM_ID='$exam_id'";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function setTranscriptResultData($ADMITTED_STUDENT_ID, $transcripts_id, $trs_year_id_im, $trs_program_id_im, $course_subject_id, $letter_grade, $referred_roll, $transcripts_id)
	{


		try {

			$num = count($letter_grade);

			if ($num > 0) {
				for ($i = 0; $i < $num; $i++) {

					$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
					$transcripts_id = $this->fm->validation($transcripts_id);
					$trs_year_id_im = $this->fm->validation($trs_year_id_im);
					$trs_program_id_im = $this->fm->validation($trs_program_id_im);
					$transcripts_id = $this->fm->validation($transcripts_id);


					$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
					$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);
					$trs_year_id_im = mysqli_real_escape_string($this->db->link, $trs_year_id_im);
					$trs_program_id_im = mysqli_real_escape_string($this->db->link, $trs_program_id_im);
					$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);

					$grade_point = '';
					$grade = $letter_grade[$i];
					if ($grade == "A+") {
						$grade_point = "4.00";
					}
					if ($grade == "A") {
						$grade_point = "3.75";
					}
					if ($grade == "A-") {
						$grade_point = "3.50";
					}
					if ($grade == "B+") {
						$grade_point = "3.25";
					}
					if ($grade == "B") {
						$grade_point = "3.00";
					}
					if ($grade == "B-") {
						$grade_point = "2.75";
					}
					if ($grade == "C+") {
						$grade_point = "2.50";
					}
					if ($grade == "C") {
						$grade_point = "2.25";
					}
					if ($grade == "D") {
						$grade_point = "2.00";
					}

					$csql = "SELECT * FROM transcript_details WHERE trannscript_id='$transcripts_id' AND ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND COURSE_CODE_TITLE_ID = '" . mysqli_real_escape_string($this->db->link, $course_subject_id[$i]) . "'";

					$cresult = $this->db->select($csql);
					if ($cresult) {
						$usql = "UPDATE transcript_details
					SET
					letter_grade = '" . mysqli_real_escape_string($this->db->link, $letter_grade[$i]) . "',
					referred_roll= '" . mysqli_real_escape_string($this->db->link, $referred_roll[$i]) . "',
					grade_point= '" . mysqli_real_escape_string($this->db->link, $grade_point) . "'
					WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND COURSE_CODE_TITLE_ID = '" . mysqli_real_escape_string($this->db->link, $course_subject_id[$i]) . "'";
						$uresult = $this->db->update($usql);
					} else {

						$sql = "INSERT INTO transcript_details
			 (ADMITTED_STUDENT_ID,trannscript_id ,trs_year_id_im,trs_program_id_im,COURSE_CODE_TITLE_ID,letter_grade,referred_roll,grade_point)
			 VALUES('$ADMITTED_STUDENT_ID','$transcripts_id','$trs_year_id_im','$trs_program_id_im','$course_subject_id[$i]','$letter_grade[$i]','$referred_roll[$i]','$grade_point')";
						$result = $this->db->insert($sql);
					}


					//  $csql_rf = "SELECT * FROM transcripts_exam_rf_data WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND COURSE_CODE_TITLE_ID = '".mysqli_real_escape_string($this->db->link, $course_subject_id[$i])."'";

					//  $cresult_rf = $this->db->select($csql_rf);
					if ($cresult_rf) {

						// $usql_rf = "UPDATE transcripts_exam_rf_data SET rf1 = '".mysqli_real_escape_string($this->db->link, $rf1[$i])."', rf2 = '".mysqli_real_escape_string($this->db->link, $rf2[$i])."', rf3 = '".mysqli_real_escape_string($this->db->link, $rf3[$i])."', rf4 = '".mysqli_real_escape_string($this->db->link, $rf4[$i])."' WHERE  ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND COURSE_CODE_TITLE_ID = '".mysqli_real_escape_string($this->db->link, $course_subject_id[$i])."'";
						//  $uresult_rf = $this->db->update($usql_rf);

					} else {

						if (!empty($rf1[$i])) {

							//$sql_rf = "INSERT INTO transcripts_exam_rf_data(ADMITTED_STUDENT_ID,transcripts_id,curriculum,trs_year_id_im,trs_program_id_im,COURSE_CODE_TITLE_ID,rf1,rf2,rf3,rf4) VALUES('$ADMITTED_STUDENT_ID','$transcripts_id','$curriculum','$trs_year_id_im','$trs_program_id_im','".mysqli_real_escape_string($this->db->link, $course_subject_id[$i])."','".mysqli_real_escape_string($this->db->link, $rf1[$i])."','".mysqli_real_escape_string($this->db->link, $rf2[$i])."','".mysqli_real_escape_string($this->db->link, $rf3[$i])."','".mysqli_real_escape_string($this->db->link, $rf4[$i])."')";
							//$result_rf = $this->db->insert($sql_rf);
						}

					}


				}
			}

		} catch (Exception $e) {

		}
	}


	public function getStudentLastEnrollment($ADMITTED_STUDENT_REG_NO)
	{
		try {
			$ADMITTED_STUDENT_REG_NO = $this->fm->validation($ADMITTED_STUDENT_REG_NO);
			$ADMITTED_STUDENT_REG_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_REG_NO);

			$sql = "SELECT * FROM admitted_student WHERE ADMITTED_STUDENT_REG_NO='$ADMITTED_STUDENT_REG_NO'";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function getImprovment($ADMITTED_STUDENT_REG_NO, $exam_id)
	{

		try {

			$ADMITTED_STUDENT_REG_NO = $this->fm->validation($ADMITTED_STUDENT_REG_NO);
			$ADMITTED_STUDENT_REG_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_REG_NO);
			$exam_id = $this->fm->validation($exam_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);


			$sql = "SELECT * FROM imp_course WHERE std_reg_no='$ADMITTED_STUDENT_REG_NO' AND  exam_id='$exam_id'";


			// echo  $sql;

			$result = $this->db->select($sql);
			return $result;

		} catch (Exception $e) {

		}
	}
	public function getcourse_info($ADMITTED_STUDENT_REG_NO, $exam_id)
	{
		try {
			$ADMITTED_STUDENT_REG_NO = $this->fm->validation($ADMITTED_STUDENT_REG_NO);
			$ADMITTED_STUDENT_REG_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_REG_NO);
			$exam_id = $this->fm->validation($exam_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$sql = "SELECT * FROM imp_course WHERE std_reg_no='$ADMITTED_STUDENT_REG_NO' AND  exam_id='$exam_id'";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}
	public function imageDir($SUBJECTS_ID)
	{
		$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		/*if ($SUBJECTS_ID == 1) {
																				  $dir = 's_images';
																		} else if ($SUBJECTS_ID == 2) {
																				  $dir = 's_images_nursing_basic';
																		} else if ($SUBJECTS_ID == 3) {
																				  $dir = 's_images_nursing_post_basic';
																		} else if ($SUBJECTS_ID == 4) {
																		 $dir = 's_images_bds';
																	}*/
		$dir = 's_images';
		return $dir;
	}
	public function imageDir2($SUBJECTS_ID)
	{
		$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		/*if ($SUBJECTS_ID == 1) {
																				  $dir = 's_images';
																		} else if ($SUBJECTS_ID == 2) {
																				  $dir = 's_images_nursing_basic';
																		} else if ($SUBJECTS_ID == 3) {
																				  $dir = 's_images_nursing_post_basic';
																		} else if ($SUBJECTS_ID == 4) {
																		 $dir = 's_images_bds';
																	}*/
		$dir = 'payslip';
		return $dir;
	}
	public function course_year_titles_programs($id = NULL)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);

		if ($id == 1) {
			return "First Professional M.B.B.S. ";
		} elseif ($id == 2) {
			return "Second Professional M.B.B.S. ";
		} elseif ($id == 3) {
			return "Third Professional M.B.B.S. ";
		} elseif ($id == 4) {
			return "Final Professional M.B.B.S. ";
		} elseif ($id == 5) {
			return "First year B.Sc in Nursing ";
		} elseif ($id == 6) {
			return "2nd year B.Sc in Nursing ";
		} elseif ($id == 7) {
			return "3rd year B.Sc in Nursing ";
		} elseif ($id == 8) {
			return "Final year B.Sc in Nursing ";
		} elseif ($id == 9) {
			return "Preliminary Post B.Sc in Nursing ";
		} elseif ($id == 10) {
			return "Final Post B.Sc in Nursing ";
		}
	}

	public function getExamMonth()
	{
		$gem = '<option value="" style="display:none;"> Select Month </option>
            <option value="January"> January </option>
            <option value="May"> May </option>
            <option value="July"> July </option>
            <option value="November"> November </option>';
		echo $gem;
	}

	public function getPreviousExamByProgram($SUBJECTS_ID, $s_year_code)
	{

		try {
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$s_year_code = $this->fm->validation($s_year_code);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);

			$data = '';
			$sql = "SELECT *FROM registered_exam WHERE SUBJECTS_ID=$SUBJECTS_ID AND 	COURSE_YEAR_ID<$s_year_code";
			$result = $this->db->select($sql);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$data .= '<option value="' . $row['REGISTERED_EXAM_ID'] . '">' . $row['EXAM_NAME'] . '</option>';
				}
			}


			echo $data;
		} catch (Exception $e) {

		}
	}

	public function getAppeardExamByProgram($SUBJECTS_ID)
	{

		try {
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

			$data = '';
			if ($SUBJECTS_ID == 1) {
				$data = '<option value="1"> First Professional M.B.B.S. </option>
		    <option value="2"> Second Professional M.B.B.S. </option>
		    <option value="3"> Third Professional M.B.B.S. </option>
		    <option value="4"> Final Professional M.B.B.S. </option>';
			} else if ($SUBJECTS_ID == 2) {
				$data = '<option value="5"> First year B.Sc in Nursing </option>
		    <option value="6"> 2nd year B.Sc in Nursing </option>
		    <option value="7"> 3rd year B.Sc in Nursing </option>
		    <option value="8"> Final year B.Sc in Nursing </option>';
			} else if ($SUBJECTS_ID == 3) {
				$data = '<option value="9"> Preliminary Post B.Sc in Nursing </option>
         	<option value="10"> Final Post B.Sc in Nursing </option>';
			}
			echo $data;
		} catch (Exception $e) {

		}
	}


	public function getSpacialPermittedExam($reg_no)
	{

		$reg_no = mysqli_real_escape_string($this->db->link, $reg_no);

		$rergQuery = "SELECT `ADMITTED_STUDENT_ID` FROM `admitted_student` WHERE ADMITTED_STUDENT_REG_NO='$reg_no' LIMIT 1;";

		$ADMITTED_STUDENT_ID = 0;
		$result11 = $this->db->select($rergQuery);
		if ($result11) {
			while ($ro1w1 = $result11->fetch_assoc()) {

				$ADMITTED_STUDENT_ID = $ro1w1['ADMITTED_STUDENT_ID'];
			}

		}

		if ($ADMITTED_STUDENT_ID != 0) {

			$query = "SELECT registered_exam.*,subjects.SUBJECTS_TITLE_EN
		FROM `registered_exam`
		JOIN subjects ON subjects.SUBJECTS_ID=registered_exam.SUBJECTS_ID JOIN special_exam_permission on special_exam_permission.REGISTERED_EXAM_ID=registered_exam.REGISTERED_EXAM_ID
		 WHERE special_exam_permission.ADMITTED_STUDENT_ID='$ADMITTED_STUDENT_ID' AND special_exam_permission.STATUS='1' AND special_exam_permission.IS_FORM_FILLUP='0'";



			$result = $this->db->select($query);
			return $result;

		}





	}

	public function getAllExamByDpt($department_id)
	{

		$department_id = mysqli_real_escape_string($this->db->link, $department_id);

		$query = "SELECT registered_exam.*,subjects.SUBJECTS_TITLE_EN
		FROM `registered_exam`
		JOIN subjects ON subjects.SUBJECTS_ID=registered_exam.SUBJECTS_ID
		WHERE registered_exam.`REGISTERED_EXAM_STATUS`=1
		AND (registered_exam.`STUDENT_FORM_FILL_UP`=1 OR registered_exam.`STUDENT_FORM_FILL_UP`=2)
		AND registered_exam.`SUBJECTS_ID`='$department_id'
		 AND registered_exam.LAST_DATE>= DATE(NOW())";


		if ($department_id == "161006") {

			$query = "SELECT  registered_exam.*,subjects.SUBJECTS_TITLE_EN  FROM `registered_exam`  JOIN subjects ON subjects.SUBJECTS_ID=registered_exam.SUBJECTS_ID WHERE registered_exam.`REGISTERED_EXAM_STATUS`=1 AND (registered_exam.`STUDENT_FORM_FILL_UP`=1 OR registered_exam.`STUDENT_FORM_FILL_UP`=2) AND ( registered_exam.SUBJECTS_ID='10900178' OR  registered_exam.`SUBJECTS_ID`='10900179'  OR  registered_exam.`SUBJECTS_ID`='10900180' OR  registered_exam.`SUBJECTS_ID`='10900181') AND  registered_exam.LAST_DATE>= DATE(NOW());";

		}
		if ($department_id == "161009") {

			$query = "SELECT  registered_exam.*,subjects.SUBJECTS_TITLE_EN  FROM `registered_exam`  JOIN subjects ON subjects.SUBJECTS_ID=registered_exam.SUBJECTS_ID WHERE registered_exam.`REGISTERED_EXAM_STATUS`=1 AND (registered_exam.`STUDENT_FORM_FILL_UP`=1 OR registered_exam.`STUDENT_FORM_FILL_UP`=2) AND ( registered_exam.SUBJECTS_ID='10900185' OR  registered_exam.`SUBJECTS_ID`='10900179'  OR  registered_exam.`SUBJECTS_ID`='10900182' OR  registered_exam.`SUBJECTS_ID`='10900184') AND registered_exam.LAST_DATE>= DATE(NOW());";

		}

		$result = $this->db->select($query);
		return $result;


	}
	public function addPreviousDedata($name_of_exam, $board_un_coun, $pre_year, $divion_class, $pdeg_student_id)
	{

		try {

			$name_of_exam = $this->fm->validation($name_of_exam);
			$board_un_coun = $this->fm->validation($board_un_coun);
			$pre_year = $this->fm->validation($pre_year);
			$divion_class = $this->fm->validation($divion_class);
			$pdeg_student_id = $this->fm->validation($pdeg_student_id);
			$name_of_exam = mysqli_real_escape_string($this->db->link, $name_of_exam);
			$board_un_coun = mysqli_real_escape_string($this->db->link, $board_un_coun);
			$pre_year = mysqli_real_escape_string($this->db->link, $pre_year);
			$divion_class = mysqli_real_escape_string($this->db->link, $divion_class);
			$pdeg_student_id = mysqli_real_escape_string($this->db->link, $pdeg_student_id);
			$pdeg_student_id = preg_replace('/\D/', '', $pdeg_student_id);
			$pdeg_student_id = (int) $pdeg_student_id;

			if (empty($name_of_exam) || empty($board_un_coun) || empty($pre_year) || empty($divion_class)) {
				echo "Please Enter Data";
			} else {

				$sql = "INSERT INTO post_basic_bsc_nursing_pre_degree(name_of_exam, board_un_coun,pre_year,divion_class,pdeg_student_id) VALUES ('$name_of_exam','$board_un_coun','$pre_year','$divion_class','$pdeg_student_id')";
				$result = $this->db->insert($sql);
				if ($result) {
					echo "Data Inserted";
				} else {
					echo "Please Enter Data";
				}
			}

		} catch (Exception $e) {

		}
	}


	public function getPostBScinNursingPrePassingData($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$sql = "SELECT * FROM post_basic_bsc_nursing_pre_degree WHERE pdeg_student_id = '$ADMITTED_STUDENT_ID' ORDER BY id ASC";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function deletePreDegreeDelById($predid, $presid)
	{

		try {
			$predid = $this->fm->validation($predid);
			$presid = $this->fm->validation($presid);
			$predid = mysqli_real_escape_string($this->db->link, $predid);
			$presid = mysqli_real_escape_string($this->db->link, $presid);
			$predid = preg_replace('/\D/', '', $predid);
			$presid = preg_replace('/\D/', '', $presid);
			$predid = (int) $predid;
			$presid = (int) $presid;

			if (!empty($predid) && !empty($presid)) {
				$sql = "DELETE FROM post_basic_bsc_nursing_pre_degree WHERE id = '$predid' AND pdeg_student_id = '$presid'";
				$result = $this->db->delete($sql);
				if ($result) {
					echo "<div class='alert alert-success'> Delete Successfully! </div><script> location.reload(); </script>";
				} else {
					echo "<div class='alert alert-success'> Not Deleted! </div>";
				}
			}

		} catch (Exception $e) {

		}
	}

	public function getSessionYears()
	{
		try {
			$sql = "SELECT * FROM session WHERE SESSION_STATUS = 1 ORDER BY SESSION_YEAR DESC";
			$result = $this->db->select($sql);
			if ($result) {
				return $result;
			}
		} catch (Exception $e) {

		}
	}

	public function getNoticeByhomeMarquee()
	{
		try {
			$sql = "SELECT * FROM cmc_notice WHERE mrquee = 1 AND notice_status = 1 ORDER BY id DESC";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function check_system_down()
	{

		$sql = "SELECT * FROM `system_settings` WHERE `id`=1";

		$result = $this->db->select($sql);

		$FORM_FILLUP_STATUS = 0;
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$FORM_FILLUP_STATUS = $row["system_setting"];
			}
			$post_data = array(
				'status' => '200',
				'SYSTEM_STATUS' => $FORM_FILLUP_STATUS
			);
			header('Content-type: application/json');
			print json_encode($post_data);

		} else {

			$post_data = array(
				'status' => '202',
				'SYSTEM_STATUS' => "0"
			);
			header('Content-type: application/json');
			print json_encode($post_data);

		}


	}

	/*public function get_1st_roll($college_id,$subject_id,$student_type) {

									 $roll=0;
									 $select_query="SELECT `REGULAR`,`IMPROVEMENT` FROM roll_pattern WHERE `COLLEGE_ID`= $college_id AND `SUBJECT_ID`=$subject_id";
									 $result = $this->db->select($select_query);

									 if($result){
									  while($row = $result->fetch_assoc()) {

									  if($student_type==1 || $student_type==2){
										$roll=$row["REGULAR"];
									  }else {
										$roll=$row["IMPROVEMENT"];
										}
									  }
									 }
									 return $roll;
								   }*/


	public function select_student_to_add_code()
	{

		try {
			$sql = "SELECT registered_students.REGISTERED_STUDENTS_ID, admitted_student.SUBJECTS_ID,admitted_student.ADMITTED_STUDENT_REG_NO,admitted_student.ADMITTED_STUDENT_ID,admitted_student.ADMITTED_STUDENT_NAME FROM `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE registered_students.REGISTERED_EXAM_ID=5 AND admitted_student.SUBJECTS_ID=10 ";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}


	public function insert_new_code($REGISTERED_STUDENTS_ID, $paperCodeID, $exam_id)
	{

		try {
			$REGISTERED_STUDENTS_ID = $this->fm->validation($REGISTERED_STUDENTS_ID);
			$paperCodeID = $this->fm->validation($paperCodeID);
			$exam_id = $this->fm->validation($exam_id);
			$REGISTERED_STUDENTS_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_STUDENTS_ID);
			$paperCodeID = mysqli_real_escape_string($this->db->link, $paperCodeID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$reg_insert_query = "INSERT INTO `selected_courses`(`REGISTERED_STUDENTS_ID`, `REGISTERED_EXAM_ID`, `COURSE_CODE_TITLE_ID`) VALUES ($REGISTERED_STUDENTS_ID,$exam_id,$paperCodeID)";
			$result = $this->db->insert($reg_insert_query);

		} catch (Exception $e) {

		}

	}
	public function get_all_compeleted_student()
	{

		try {
			$sql = "SELECT admitted_student.ADMITTED_STUDENT_REG_NO, admitted_student.SUBJECTS_ID, admitted_student.SESSION_ID FROM `admitted_student` JOIN registered_students ON registered_students.ADMITTED_STUDENT_ID=admitted_student.ADMITTED_STUDENT_ID ";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}

	}


	public function get_exam_details($EXAM_ID)
	{
		try {
			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
			$sql = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`=$EXAM_ID";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}

	}


	public function get_all_student($exam_id)
	{
		try {
			$exam_id = $this->fm->validation($exam_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$sql = "SELECT admitted_student.`ADMITTED_STUDENT_ID`,admitted_student.REGISTERED_COLLEGE_ID AS COLLEGE_ID,admitted_student.SUBJECTS_ID AS SUBJECT_ID, `REGISTERED_STUDENTS_TYPE`,admitted_student.`ADMITTED_STUDENT_REG_NO` AS ADMITTED_STUDENT_REG_NO,REGISTERED_STUDENTS_EXAM_ROLL FROM `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE `REGISTERED_EXAM_ID`=$exam_id AND `REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND REGISTERED_STUDENTS_EXAM_ROLL=0 ORDER BY RAND()";

			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function get_single_student_details_st($student_id)
	{
		try {
			$student_id = $this->fm->validation($student_id);
			$student_id = mysqli_real_escape_string($this->db->link, $student_id);

			$sql = "SELECT * FROM `students_view` WHERE `ADMITTED_STUDENT_ID` = '$student_id'";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}


	}
	public function get_single_exam_details($EXAM_ID)
	{
		try {
			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);

			$info_query = "SELECT * FROM `exam_view` WHERE `REGISTERED_EXAM_ID` = $EXAM_ID GROUP BY `REGISTERED_EXAM_ID`";
			$result = $this->db->select($info_query);
			return $result;

		} catch (Exception $e) {

		}

	}

	public function get_single_exam_detailsByRegStudent($EXAM_ID, $ADMITTED_STUDENT_ID)
	{

		try {

			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$sql = "SELECT * FROM `registered_students` WHERE  `ADMITTED_STUDENT_ID` = $ADMITTED_STUDENT_ID  AND `REGISTERED_EXAM_ID` = $EXAM_ID";
			$result = $this->db->select($sql);
			return $result;

		} catch (Exception $e) {

		}

	}


	public function is_student_allowed_for_late_form_fillup($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$info_query = "SELECT * FROM `registered_students` WHERE  `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID  AND (`REGISTERED_STUDENTS_LATE` = 1)";
			$result = $this->db->select($info_query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function is_student_allowed_for_late_form_fillup1($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$info_query = "SELECT `REGISTERED_EXAM_ID` FROM `registered_students` WHERE  `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID";
			$result = $this->db->select($info_query);
			return $result;

		} catch (Exception $e) {

		}

	}

	public function studentInformationShow($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$info_query = "SELECT * FROM `students_view` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID'";
			$result = $this->db->select($info_query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function studentInformationShowMdImranHosen($ADMITTED_STUDENT_ID)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$sql = "SELECT admitted_student.*,hall.id as hall_id,hall.hall_title_en,session.SESSION_NAME,registered_college.COLLEGE_NAME,subjects.SUBJECTS_TITLE_EN
	  FROM admitted_student
	  JOIN session ON session.SESSION_ID = admitted_student.SESSION_ID
	  JOIN subjects ON subjects.SUBJECTS_ID = admitted_student.SUBJECTS_ID
	  JOIN registered_college ON registered_college.REGISTERED_COLLEGE_ID = admitted_student.REGISTERED_COLLEGE_ID
	  LEFT JOIN hall ON hall.id = admitted_student.HALL
	  WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID'";
			//        if($ADMITTED_STUDENT_ID=='2017829085'){
//
//            echo $sql;
//        }

			//	if($ADMITTED_STUDENT_ID=='2017822596'){ echo $sql;exit; }

			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function studentExamViewById($session_id, $SUBJECTS_ID)
	{

		try {

			$session_id = $this->fm->validation($session_id);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

			$query = "SELECT * FROM `exam_view` WHERE `SESSION_ID` = '$session_id' AND SUBJECTS_ID = '$SUBJECTS_ID' GROUP BY REGISTERED_EXAM_ID ORDER BY `REGISTERED_EXAM_ID` DESC";


			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}
	}

	// Start studentExamViewById method

	public function getStudentExamSessionById($session_id)
	{
		try {
			$session_id = $this->fm->validation($session_id);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);

			$sql1 = "SELECT session.SESSION_NAME AS SESSION_NAME, session.SESSION_STATUS AS SESSION_STATUS, allowed_session.ALLOWED_SESSION_ID AS ALLOWED_SESSION_ID, allowed_session.REGISTERED_EXAM_ID AS REGISTERED_EXAM_ID, allowed_session.SESSION_ID AS SESSION_ID, allowed_session.ALLOWED_SESSION_STATUS AS ALLOWED_SESSION_STATUS FROM session INNER JOIN allowed_session ON allowed_session.SESSION_ID = session.SESSION_ID WHERE session.SESSION_ID = '$session_id'";
			$result = $this->db->select($sql1);
			return $result;
		} catch (Exception $e) {

		}

	}
	public function getStudentExamProgramYears()
	{

		try {
			$sql2 = "SELECT course_year.COURSE_YEAR_ID AS COURSE_YEAR_ID, course_year.COURSE_YEAR_CODE AS COURSE_YEAR_CODE, course_year.COURSE_YEAR_TITLE AS COURSE_YEAR_TITLE, course_year.COURSE_YEAR_STATUS AS COURSE_YEAR_STATUS, programs.SUBJECTS_ID AS SUBJECTS_ID, programs.PROGRAMS_NAME AS PROGRAMS_NAME, programs.PROGRAMS_STATUS AS PROGRAMS_STATUS FROM course_year INNER JOIN programs ON course_year.SUBJECTS_ID = programs.SUBJECTS_ID";
			$result = $this->db->select($sql2);
			return $result;
		} catch (Exception $e) {

		}
	}

	// End studentExamViewById method

	public function studentPrintAdmitCardBystudenID($session_id)
	{
		try {
			$session_id = $this->fm->validation($session_id);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$query = "SELECT * FROM `exam_view` WHERE `SESSION_ID`='$session_id' AND ADMIT_CARD_ISSUE=1";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}
	public function studentNameShowById($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$query = "SELECT * FROM `admitted_student` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID'";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}


	public function studentFormFillUpById($s_year_code, $session_id, $exam_id)
	{
		try {
			$s_year_code = $this->fm->validation($s_year_code);
			$session_id = $this->fm->validation($session_id);
			$exam_id = $this->fm->validation($exam_id);
			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$validation_query = "SELECT `REGISTERED_EXAM_ID` FROM `exam_view` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SESSION_ID`='$session_id' AND `REGISTERED_EXAM_ID`='$exam_id'  AND STUDENT_FORM_FILL_UP=1 AND ADMIT_CARD_ISSUE=0";
			$result = $this->db->select($validation_query);
			return $result;
		} catch (Exception $e) {

		}

	}


	public function studentFormFillUpById1($s_year_code, $session_id, $exam_id)
	{
		try {
			$s_year_code = $this->fm->validation($s_year_code);
			$session_id = $this->fm->validation($session_id);
			$exam_id = $this->fm->validation($exam_id);
			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$validation_query = "SELECT `REGISTERED_EXAM_ID` FROM `exam_view` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SESSION_ID`='$session_id' AND `REGISTERED_EXAM_ID`='$exam_id' AND STUDENT_FORM_FILL_UP=1";
			$result = $this->db->select($validation_query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function studentFormFillUpByIdAPI($session_id, $exam_id)
	{

		try {
			$session_id = $this->fm->validation($session_id);
			$exam_id = $this->fm->validation($exam_id);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$validation_query = "SELECT `REGISTERED_EXAM_ID` FROM `exam_view` WHERE `SESSION_ID`='$session_id' AND `REGISTERED_EXAM_ID`='$exam_id'  AND STUDENT_FORM_FILL_UP=1";
			$result = $this->db->select($validation_query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function firstYearCHeck($s_year_code, $SUBJECTS_ID)
	{
		try {
			$s_year_code = $this->fm->validation($s_year_code);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

			$query = "SELECT * FROM `course_year` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SUBJECTS_ID`='$SUBJECTS_ID' LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function studentByIdShowCourseCodeTitle($s_year_code, $SUBJECTS_ID)
	{
		try {
			$s_year_code = $this->fm->validation($s_year_code);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

			$query = "SELECT * FROM `course_code_title` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SUBJECTS_ID`='$SUBJECTS_ID'";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function isSyllabusCheck($exam_id)
	{
		$syllabus_id = '';
		$query = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`='$exam_id' AND syllabus_id IS NOT NULL";
		$result = $this->db->select($query);
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$syllabus_id = $row["syllabus_id"];
			}
		}
		return $syllabus_id;
	}

	public function studentByIdShowCourseCodeTitleWithSyllabus($s_year_code, $SUBJECTS_ID, $exam_id)
	{
		try {
			$s_year_code = $this->fm->validation($s_year_code);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$exam_id = $this->fm->validation($exam_id);

			$s_year_code = mysqli_real_escape_string($this->db->link, $s_year_code);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$syllabus_id = '';
			$query = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`='$exam_id' AND syllabus_id IS NOT NULL";
			$result = $this->db->select($query);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$syllabus_id = $row["syllabus_id"];
				}
			}

			if ($syllabus_id != '') {
				$query = "SELECT * FROM `course_code_title` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SUBJECTS_ID`='$SUBJECTS_ID' AND `syllabus_id`='$syllabus_id'";
			}

			if ($syllabus_id == '') {
				$query = "SELECT * FROM `course_code_title` WHERE `COURSE_YEAR_ID`='$s_year_code' AND `SUBJECTS_ID`='$SUBJECTS_ID' AND `syllabus_id` IS NULL";
			}

			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function print_all_admit($EXAM_ID, $ADMITTED_STUDENT_ID)
	{
		try {
			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$query = "SELECT students_view.*,registered_students.REGISTERED_STUDENTS_ID, registered_students.REGISTERED_STUDENTS_EXAM_ROLL,registered_students.CENTER_ID, registered_students.REGISTERED_STUDENTS_TYPE,exam_view.PROGRAMS_NAME,exam_view.COURSE_YEAR_TITLE,exam_view.REGISTERED_EXAM_YEAR FROM students_view INNER JOIN registered_students ON students_view.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID JOIN exam_view on exam_view.REGISTERED_EXAM_ID=registered_students.REGISTERED_EXAM_ID  WHERE registered_students.REGISTERED_EXAM_ID=$EXAM_ID AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1 AND registered_students.ADMITTED_STUDENT_ID=$ADMITTED_STUDENT_ID  GROUP BY ADMITTED_STUDENT_ID";
			$result = $this->db->select($query);
			return $result;

		} catch (Exception $e) {

		}

	}

	public function get_college_name($college_id)
	{
		try {
			$college_id = $this->fm->validation($college_id);
			$college_id = mysqli_real_escape_string($this->db->link, $college_id);

			$select_query = "SELECT `COLLEGE_NAME` FROM `registered_college` WHERE `REGISTERED_COLLEGE_ID`=$college_id";

			$result = $this->db->select($select_query);
			$college_name = "";

			if ($result) {
				while ($row = $result->fetch_assoc()) {

					$college_name = $row["COLLEGE_NAME"];

				}
			}

			return $college_name;
		} catch (Exception $e) {

		}

	}


	public function get_selected_course($registered_student_id)
	{
		try {
			$registered_student_id = $this->fm->validation($registered_student_id);
			$registered_student_id = mysqli_real_escape_string($this->db->link, $registered_student_id);

			$query = "SELECT course_code_title.COURSE_CODE_TITLE_CODE,course_code_title.COURSE_CODE_TITLE,course_code_title.COURSE_CODE_TITLE_CREDIT FROM `course_code_title` JOIN selected_courses ON selected_courses.COURSE_CODE_TITLE_ID=course_code_title.COURSE_CODE_TITLE_ID WHERE selected_courses.REGISTERED_STUDENTS_ID=$registered_student_id";

			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function get_registred_student_status($ADMITTED_STUDENT_ID, $exam_id)
	{
		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$registred_status = 0;

			$get_selection_query = "SELECT `REGISTERED_STUDENTS_STATUS`,`REGISTERED_STUDENTS_ID` FROM `registered_students` WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`= '$exam_id'";
			$result = $this->db->select($get_selection_query);
			if ($result) {

				while ($row11 = $result->fetch_assoc()) {
					$registred_status = $row11["REGISTERED_STUDENTS_STATUS"];
				}

			}

			return $registred_status;

		} catch (Exception $e) {

		}

	}

	public function getStudentSelectionByIdCourseView($ADMITTED_STUDENT_ID, $exam_id)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$get_selection_query = "SELECT * FROM `selected_course_view` WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`='$exam_id'";
			$result = $this->db->select($get_selection_query);
			return $result;
		} catch (Exception $e) {

		}
	}



	public function studentFormPreviewById($session_id, $exam_id)
	{
		try {
			$session_id = $this->fm->validation($session_id);
			$exam_id = $this->fm->validation($exam_id);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$validation_query = "SELECT `REGISTERED_EXAM_ID` FROM `exam_view` WHERE  `SESSION_ID`='$session_id' AND `REGISTERED_EXAM_ID`='$exam_id' AND (	STUDENT_FORM_FILL_UP =1 OR REGISTERED_EXAM_LATE_FOR_FILL_UP=1)";
			$result = $this->db->select($validation_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function studentFormPreviewById1($session_id, $exam_id)
	{
		try {

			$session_id = $this->fm->validation($session_id);
			$exam_id = $this->fm->validation($exam_id);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			if (!empty($session_id) || !empty($exam_id)) {
				$validation_query = "SELECT * FROM `exam_view` WHERE `SESSION_ID`='$session_id' AND `REGISTERED_EXAM_ID`='$exam_id'";
				$result = $this->db->select($validation_query);
				if ($result) {
					return $result;
				}
			}
		} catch (Exception $e) {

		}
	}



	public function studentRegisteredCheckById($ADMITTED_STUDENT_ID, $exam_id)
	{

		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$sql = "SELECT registered_students.*,subjects.SUBJECTS_TITLE_EN FROM `registered_students`
		   LEFT JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID =admitted_student.ADMITTED_STUDENT_ID
		   LEFT JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID
		  WHERE  registered_students.ADMITTED_STUDENT_ID='$ADMITTED_STUDENT_ID' AND registered_students.REGISTERED_EXAM_ID='$exam_id'";
			$result = $this->db->select($sql);
			return $result;

		} catch (Exception $e) {

		}
	}

	public function get_first_roll($COLLEGE_ID, $SUBJECT_ID, $student_type)
	{
		try {
			$COLLEGE_ID = $this->fm->validation($COLLEGE_ID);
			$SUBJECT_ID = $this->fm->validation($SUBJECT_ID);
			$student_type = $this->fm->validation($student_type);
			$COLLEGE_ID = mysqli_real_escape_string($this->db->link, $COLLEGE_ID);
			$SUBJECT_ID = mysqli_real_escape_string($this->db->link, $SUBJECT_ID);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$roll = 0;
			$registered_s_check_query = "SELECT `REGULAR`,`IMPROVEMENT` FROM roll_pattern WHERE `COLLEGE_ID`='$COLLEGE_ID' AND `SUBJECT_ID`='$SUBJECT_ID'";
			$result = $this->db->select($registered_s_check_query);
			if ($result) {
				while ($r1w111 = $result->fetch_assoc()) {
					if ($student_type == 1 || $student_type == 2 || $student_type == 4 || $student_type == 5) {

						$roll = $r1w111["REGULAR"];

					} else {
						$roll = $r1w111["IMPROVEMENT"];
					}

				}

			}
			return $roll;
		} catch (Exception $e) {

		}
	}



	public function studentRollGeneraterById($exam_id, $SUBJECTS_ID)
	{

		try {

			$exam_id = $this->fm->validation($exam_id);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);

			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$roll_generate_query = "";

			$queryfrpm = "";
			//if($STUDENT_TYPE==1 || $STUDENT_TYPE==2 || $STUDENT_TYPE==4 ||$STUDENT_TYPE==5 ){

			$roll_generate_query = "SELECT registered_students.REGISTERED_STUDENTS_EXAM_ROLL AS ROLL
	FROM `admitted_student`
	JOIN registered_students ON registered_students.ADMITTED_STUDENT_ID=admitted_student.ADMITTED_STUDENT_ID
	WHERE registered_students.REGISTERED_EXAM_ID=$exam_id
	AND admitted_student.SUBJECTS_ID=$SUBJECTS_ID
	AND (registered_students.REGISTERED_STUDENTS_TYPE=1 OR registered_students.REGISTERED_STUDENTS_TYPE=2 OR registered_students.REGISTERED_STUDENTS_TYPE=4 OR registered_students.REGISTERED_STUDENTS_TYPE=5)
	AND `registered_students`.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 ORDER BY ROLL DESC LIMIT 1";
			$queryfrpm = "Query one";
			/*}else if($STUDENT_TYPE==3 || $STUDENT_TYPE==6 ){

																											  $roll_generate_query="SELECT registered_students.REGISTERED_STUDENTS_EXAM_ROLL AS ROLL FROM `admitted_student`  JOIN registered_students ON registered_students.ADMITTED_STUDENT_ID=admitted_student.ADMITTED_STUDENT_ID WHERE registered_students.REGISTERED_EXAM_ID=$exam_id AND admitted_student.REGISTERED_COLLEGE_ID=$REGISTERED_COLLEGE_ID AND admitted_student.SUBJECTS_ID=$SUBJECTS_ID AND (registered_students.REGISTERED_STUDENTS_TYPE=3 OR registered_students.REGISTERED_STUDENTS_TYPE=6) AND `registered_students`.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 ORDER BY ROLL DESC LIMIT 1";
																											 $queryfrpm="Query two";

																										 }*/

			//echo $roll_generate_query;

			$result = $this->db->select($roll_generate_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function studentgetRegisteredLastIdEditByNew($ADMITTED_STUDENT_ID, $exam_id, $student_type, $class_roll_no, $scholarship_tk, $question_language, $pervious_degree_type, $alebrn, $alebmn)
	{

		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$class_roll_no = $this->fm->validation($class_roll_no);
			$scholarship_tk = $this->fm->validation($scholarship_tk);
			$question_language = $this->fm->validation($question_language);
			$pervious_degree_type = $this->fm->validation($pervious_degree_type);
			$alebrn = $this->fm->validation($alebrn);
			$alebmn = $this->fm->validation($alebmn);

			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$class_roll_no = mysqli_real_escape_string($this->db->link, $class_roll_no);
			$scholarship_tk = mysqli_real_escape_string($this->db->link, $scholarship_tk);
			$question_language = mysqli_real_escape_string($this->db->link, $question_language);
			$pervious_degree_type = mysqli_real_escape_string($this->db->link, $pervious_degree_type);
			$alebrn = mysqli_real_escape_string($this->db->link, $alebrn);
			$alebmn = mysqli_real_escape_string($this->db->link, $alebmn);

			$reg_insert_query = "INSERT INTO registered_students(ADMITTED_STUDENT_ID, REGISTERED_EXAM_ID,REGISTERED_STUDENTS_TYPE,CLASS_ROLL,SCHOLARSHIP_TK,QUESTION_LNANGUAGE,PREVIOUS_DEGREE_TYPE,alebrn,alebmn) VALUES ('$ADMITTED_STUDENT_ID','$exam_id',$student_type,'$class_roll_no','$scholarship_tk','$question_language','$pervious_degree_type','$alebrn','$alebmn')";

			$result = $this->db->insert($reg_insert_query);
			$lastid = mysqli_insert_id($this->db->link);
			return $lastid;

		} catch (Exception $e) {

		}
	}

	public function studentgetRegisteredLastIdEditByMdImranHosen($EMAIL_ADDRESS, $ADMITTED_STUDENT_ID, $exam_id, $student_type, $class_roll_no, $REGISTERED_STUDENTS_EXAM_ROLL, $question_language, $pervious_degree_type, $last_passed_prof_roll, $local_address, $punishment_exam, $punishment_exam_month, $punishment_exam_year, $punishment_exam_roll, $punishment_name, $form_fill_up_date, $RESIDENTIAL_ROOM_NO)
	{

		try {

			$REGISTERED_STUDENTS_EXAM_ROLL = $this->fm->validation($REGISTERED_STUDENTS_EXAM_ROLL);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$class_roll_no = $this->fm->validation($class_roll_no);
			$question_language = $this->fm->validation($question_language);
			$pervious_degree_type = $this->fm->validation($pervious_degree_type);
			// $last_passed_prof_year  = $this->fm->validation($last_passed_prof_year);
			$last_passed_prof_roll = $this->fm->validation($last_passed_prof_roll);
			// $year_of_admission      = $this->fm->validation($year_of_admission);
			$local_address = $this->fm->validation($local_address);
			$punishment_exam = $this->fm->validation($punishment_exam);
			$punishment_exam_month = $this->fm->validation($punishment_exam_month);
			$punishment_exam_year = $this->fm->validation($punishment_exam_year);
			$punishment_exam_roll = $this->fm->validation($punishment_exam_roll);
			$punishment_name = $this->fm->validation($punishment_name);
			$form_fill_up_date = $this->fm->validation($form_fill_up_date);
			$EMAIL_ADDRESS = $this->fm->validation($EMAIL_ADDRESS);

			$REGISTERED_STUDENTS_EXAM_ROLL = mysqli_real_escape_string($this->db->link, $REGISTERED_STUDENTS_EXAM_ROLL);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$class_roll_no = mysqli_real_escape_string($this->db->link, $class_roll_no);
			$question_language = mysqli_real_escape_string($this->db->link, $question_language);
			$pervious_degree_type = mysqli_real_escape_string($this->db->link, $pervious_degree_type);
			$appeard_exam_name = "";
			$last_passed_prof_month = "";
			$last_passed_prof_year = "";
			$last_passed_prof_roll = mysqli_real_escape_string($this->db->link, $last_passed_prof_roll);
			$year_of_admission = "";
			$local_address = mysqli_real_escape_string($this->db->link, $local_address);
			$punishment_exam = mysqli_real_escape_string($this->db->link, $punishment_exam);
			$punishment_exam_month = mysqli_real_escape_string($this->db->link, $punishment_exam_month);
			$punishment_exam_year = mysqli_real_escape_string($this->db->link, $punishment_exam_year);
			$punishment_exam_roll = mysqli_real_escape_string($this->db->link, $punishment_exam_roll);
			$punishment_name = mysqli_real_escape_string($this->db->link, $punishment_name);
			$form_fill_up_date = mysqli_real_escape_string($this->db->link, $form_fill_up_date);
			$RESIDENTIAL_ROOM_NO = mysqli_real_escape_string($this->db->link, $RESIDENTIAL_ROOM_NO);
			$EMAIL_ADDRESS = mysqli_real_escape_string($this->db->link, $EMAIL_ADDRESS);

			$reg_insert_query = "INSERT INTO registered_students(EMAIL_ADDRESS,ADMITTED_STUDENT_ID, REGISTERED_EXAM_ID,REGISTERED_STUDENTS_TYPE,CLASS_ROLL,REGISTERED_STUDENTS_EXAM_ROLL,QUESTION_LNANGUAGE,PREVIOUS_DEGREE_TYPE,appeard_exam_name,last_passed_prof_month,last_passed_prof_year,last_passed_prof_roll,year_of_admission,local_address,punishment_exam,punishment_exam_month,punishment_exam_year,punishment_exam_roll,punishment_name,form_fill_up_date,RESIDENTIAL_ROOM_NO) VALUES ('$EMAIL_ADDRESS','$ADMITTED_STUDENT_ID','$exam_id',$student_type,'$class_roll_no','$REGISTERED_STUDENTS_EXAM_ROLL','$question_language','$pervious_degree_type','$appeard_exam_name','$last_passed_prof_month','$last_passed_prof_year','$last_passed_prof_roll','$year_of_admission','$local_address','$punishment_exam','$punishment_exam_month','$punishment_exam_year','$punishment_exam_roll','$punishment_name','$form_fill_up_date','$RESIDENTIAL_ROOM_NO')";
			//exit;
			$result = $this->db->insert($reg_insert_query);
			$lastid = mysqli_insert_id($this->db->link);
			return $lastid;

		} catch (Exception $e) {

		}
	}


	public function studentgetRegisteredLastId($ADMITTED_STUDENT_ID, $exam_id, $student_type, $pervious_degree_type)
	{

		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$pervious_degree_type = $this->fm->validation($pervious_degree_type);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$pervious_degree_type = mysqli_real_escape_string($this->db->link, $pervious_degree_type);

			$reg_insert_query = "INSERT INTO `registered_students`(`ADMITTED_STUDENT_ID`, `REGISTERED_EXAM_ID`,`REGISTERED_STUDENTS_TYPE`,`PREVIOUS_DEGREE_TYPE`) VALUES ('$ADMITTED_STUDENT_ID','$exam_id',$student_type,$pervious_degree_type)";

			$result = $this->db->insert($reg_insert_query);
			$lastid = mysqli_insert_id($this->db->link);
			return $lastid;

		} catch (Exception $e) {

		}
	}

	public function update_Student_type($ADMITTED_STUDENT_ID, $exam_id, $student_type, $class_roll, $scholarship_tk, $question_language, $pervious_degree_type, $alebrn, $alebmn)
	{
		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$class_roll = $this->fm->validation($class_roll);
			$scholarship_tk = $this->fm->validation($scholarship_tk);
			$question_language = $this->fm->validation($question_language);
			$pervious_degree_type = $this->fm->validation($pervious_degree_type);
			$alebrn = $this->fm->validation($alebrn);
			$alebmn = $this->fm->validation($alebmn);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$class_roll = mysqli_real_escape_string($this->db->link, $class_roll);
			$scholarship_tk = mysqli_real_escape_string($this->db->link, $scholarship_tk);
			$question_language = mysqli_real_escape_string($this->db->link, $question_language);
			$pervious_degree_type = mysqli_real_escape_string($this->db->link, $pervious_degree_type);
			$alebrn = mysqli_real_escape_string($this->db->link, $alebrn);
			$alebmn = mysqli_real_escape_string($this->db->link, $alebmn);

			if (!empty($ADMITTED_STUDENT_ID) || !empty($exam_id) || !empty($student_type)) {

				$reg_insert_query = "UPDATE `registered_students` SET `PREVIOUS_DEGREE_TYPE`=$pervious_degree_type, `REGISTERED_STUDENTS_TYPE` = '$student_type', CLASS_ROLL = '$class_roll', SCHOLARSHIP_TK = '$scholarship_tk', QUESTION_LNANGUAGE = '$question_language', alebrn = '$alebrn', alebmn = '$alebmn' WHERE `ADMITTED_STUDENT_ID`= '$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID`= '$exam_id'";


				$result = $this->db->update($reg_insert_query);
				if ($result) {
					return $result;
				}
			}

		} catch (Exception $e) {

		}

	}

	public function update_Student_typeMdImranHosen($EMAIL_ADDRESS, $ADMITTED_STUDENT_ID, $exam_id, $student_type, $class_roll_no, $REGISTERED_STUDENTS_EXAM_ROLL, $question_language, $pervious_degree_type, $last_passed_prof_roll, $local_address, $punishment_exam, $punishment_exam_month, $punishment_exam_year, $punishment_exam_roll, $punishment_name, $form_fill_up_date, $RESIDENTIAL_ROOM_NO)
	{
		try {

			$REGISTERED_STUDENTS_EXAM_ROLL = $this->fm->validation($REGISTERED_STUDENTS_EXAM_ROLL);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$class_roll = $this->fm->validation($class_roll_no);
			$question_language = $this->fm->validation($question_language);
			$last_passed_prof_roll = $this->fm->validation($last_passed_prof_roll);
			$local_address = $this->fm->validation($local_address);
			$punishment_exam = $this->fm->validation($punishment_exam);
			$punishment_exam_month = $this->fm->validation($punishment_exam_month);
			$punishment_exam_year = $this->fm->validation($punishment_exam_year);
			$punishment_exam_roll = $this->fm->validation($punishment_exam_roll);
			$punishment_name = $this->fm->validation($punishment_name);
			$form_fill_up_date = $this->fm->validation($form_fill_up_date);
			$EMAIL_ADDRESS = $this->fm->validation($EMAIL_ADDRESS);

			$REGISTERED_STUDENTS_EXAM_ROLL = mysqli_real_escape_string($this->db->link, $REGISTERED_STUDENTS_EXAM_ROLL);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$class_roll = mysqli_real_escape_string($this->db->link, $class_roll);
			$question_language = mysqli_real_escape_string($this->db->link, $question_language);
			//	$appeard_exam_year      = mysqli_real_escape_string($this->db->link, $appeard_exam_year);
			$last_passed_prof_roll = mysqli_real_escape_string($this->db->link, $last_passed_prof_roll);
			$local_address = mysqli_real_escape_string($this->db->link, $local_address);
			$punishment_exam = mysqli_real_escape_string($this->db->link, $punishment_exam);
			$punishment_exam_month = mysqli_real_escape_string($this->db->link, $punishment_exam_month);
			$punishment_exam_year = mysqli_real_escape_string($this->db->link, $punishment_exam_year);
			$punishment_exam_roll = mysqli_real_escape_string($this->db->link, $punishment_exam_roll);
			$punishment_name = mysqli_real_escape_string($this->db->link, $punishment_name);
			$form_fill_up_date = mysqli_real_escape_string($this->db->link, $form_fill_up_date);
			$RESIDENTIAL_ROOM_NO = mysqli_real_escape_string($this->db->link, $RESIDENTIAL_ROOM_NO);
			$EMAIL_ADDRESS = mysqli_real_escape_string($this->db->link, $EMAIL_ADDRESS);
			//$appeared_std           = mysqli_real_escape_string($this->db->link, $appeared_std);

			if (!empty($ADMITTED_STUDENT_ID) || !empty($exam_id) || !empty($student_type)) {

				$reg_insert_query = "UPDATE `registered_students`
			                             SET
			                             `REGISTERED_STUDENTS_EXAM_ROLL`  = '$REGISTERED_STUDENTS_EXAM_ROLL',
			                             `PREVIOUS_DEGREE_TYPE`  = '$pervious_degree_type',
			                             `REGISTERED_STUDENTS_TYPE` = '$student_type',
			                              CLASS_ROLL             = '$class_roll',
			                              QUESTION_LNANGUAGE     = '$question_language',
			                              last_passed_prof_roll  = '$last_passed_prof_roll',
			                              local_address          = '$local_address',
  				                          punishment_exam        = '$punishment_exam',
  				                          punishment_exam_month  = '$punishment_exam_month',
  				                          punishment_exam_year   = '$punishment_exam_year',
  				                          punishment_exam_roll   = '$punishment_exam_roll',
  				                          punishment_name        = '$punishment_name',
                                          form_fill_up_date      = '$form_fill_up_date',
                                          RESIDENTIAL_ROOM_NO      = '$RESIDENTIAL_ROOM_NO',
                                          EMAIL_ADDRESS      = '$EMAIL_ADDRESS'
			                              WHERE `ADMITTED_STUDENT_ID`= '$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID`= '$exam_id'";



				$result = $this->db->update($reg_insert_query);
				if ($result) {
					return $result;
				}
			}

		} catch (Exception $e) {

		}

	}

	public function update_Student_type_api($ADMITTED_STUDENT_ID, $exam_id, $student_type, $previous_degree)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$student_type = $this->fm->validation($student_type);
			$previous_degree = $this->fm->validation($previous_degree);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$previous_degree = mysqli_real_escape_string($this->db->link, $previous_degree);

			$reg_insert_query = "UPDATE `registered_students` SET `REGISTERED_STUDENTS_TYPE`=$student_type,`PREVIOUS_DEGREE_TYPE`=$previous_degree WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$exam_id";

			$result = $this->db->update($reg_insert_query);
			return $result;

		} catch (Exception $e) {

		}

	}

	public function feedback_save($ADMITTED_STUDENT_ID, $FEEDBACK)
	{

		try {

			$FEEDBACK = $this->fm->validation($FEEDBACK);
			$FEEDBACK = mysqli_real_escape_string($this->db->link, $FEEDBACK);

			$query = "INSERT INTO feedback(`ADMITTED_STUDENT_ID`, `FEEDBACK`) VALUES ($ADMITTED_STUDENT_ID,'$FEEDBACK')";
			$result = $this->db->insert($query);
			return $result;

		} catch (Exception $e) {

		}

	}

	public function update_previous_degree_type($ADMITTED_STUDENT_ID, $exam_id, $pervious_degree_type)
	{

		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$pervious_degree_type = $this->fm->validation($pervious_degree_type);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$pervious_degree_type = mysqli_real_escape_string($this->db->link, $pervious_degree_type);

			if (!empty($ADMITTED_STUDENT_ID) && !empty($exam_id)) {

				$reg_insert_query = "UPDATE `registered_students` SET `PREVIOUS_DEGREE_TYPE`=$pervious_degree_type WHERE `ADMITTED_STUDENT_ID` = $ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$exam_id";
				$result = $this->db->update($reg_insert_query);
				if ($result) {
					return $result;
				}

			}
		} catch (Exception $e) {

		}
	}


	public function update_student_address_name($ADMITTED_STUDENT_ID, $address, $mobile, $f_name, $m_name)
	{

		try {

			$address1 = mysqli_real_escape_string($this->db->link, $address);
			$mobile1 = mysqli_real_escape_string($this->db->link, $mobile);
			$f_name = mysqli_real_escape_string($this->db->link, $f_name);
			$m_name = mysqli_real_escape_string($this->db->link, $m_name);

			$query = "UPDATE `admitted_student` SET `ADMITTED_STUDENT_ADDRESS`='$address1',`ADMITTED_STUDENT_CONTACT_NO`='$mobile1',`ADMITTED_STUDENT_FATHERS_N`='$f_name',`ADMITTED_STUDENT_MOTHERS_N`='$m_name' WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID";
			$result = $this->db->update($query);
			if ($result) {
				return $result;
			}

		} catch (Exception $e) {

		}

	}

	public function update_student_address_name_update($ADMITTED_STUDENT_ID, $address, $mobile, $f_name, $m_name, $password)
	{

		try {

			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$mobile = mysqli_real_escape_string($this->db->link, $mobile);
			$f_name = mysqli_real_escape_string($this->db->link, $f_name);
			$m_name = mysqli_real_escape_string($this->db->link, $m_name);
			$password = mysqli_real_escape_string($this->db->link, $password);

			$result = $this->db->update_studen_info_up($ADMITTED_STUDENT_ID, $address, $mobile, $f_name, $m_name, $password);

			return $result;

		} catch (Exception $e) {

		}
	}

	public function studentSelectedCourseByIdDelete($exam_id, $reg_student_id)
	{

		try {
			$exam_id = $this->fm->validation($exam_id);
			$reg_student_id = $this->fm->validation($reg_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$reg_student_id = mysqli_real_escape_string($this->db->link, $reg_student_id);

			if (!empty($exam_id) || !empty($reg_student_id)) {
				$delete_query = "DELETE FROM `selected_courses` WHERE `REGISTERED_EXAM_ID` ='$exam_id' AND `REGISTERED_STUDENTS_ID`='$reg_student_id'";
				$result = $this->db->delete($delete_query);
				return $result;
			}

		} catch (Exception $e) {

		}

	}
	public function studentCourseCodeTitleIdShow($code)
	{

		try {
			$code = mysqli_real_escape_string($this->db->link, $code);

			$code_id_query = "SELECT `COURSE_CODE_TITLE_ID` FROM `course_code_title` WHERE `COURSE_CODE_TITLE_CODE`='$code' LIMIT 1";
			$result = $this->db->select($code_id_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function studentCourseCodeTitleIdShow1($code, $COURSE_YEAR_ID)
	{
		try {
			$code = mysqli_real_escape_string($this->db->link, $code);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);

			$code_id_query = "SELECT `COURSE_CODE_TITLE_ID` FROM `course_code_title` WHERE `COURSE_CODE_TITLE_CODE`='$code' AND COURSE_YEAR_ID=$COURSE_YEAR_ID LIMIT 1";
			$result = $this->db->select($code_id_query);
			return $result;
		} catch (Exception $e) {

		}
	}


	public function studentCourseCodeTitleIdShow_UP($code, $title, $COURSE_YEAR_ID, $SUBJECTS_ID)
	{

		try {
			$code = $this->fm->validation($code);
			$title = $this->fm->validation($title);
			$COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			#$credit         = $this->fm->validation($credit);

			$code = mysqli_real_escape_string($this->db->link, $code);
			$title = mysqli_real_escape_string($this->db->link, $title);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			#$credit         = mysqli_real_escape_string($this->db->link, $credit);

			//$code_id_query="SELECT `COURSE_CODE_TITLE_ID` FROM `course_code_title` WHERE `COURSE_CODE_TITLE_CODE`='$code' AND   `COURSE_YEAR_ID`=$COURSE_YEAR_ID AND SUBJECTS_ID=$SUBJECTS_ID AND `COURSE_CODE_TITLE` LIKE '%$title%' LIMIT 1";
			$code_id_query = "SELECT `COURSE_CODE_TITLE_ID` FROM `course_code_title` WHERE `COURSE_CODE_TITLE_CODE`='$code' AND   `COURSE_YEAR_ID`=$COURSE_YEAR_ID AND SUBJECTS_ID=$SUBJECTS_ID AND `COURSE_CODE_TITLE`='$title' LIMIT 1";
			//	exit;
			$result = $this->db->select($code_id_query);
			return $result;

		} catch (Exception $e) {

		}
	}


	public function get_student_type($admitted_student_id, $exam_id)
	{

		try {
			$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$code_id_query = "SELECT `REGISTERED_STUDENTS_TYPE`,`REGISTERED_STUDENTS_ID`,`REGISTERED_STUDENTS_COLLEGE_VERIFY` FROM `registered_students` WHERE `REGISTERED_EXAM_ID`= '$exam_id' AND `ADMITTED_STUDENT_ID`='$admitted_student_id' LIMIT 1";
			$result = $this->db->select($code_id_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function get_previous_gegree_type($admitted_student_id, $exam_id)
	{
		try {
			$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$code_id_query = "SELECT `PREVIOUS_DEGREE_TYPE`,`REGISTERED_STUDENTS_TYPE`,`REGISTERED_STUDENTS_ID`,`REGISTERED_STUDENTS_COLLEGE_VERIFY`,REGISTERED_STUDENTS_STATUS FROM `registered_students` WHERE `REGISTERED_EXAM_ID`='$exam_id' AND `ADMITTED_STUDENT_ID`='$admitted_student_id'";
			$result = $this->db->select($code_id_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function selectedStudentCoursesByIdshow($reg_student_id, $exam_id, $COURSE_CODE_TITLE_ID)
	{

		try {

			$reg_student_id = $this->fm->validation($reg_student_id);
			$exam_id = $this->fm->validation($exam_id);
			$COURSE_CODE_TITLE_ID = $this->fm->validation($COURSE_CODE_TITLE_ID);
			$reg_student_id = mysqli_real_escape_string($this->db->link, $reg_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$COURSE_CODE_TITLE_ID = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);

			$insert_query = "INSERT INTO `selected_courses`(`REGISTERED_STUDENTS_ID`,`REGISTERED_EXAM_ID`,`COURSE_CODE_TITLE_ID`) VALUES ('$reg_student_id','$exam_id','$COURSE_CODE_TITLE_ID')";
			$result = $this->db->insert($insert_query);
			if ($result) {
				return $result;
			}

		} catch (Exception $e) {

		}
	}

	public function sudentsInformationShowByStudentId($ADMITTED_STUDENT_ID)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$query = "SELECT * FROM `students_view` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID'";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function get_StudentInfo_By_Reg($STUSENT_REGISTRATION_NO, $exam_id)
	{

		try {
			$STUSENT_REGISTRATION_NO = $this->fm->validation($STUSENT_REGISTRATION_NO);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$sql = "SELECT programs.SUBJECTS_ID AS S_SUBJECTS_ID FROM programs JOIN course_year ON programs.SUBJECTS_ID = course_year.SUBJECTS_ID JOIN registered_exam ON registered_exam.COURSE_YEAR_ID = course_year.COURSE_YEAR_ID WHERE registered_exam.REGISTERED_EXAM_ID = '$exam_id'";
			$data = $this->db->select($sql);
			if ($data) {
				$datarow = $data->fetch_assoc();
				$s_program = $datarow['S_SUBJECTS_ID'];
				$query = "SELECT * FROM `students_view` WHERE `ADMITTED_STUDENT_REG_NO`='$STUSENT_REGISTRATION_NO' AND SUBJECTS_ID = '$s_program'";
				$result = $this->db->select($query);
				return $result;
			}
		} catch (Exception $e) {

		}
	}

	public function student_type($exam_id, $ADMITTED_STUDENT_ID)
	{

		try {
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$query = "SELECT `REGISTERED_STUDENTS_TYPE` FROM `registered_students` WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$exam_id";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}

	}

	public function insert_students_for_modify($exam_id, $admitted_student_id)
	{

		try {

			$exam_id = $this->fm->validation($exam_id);
			$admitted_student_id = $this->fm->validation($admitted_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);

			$sql = "UPDATE `registered_students` SET REGISTERED_STUDENTS_STATUS=0,MODIFICATION_COUNT=MODIFICATION_COUNT+1, REGISTERED_STUDENTS_MOFIFICATION=1 WHERE REGISTERED_EXAM_ID=$exam_id AND ADMITTED_STUDENT_ID = $admitted_student_id AND `REGISTERED_STUDENTS_COLLEGE_VERIFY`=0";

			$result = $this->db->update($sql);
			return $result;

		} catch (Exception $e) {

		}

	}


	public function count_total_edit_form($exam_id, $admitted_student_id)
	{

		try {

			$exam_id = $this->fm->validation($exam_id);
			$admitted_student_id = $this->fm->validation($admitted_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);
			$query = "SELECT `MODIFICATION_COUNT` FROM `registered_students` WHERE `ADMITTED_STUDENT_ID`=$admitted_student_id AND `REGISTERED_EXAM_ID` =$exam_id";

			$result = $this->db->select($query);
			$count_value = 3;

			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$count_value = $row["MODIFICATION_COUNT"];
				}
			}

			return $count_value;
		} catch (Exception $e) {

		}

	}


	public function studentCourseYearTitleByExamId($exam_id)
	{

		try {
			$exam_id = $this->fm->validation($exam_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			if (!empty($exam_id)) {
				$exam_details_query1 = "SELECT `COURSE_YEAR_TITLE`,`REGISTERED_EXAM_YEAR`,`COURSE_YEAR_ID`,`SUBJECTS_TITLE_EN`,`STUDENTS_RE_EDIT`,`REGISTERED_EXAM_STATUS`,`LAST_DATE`,`EXAM_NAME` FROM `exam_view` WHERE `REGISTERED_EXAM_ID`='$exam_id' GROUP BY REGISTERED_EXAM_ID";

				//               echo  $exam_details_query1;
				$result = $this->db->select($exam_details_query1);
				return $result;
			}
		} catch (Exception $e) {

		}
	}

	public function studentSelectedCourseViewById($ADMITTED_STUDENT_ID, $exam_id)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$get_selection_query = "SELECT * FROM `selected_course_view` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID`='$exam_id'";
			$result = $this->db->select($get_selection_query);
			return $result;
		} catch (Exception $e) {

		}
	}


	public function studentSelectedCourseViewById_update($ADMITTED_STUDENT_ID, $reg_student_id, $exam_id)
	{

		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$reg_student_id = $this->fm->validation($reg_student_id);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$reg_student_id = mysqli_real_escape_string($this->db->link, $reg_student_id);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$get_selection_query = "SELECT course_code_title.COURSE_CODE_TITLE_CODE,course_code_title.COURSE_CODE_TITLE,course_code_title.COURSE_CODE_TITLE_CREDIT,course_code_title.COURSE_CODE_TITLE_TYPE
		FROM `selected_courses`
		JOIN course_code_title ON course_code_title.COURSE_CODE_TITLE_ID=selected_courses.COURSE_CODE_TITLE_ID
		WHERE selected_courses.REGISTERED_STUDENTS_ID = '$reg_student_id' AND selected_courses.REGISTERED_EXAM_ID = '$exam_id'";
			$result = $this->db->select($get_selection_query);
			return $result;
		} catch (Exception $e) {

		}
	}




	public function studentSelectedCourseViewById1($ADMITTED_STUDENT_ID, $exam_id, $COURSE_YEAR_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

			$get_selection_query = "SELECT * FROM `selected_course_view` WHERE `ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID`='$exam_id' AND COURSE_YEAR_ID='$COURSE_YEAR_ID'";
			$result = $this->db->select($get_selection_query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function studentFinalRegisteredUpdateByid($ADMITTED_STUDENT_ID, $exam_id, $currentdate, $student_roll)
	{
		try {

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$currentdate = $this->fm->validation($currentdate);
			$exam_id = $this->fm->validation($exam_id);
			$student_roll = $this->fm->validation($student_roll);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$currentdate = mysqli_real_escape_string($this->db->link, $currentdate);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$student_roll = mysqli_real_escape_string($this->db->link, $student_roll);

			//REGISTERED_STUDENTS_EXAM_ROLL=$student_roll,
			$final_submit_query = "UPDATE `registered_students` SET `REGISTERED_STUDENTS_FORM_FILL_DATE`='$currentdate',`REGISTERED_STUDENTS_STATUS`=1,`ADMISSION_STATUS`=1,`PAYMENT_STATUS`=1,`ACCOUNTS_VERIFY`=1  WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$exam_id";
			$result = $this->db->update($final_submit_query);
			return $result;
		} catch (Exception $e) {

		}

	}
	public function studentAdmittedCardPrint($ADMITTED_STUDENT_ID, $ADMITTED_STUDENT_REG_NO)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_REG_NO = $this->fm->validation($ADMITTED_STUDENT_REG_NO);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_REG_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_REG_NO);

			$query = "SELECT students_view.*, registered_students.REGISTERED_STUDENTS_EXAM_ROLL, registered_students.REGISTERED_STUDENTS_TYPE FROM students_view INNER JOIN registered_students ON students_view.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID   WHERE students_view.ADMITTED_STUDENT_ID ='$ADMITTED_STUDENT_ID' AND students_view.ADMITTED_STUDENT_REG_NO = '$ADMITTED_STUDENT_REG_NO'";
			$result = $this->db->select($query);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function getSystemStatus()
	{
		$sql = "SELECT * FROM system_settings WHERE id = 1 ORDER BY id DESC LIMIT 1";
		$result = $this->db->select($sql);
		#mysqli_close($this->db->link);
		return $result;
	}

	public function credentilas_check_API($ADMITTED_STUDENT_ID, $PASSWORD)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$PASSWORD = mysqli_real_escape_string($this->db->link, $PASSWORD);

			$sql = "SELECT * FROM `admitted_student` WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `PASSWORD`='$PASSWORD' AND `ACCOUNT_CREATE_STATUS`=1";
			$result = $this->db->select($sql);
			#mysqli_close($this->db->link);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function confirm_submit_API($ADMITTED_STUDENT_ID, $EXAM_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
			$sql = "UPDATE `registered_students` SET `REGISTERED_STUDENTS_STATUS`=1 WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$EXAM_ID";
			$result = $this->db->update($sql);
			//mysqli_close($this->db->link);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function confirm_Edit_submit_API($ADMITTED_STUDENT_ID, $EXAM_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$EXAM_ID = $this->fm->validation($EXAM_ID);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);

			$sql = "UPDATE `registered_students` SET `REGISTERED_STUDENTS_STATUS`=0,MODIFICATION_COUNT=MODIFICATION_COUNT+1,REGISTERED_STUDENTS_MOFIFICATION=1 WHERE `ADMITTED_STUDENT_ID`=$ADMITTED_STUDENT_ID AND `REGISTERED_EXAM_ID`=$EXAM_ID";
			$result = $this->db->update($sql);
			//	mysqli_close($this->db->link);
			return $result;
		} catch (Exception $e) {

		}

	}
	public function getAllSession()
	{
		try {
			$sql = "SELECT * FROM session WHERE SESSION_STATUS = 1 ORDER BY SESSION_NAME DESC";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}
	public function getAllProgram()
	{
		$sql = "SELECT * FROM programs WHERE PROGRAMS_STATUS = 1";
		$result = $this->db->select($sql);
		return $result;
	}

	public function getAllDepartment()
	{
		$sql = "SELECT * FROM subjects WHERE SUBJECTS_STATUS = 1";
		$result = $this->db->select($sql);
		return $result;
	}

	public function regeistrationSendRequestNew($registrationno, $SUBJECTS_ID, $session, $REGISTERED_COLLEGE_ID, $hall_id, $name_bn, $name_en, $dob, $last_enroll_session, $ssoticket)
	{

		try {

			$registrationno = $this->fm->validation($registrationno);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$session = $this->fm->validation($session);
			$REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
			$hall_id = $this->fm->validation($hall_id);
			$name_bn = $this->fm->validation($name_bn);
			$name_en = $this->fm->validation($name_en);
			$dob = $this->fm->validation($dob);
			$last_enroll_session = $this->fm->validation($last_enroll_session);
			$ssoticket = $this->fm->validation($ssoticket);

			$registrationno = mysqli_real_escape_string($this->db->link, $registrationno);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$session = mysqli_real_escape_string($this->db->link, $session);
			$REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
			$hall_id = mysqli_real_escape_string($this->db->link, $hall_id);
			$name_bn = mysqli_real_escape_string($this->db->link, $name_bn);
			$name_en = mysqli_real_escape_string($this->db->link, $name_en);
			$dob = mysqli_real_escape_string($this->db->link, $dob);
			$last_enroll_session = mysqli_real_escape_string($this->db->link, $last_enroll_session);
			$ssoticket = mysqli_real_escape_string($this->db->link, $ssoticket);

			if (!empty($registrationno) && !empty($SUBJECTS_ID) && !empty($session) && !empty($REGISTERED_COLLEGE_ID)) {

				$session_name = '';
				//  $SUBJECTS_ID = '';

				$sql = "SELECT * FROM session WHERE SESSION_ID = '$session'";
				$sresult = $this->db->select($sql);
				if ($sresult) {
					while ($sdata = $sresult->fetch_assoc()) {
						$session_name = $sdata['SESSION_NAME'];

					}
				}

				$sql = "SELECT * FROM subjects WHERE SUBJECTS_ID = '$SUBJECTS_ID' LIMIT 1";
				$sresult = $this->db->select($sql);
				if ($sresult) {
					while ($sdata = $sresult->fetch_assoc()) {
						$SUBJECTS_TITLE = $sdata['SUBJECTS_TITLE_EN'];

					}
				}



				$sqlc = "SELECT * FROM admitted_student WHERE REGISTERED_COLLEGE_ID = '$REGISTERED_COLLEGE_ID' AND SUBJECTS_ID = '$SUBJECTS_ID' AND ADMITTED_STUDENT_REG_NO = '$registrationno' AND SESSION_ID = '$session'";
				$cresult = $this->db->select($sqlc);
				if ($cresult != false) {

					echo "<div class='alert alert-danger'> Allready Created</div>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
				} else {

					$output = "<table class='table table-striped table-hovered table-bordered'><thead><tr><th>Registration No:</th><td>" . $registrationno . "</td></tr><tr><th>Department Name :</th><td>" . $SUBJECTS_TITLE . "</td></tr><tr><th>Session :</th><td>" . $session_name . "</td></tr></thead></table>";

					$output .= "<div id='message'></div><form action='' method='post'  enctype='multipart/form-data'>
           	        <input type='hidden' id='registrationno' value='" . $registrationno . "'/>
           	        <input type='hidden' id='SUBJECTS_ID' value='" . $SUBJECTS_ID . "'/>
           	        <input type='hidden' id='session_id' value='" . $session . "'/>
           	        <input type='hidden' id='REGISTERED_COLLEGE_ID' value='" . $REGISTERED_COLLEGE_ID . "'/>
           	        <input type='hidden' id='HALL' value='" . $hall_id . "'/>
           	        <input type='hidden' id='student_name_en' value='" . $name_en . "'/>
           	        <input type='hidden' id='student_name' value='" . $name_bn . "'/>
           	        <input type='hidden' id='student_dob' value='" . $dob . "'/>
           	        <input type='hidden' id='last_enroll_session' value='" . $last_enroll_session . "'/>
           	        <input type='hidden' id='ssoticket' value='" . $ssoticket . "'/>


           	        <div class='row'><div class='preview_image'>


           	        <div id='image_preview'>

           	        <img src='assets/images/empty_user.svg' title='Profile Picture is Required' id='profile_pic' width='150px' height='150px' >

           	        </div>
				    <input type='file' id='student_image' class='file_cooser_style' style='display:none;' accept='image/*'>
				    <p><smail style='color:red;'> Upload professional Image.  Image size should be width:150px * height:150px </smail></p>
				    </div></div>

					<div class='row'>
				    	<div class='form-group col-lg-6 col-sm-12'>
				    		<label for='blood_group'> Blood Group <span style='color:red;'> * </span></label>
				    		<select name='blood_group' class='form-control' id='blood_group' >
								<option value=''>N/A</option>
								<option value='1'>A+</option>
								<option value='2'>A-</option>
								<option value='3'>B+</option>
								<option value='4'>B-</option>
								<option value='5'>O+</option>
								<option value='6'>O-</option>
								<option value='7'>AB+</option>
								<option value='8'>AB-</option>

							</select>

				    	</div>
				    </div>

      				<div class='row'>
          			<div class='form-group col-lg-6 col-sm-12'><label for='fathers_name'>Father's Name <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' title='Father's Name is Required' id='fathers_name' placeholder='Enter your Fathers Name'>
				    <div class='invalid-feedback' id='err_fathers_n'> Father's Name is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='mothers_name'>Mother's Name. <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' title='Mother's Name is Required' id='mothers_name' placeholder='Enter your Mothers Name'>
				    <div class='invalid-feedback' id='err_mothers_n'> Mother's Name is Required! </div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='phone_number'> Phone. <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' onkeypress='return isNumberKey(event)' title='Phone Number is Required' id='phone_number' placeholder='Enter Phone Number'>
				    <div class='invalid-feedback' id='err_phone'> Phone Number is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='parents_income'> Parents/Guardian Income <span style='color:red;'> * </span> </label>
                     <input type='text' class='form-control' title='Parents Income' id='parents_income' placeholder='Enter Parents/Guardian Income'><div class='invalid-feedback' id='err_parents_income'> This field is required! </div></div></div><div class='row'>
                     <div class='form-group col-lg-6 col-sm-12'><label for='nationality'> Nationality <span style='color:red;'> * </span></label>
                     <input type='text' class='form-control' title='Nationality' id='nationality' placeholder='Nationality'><div class='invalid-feedback' id='err_nationality'> Nationality is Required! </div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='religion'> Religion <span style='color:red;'> * </span></label>
                     <input type='text' class='form-control' title='Religion' id='religion' placeholder='Religion'><div class='invalid-feedback' id='err_religion'> Religion is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='caste_sect'> Caste/Sect </label>
                     <input type='text' class='form-control' title='Caste/Sect' id='caste_sect' placeholder='Enter Caste/Sect'></div></div><div class='row'><div class='form-group col-lg-6 col-sm-6'><label for='gender'> Gender <span style='color:red;'> * </span></label>
                     <select class='form-control' name='gender' id='gender'>
                      <option value='' style='display: none;'> Select Gender </option>
                      <option value='Male'> Male </option>
                      <option value='Female'> Female </option>
                     </select>
                     <div class='invalid-feedback' id='err_gender'> Gender is Required! </div></div>
                     <div class='form-group col-lg-6 col-sm-6'><label for='GURDIAN_NAME'> GUARDIAN NAME <span style='color:red;'> * </span></label>
                     <input type='text' id='GURDIAN_NAME' name='GURDIAN_NAME' class='form-control'>
                     <div class='invalid-feedback' id='err_gurdian_name'> Guardian Name  is Required! </div></div>
                     </div><div style='padding:3px;border:2px solid #ccc;border-radius: 2px;margin-bottom:8px;'><center><smail style='color:red;'> <b><u> Present Address </u></b></smail></center>
           	        <div class='row'>
           	        	<div class='form-group col-lg-6 col-sm-12'>
           	        		<label for='present_house_road'> Village/Road. <span style='color:red;'> * </span></label>
				    		<input type='text' title='This is Required' class='form-control' id='present_house_road' placeholder='Enter Village/Road'>
				    		<div class='invalid-feedback' id='err_present_house_road'> This is Required! </div>
				    	</div>
					    <div class='form-group col-lg-6 col-sm-12'>
					    	<label for='present_house_no'> House No. <span style='color:red;'> * </span></label>
					    	<input type='text' title='This is Required' class='form-control' id='present_house_no' placeholder='House No'>
					    </div>
					    <div class='invalid-feedback' id='err_present_house_no'> This is Required! </div>
				    </div>
					<div class='row'>
				    	<div class='form-group col-lg-6 col-sm-12'>
				    		<label for='present_post_office'> Post Office. <span style='color:red;'> * </span></label>
				    		<input type='text' title=' Post Office is Required' class='form-control' id='present_post_office' placeholder='Enter Post Office'>
				    		<div class='invalid-feedback' id='err_present_post_office'> Post Office is Required! </div>
				    	</div>
				    	<div class='form-group col-lg-6 col-sm-12'>
				    		<label for='present_post_code'> Post Code. <span style='color:red;'> * </span></label>
				    		<input type='text' title='Post Code is Required' class='form-control' id='present_post_code' placeholder='Enter Post Code'>
				    		<div class='invalid-feedback' id='err_present_post_code'> Post Code is Required! </div>
				    	</div>
				    </div>
				    <div class='row'>
				    	<div class='form-group col-lg-6 col-sm-12'>
				    		<label for='present_upa_zilla'> Upa Zilla. <span style='color:red;'> * </span></label>
				    		<input type='text' title='Upa Zilla is Required' class='form-control' id='present_upa_zilla' placeholder='Enter Upa Zilla'>
				    		<div class='invalid-feedback' id='err_upa_zilla'> Upa Zilla is Required! </div>
				    	</div>
				    	<div class='form-group col-lg-6 col-sm-12'>
				    		<label for='present_district'> District. <span style='color:red;'> * </span></label>
				    		<input type='text' title='District is Required' class='form-control' id='present_district' placeholder='Enter District'>
				    		<div class='invalid-feedback' id='err_present_district'> District is Required! </div>
				    	</div>
				    </div>
				    <center><div class='form-group'>
						<label for='same_as'> Same as </label>
						<input onclick='is_same_check()' type='checkbox'  id='same_as'>
				    </div></center>
					<div style='padding:3px;border:2px solid #ccc;border-radius: 2px;margin-bottom:8px;'>
						<center><smail style='color:red;'> <b><u> Permanent Address </u></b></smail></center>
           	        	<div class='row'>
           	        		<div class='form-group col-lg-6 col-sm-12'>
           	        			<label for='village'>  Village/Road. <span style='color:red;'> * </span></label>
				    			<input type='text' title='This is Required' class='form-control' id='village' placeholder='Enter Village/Road'>
				    			<div class='invalid-feedback' id='err_village'> This is Required! </div>
				    		</div>
           	        		<div class='form-group col-lg-6 col-sm-12'>
           	        			<label for='house_no'>  House No. <span style='color:red;'> * </span></label>
				    			<input type='text' title='This is Required' class='form-control' id='house_no' placeholder='House No'>
				    			<div class='invalid-feedback' id='err_house_no'> This is Required! </div>
				    		</div>
				    	</div>
				    	<div class='row'>
				    		<div class='form-group col-lg-6 col-sm-12'>
				    			<label for='post_office'> Post Office. <span style='color:red;'> * </span></label>
				    			<input type='text' title=' Post Office is Required' class='form-control' id='post_office' placeholder='Enter Post Office'>
				    			<div class='invalid-feedback' id='err_post_office'> Post Office is Required! </div>
				    		</div>

				    		<div class='form-group col-lg-6 col-sm-12'>
				    			<label for='post_office'> Post Code. <span style='color:red;'> * </span></label>
				    			<input type='text' title=' Post Code is Required' class='form-control' id='post_code' placeholder='Enter Post Code'>
				    			<div class='invalid-feedback' id='err_post_code'> Post Office is Required! </div>
				    		</div>

				    	</div>
				    	<div class='row'>
							<div class='form-group col-lg-6 col-sm-12'>
								<label for='upa_zilla'> Upa Zilla. <span style='color:red;'> * </span></label>
				    			<input type='text' title='Upa Zilla is Required' class='form-control' id='upa_zilla' placeholder='Enter Upa Zilla'>
				   				<div class='invalid-feedback' id='err_upa_zilla'> Upa Zilla is Required! </div>
				   			</div>
							<div class='form-group col-lg-6 col-sm-12'>
								<label for='district'> District. <span style='color:red;'> * </span></label>
			    				<input type='text' title='District is Required' class='form-control' id='district' placeholder='Enter District'>
		    					<div class='invalid-feedback' id='err_district'> District is Required! </div>
		    				</div>
				   		</div>
				   	</div>

				    	<div class='row justify-content-center'>
				    		<button type='button' class=' col-lg-8 col-sm-12 btn btn-primary btn-block' id='update_button'>Submit
				    		<img style='display:none;' id='loading_signup' src='s_images/ajax-loader.webp' height='20px'></button>
				    	</div>
				    </form>";
					echo $output;

				}
			} else {
				echo "<div class='alert alert-danger'> * Field should not be Empty!.</div>";
				echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
			}

		} catch (Exception $e) {

		}
	}

	public function updateNonCollogeateFee($exam_id, $admitted_student_id)
	{

		$exam_id = $this->fm->validation($exam_id);
		$admitted_student_id = $this->fm->validation($admitted_student_id);
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);

		$query = "UPDATE `registered_students` SET  `fine`='1', fine_online_paid='YES' WHERE `ADMITTED_STUDENT_ID`='$admitted_student_id' AND `REGISTERED_EXAM_ID`='$exam_id'";


		echo $query;
		$result = $this->db->update($query);

		return $result;


	}
	public function regeistrationSendRequest($registrationno, $program_name, $session)
	{

		try {

			$registrationno = $this->fm->validation($registrationno);
			$program_name = $this->fm->validation($program_name);
			$session = $this->fm->validation($session);
			$registrationno = mysqli_real_escape_string($this->db->link, $registrationno);
			$program_name = mysqli_real_escape_string($this->db->link, $program_name);
			$session = mysqli_real_escape_string($this->db->link, $session);

			$csql = "SELECT admitted_student.ADMITTED_STUDENT_REG_NO,admitted_student.SESSION_ID,admitted_student.SUBJECTS_ID,subjects.SUBJECTS_ID FROM admitted_student INNER JOIN subjects ON admitted_student.SUBJECTS_ID = subjects.SUBJECTS_ID WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$registrationno' AND admitted_student.SESSION_ID = '$session' AND subjects.SUBJECTS_ID = '$program_name'";
			$cresult = $this->db->select($csql);
			if ($cresult) {

				$cusql = "SELECT admitted_student.ADMITTED_STUDENT_ID,admitted_student.ADMITTED_STUDENT_REG_NO,admitted_student.SESSION_ID,admitted_student.SUBJECTS_ID,admitted_student.image_dir,subjects.SUBJECTS_ID,admitted_student.ADMITTED_STUDENT_NAME,subjects.SUBJECTS_TITLE FROM admitted_student INNER JOIN subjects ON admitted_student.SUBJECTS_ID = subjects.SUBJECTS_ID WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$registrationno' AND admitted_student.SESSION_ID = '$session' AND subjects.REGISTERED_COLLEGE_ID = '$REGISTERED_COLLEGE_ID' AND admitted_student.ACCOUNT_CREATE_STATUS = 0";
				$curesult = $this->db->select($cusql);
				if ($curesult) {
					while ($show = $curesult->fetch_assoc()) {

						$output = "<table class='table table-striped table-hovered table-bordered'><thead><tr><th>Name:</th><td>" . $show['ADMITTED_STUDENT_NAME'] . "</td></tr><tr><th>Registration No:</th><td>" . $show['ADMITTED_STUDENT_REG_NO'] . "</td></tr><tr><th>Subject Name:</th><td>" . $show['SUBJECTS_TITLE'] . "</td></tr></thead></table>
				   ";

						$ADMITTED_STUDENT_ID = $show['ADMITTED_STUDENT_ID'];
						$ADMITTED_STUDENT_REG_NO = $show['ADMITTED_STUDENT_REG_NO'];
						$SUBJECTS_ID = $show['SUBJECTS_ID'];
						$SESSION_ID = $show['SESSION_ID'];
						$image_dir = $show['image_dir'];


						$profile_img = "students/" . $image_dir . "/" . $ADMITTED_STUDENT_REG_NO . $SESSION_ID . $SUBJECTS_ID;

						if ($files = glob($profile_img . "/*")) {
							$profile_img = $files[0];
						} else {

							$profile_img = "s_images/user.png";

						}
					}


					$output .= "<div id='message'></div><form action='' method='post' enctype='multipart/form-data'>
           	        <input type='hidden' id='addmitted_sid' value='" . $ADMITTED_STUDENT_ID . "'/>
           	        <div class='row'><div class='preview_image'>
           	        <div id='image_preview'><img src='" . $profile_img . "' title='Profile Picture is Required' id='profile_pic'></div>
				    <input type='file' id='student_image' class='file_cooser_style' style='display:none;' accept='image/*'>
				    <p><smail style='color:red;'> Image size should be 150px * 150px </smail></p>
				    </div></div>
                    <div class='clearfix'></div>
                    <div class='row'>
					<div class='form-group col-lg-12 col-sm-12'><label for='student_name'> Name (বাংলা) <span style='color:red;'> * </span></label>
					<input type='text' class='form-control' title='Name is Required' id='student_name' placeholder='Enter your Name'>
					<div class='invalid-feedback' id='err_student_name'>Name is Required! </div></div></div>
                    <div class='row'>
                    <div class='form-group col-lg-6 col-sm-12'><label for='fathers_name'>Father's Name <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' title='Father's Name is Required' id='fathers_name' placeholder='Enter your Fathers Name'>
				    <div class='invalid-feedback' id='err_fathers_n'> Father's Name is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='mothers_name'>Mother's Name. <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' title='Mother's Name is Required' id='mothers_name' placeholder='Enter your Mothers Name'>
				    <div class='invalid-feedback' id='err_mothers_n'> Mother's Name is Required! </div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='phone_number'>Phone. <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' onkeypress='return isNumberKey(event)' title='Phone Number is Required' id='phone_number' placeholder='Enter Phone Number'>
				    <div class='invalid-feedback' id='err_phone'> Phone Number is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='parents_income'>Parents/Guardian Income</label>
                     <input type='text' class='form-control' title='Parents Income' id='parents_income' placeholder='Enter Parents/Guardian Income'></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='student_dob'> Date of Birth <span style='color:red;'> * </span></label>
                     <input type='date' class='form-control' title='Date of Birth' id='student_dob' placeholder='Enter Date of Birth'><div class='invalid-feedback' id='err_sdob'> Date of Birth is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='nationality'> Nationality <span style='color:red;'> * </span></label>
                     <input type='text' class='form-control' title='Nationality' id='nationality' placeholder='Nationality'><div class='invalid-feedback' id='err_nationality'> Nationality is Required! </div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='religion'> Religion <span style='color:red;'> * </span></label>
                     <input type='text' class='form-control' title='Religion' id='religion' placeholder='Religion'><div class='invalid-feedback' id='err_religion'> Religion is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='caste_sect'> Caste/Sect </label>
                     <input type='text' class='form-control' title='Caste/Sect' id='caste_sect' placeholder='Enter Caste/Sect'></div></div><div style='padding:3px;border:2px solid #ccc;border-radius: 2px;margin-bottom:8px;'><center><smail style='color:red;'> <b><u> Permanent Address </u></b></smail></center>
           	        <div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='village'> Village. <span style='color:red;'> * </span></label>
				    <input type='text' title='Village is Required' class='form-control' id='village' placeholder='Enter Village'>
				    <div class='invalid-feedback' id='err_village'> Village is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='post_office'> Post Office. <span style='color:red;'> * </span></label>
				    <input type='text' title=' Post Office is Required' class='form-control' id='post_office' placeholder='Enter  Post Office'>
				    <div class='invalid-feedback' id='err_post_office'> Post Office is Required! </div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'></div><div class='form-group col-lg-6 col-sm-12'><label for='upa_zilla'> Upa Zilla. <span style='color:red;'> * </span></label>
				    <input type='text' title='Upa Zilla is Required' class='form-control' id='upa_zilla' placeholder='Enter Upa Zilla'>
				    <div class='invalid-feedback' id='err_upa_zilla'> Upa Zilla is Required! </div></div></div><div class='row'><div class='form-group col-lg-12 col-sm-12'><label for='district'> District. <span style='color:red;'> * </span></label>
				    <input type='text' title='District is Required' class='form-control' id='district' placeholder='Enter District'>
				    <div class='invalid-feedback' id='err_district'> District is Required! </div></div></div></div><div class='row'><div class='form-group col-lg-6 col-sm-12'><label for='password'> Password. <span style='color:red;'> * ( Only allow alphanumeric characters [a-z and 0-9] ) </span></label>
				    <input type='text' class='form-control' title='Password is Required' id='password' onkeypress='return /^[0-9a-zA-Z]+$/i.test(event.key)' placeholder='Enter Password'>
				    <div class='invalid-feedback' id='err_password'> Password is Required! </div></div><div class='form-group col-lg-6 col-sm-12'><label for='confirm_password'>Confirm Password. <span style='color:red;'> * </span></label>
				    <input type='text' class='form-control' title='Confirm Password is Required' id='confirm_password' onkeypress='return /^[0-9a-zA-Z]+$/i.test(event.key)' placeholder='Enter Confirm Password'>
				    <div class='invalid-feedback' id='err_cpassword'>Confirm Password is Required! </div></div></div><div class='row justify-content-center'><button type='button' class=' col-lg-8 col-sm-12 btn btn-primary btn-block' id='update_button'>Submit <img style='display:none;' id='loading_signup' src='s_images/ajax-loader.gif' height='20px'></button></div></form>";
					echo $output;
				} else {
					echo "<div class='alert alert-danger'> Allready Created</div>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
				}
			} else {
				echo "<div class='alert alert-danger'>Wrong Information Input</div>";
				echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
			}

		} catch (Exception $e) {

		}
	}

	public function studentforgotpassSendRequest($registrationno, $dept_name, $session)
	{

		try {

			$registrationno = $this->fm->validation($registrationno);
			$dept_name = $this->fm->validation($dept_name);
			$session = $this->fm->validation($session);
			$registrationno = mysqli_real_escape_string($this->db->link, $registrationno);
			$dept_name = mysqli_real_escape_string($this->db->link, $dept_name);
			$session = mysqli_real_escape_string($this->db->link, $session);

			$csql = "SELECT admitted_student.ADMITTED_STUDENT_ID AS sid,admitted_student.ADMITTED_STUDENT_REG_NO,admitted_student.SESSION_ID,admitted_student.SUBJECTS_ID,admitted_student.ACCOUNT_CREATE_STATUS AS created_account,admitted_student.count_sent_sms AS count_sms,admitted_student.ADMITTED_STUDENT_CONTACT_NO AS phone,admitted_student.PASSWORD AS passs,subjects.SUBJECTS_ID FROM admitted_student INNER JOIN subjects ON admitted_student.SUBJECTS_ID = subjects.SUBJECTS_ID WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$registrationno' AND admitted_student.SESSION_ID = '$session' AND subjects.SUBJECTS_ID = '$dept_name'";
			$cresult = $this->db->select($csql);
			if ($cresult) {
				while ($rows = $cresult->fetch_assoc()) {
					$sid = $rows['sid'];
					$regno = $rows['ADMITTED_STUDENT_REG_NO'];
					$accountstatus = $rows['created_account'];
					$count_sent_sms = $rows['count_sms'];
					$phon = $rows['phone'];
					$pass = $rows['passs'];

					if ($accountstatus != 0) {

						if ($count_sent_sms <= 9) {

							$phone = "88" . $phon;

							$msg = "DHAKA%20UNIVERSITY%20CONSTITUENT%20COLLEGE%20Reg%20No:%20" . $regno . "%20and%20Password%20is:%20" . $pass;

							/*$curl = curl_init();
																																																											  curl_setopt_array($curl, array(
																																																												CURLOPT_URL => "http://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=CoE-DU&pass=123456&mobile=".$phone."&charset=ASCII&sms=".$msg,
																																																												CURLOPT_RETURNTRANSFER => true,
																																																												CURLOPT_ENCODING => "",
																																																												CURLOPT_MAXREDIRS => 10,
																																																												CURLOPT_TIMEOUT => 30,
																																																												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																																																												CURLOPT_CUSTOMREQUEST => "GET",
																																																												CURLOPT_HTTPHEADER => array(
																																																												  "accept: application/json",
																																																												  "authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ=="
																																																												),
																																																											  ));
																																																											  $response = curl_exec($curl);
																																																											  $err = curl_error($curl);

																																																											  curl_close($curl);*/

							$to = $phone;
							$token = "2adc6a46028eaaf69879e7dce3f3037e";
							$message = $msg;
							$url = "http://api.greenweb.com.bd/api.php";

							$data = array(
								'to' => "$to",
								'message' => "$message",
								'token' => "$token"
							); // Add parameters in key value
							$ch = curl_init(); // Initialize cURL
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_ENCODING, '');
							curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

							$response = curl_exec($ch);
							$err = curl_error($ch);

							curl_close($ch);

							if ($err) {
								echo "cURL Error #:" . $err;
							} else {

								$sms_count = $count_sent_sms + 1;

								$sqlup = "UPDATE admitted_student SET count_sent_sms = '$sms_count' WHERE ADMITTED_STUDENT_ID = $sid";
								$smsresult = $this->db->update($sqlup);

								$msgl = 10 - $sms_count;
								if ($msgl != 0) {
									$msglimit = $msgl;
								} else {
									$msglimit = 0;
								}


								//echo $response;
								echo "<div class='alert alert-success'> We have successfully send your password on your registered mobile number.Check your inbox to get your password.You have " . $msglimit . " times remaing to send forgot password.</div>";
							}

						} else {
							echo "<div class='alert alert-danger'> Your password send has 10 times expired.</div>";
						}

					} else {
						echo "<div class='alert alert-danger'> This account was not created</div>";
					}
				}

			} else {
				echo "<div class='alert alert-danger'>Wrong Information Input</div>";
			}

		} catch (Exception $e) {

		}
	}

	function image_size_validation($image)
	{

		$validation_check = false;
		$image_info = getimagesize($image);
		$height_t = $image_info[0];
		$width_t = $image_info[1];

		if (($height_t > 45 && $height_t < 55) && ($width_t > 45 && $width_t < 55)) {
			$validation_check = true;
		}

		return $validation_check;
	}


	public function updateStudentsById($present_house_no, $present_post_code, $house_no, $post_code, $GURDIAN_NAME, $student_id, $reg_number, $subject_id, $session_id, $fathers_name, $mothers_name, $address, $nationality, $religion, $caste_sect, $post_office, $upa_zilla, $district, $phone_number, $parents_income, $student_email, $profile_image, $present_house_road, $present_post_office, $present_upa_zilla, $present_district, $SUBJECTS_ID, $gender)
	{

		$sourcePath = '';

		if (!empty($profile_image)) {

			$sourcePath = $profile_image['tmp_name'];
			$name_img = $profile_image['name'];
			$size_img = $profile_image['size'];
			$image_div = explode('.', $name_img);
			$image_ext = strtolower(end($image_div));

			$validextensions = array("jpeg", "jpg", "png");
		}


		if (empty($address) || empty($fathers_name) || empty($mothers_name) || empty($phone_number)) {
			$msg = "<div class='alert alert-danger'> Field must not be Empty!</div>";
			return $msg;
		} else {

			$present_house_no = $this->fm->validation($present_house_no);
			$present_post_code = $this->fm->validation($present_post_code);
			$house_no = $this->fm->validation($house_no);
			$post_code = $this->fm->validation($post_code);

			$GURDIAN_NAME = $this->fm->validation($GURDIAN_NAME);
			$student_id = $this->fm->validation($student_id);
			$reg_number = $this->fm->validation($reg_number);
			$subject_id = $this->fm->validation($subject_id);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$session_id = $this->fm->validation($session_id);

			$fathers_name = $this->fm->validation($fathers_name);
			$mothers_name = $this->fm->validation($mothers_name);
			$address = $this->fm->validation($address);
			$nationality = $this->fm->validation($nationality);
			$religion = $this->fm->validation($religion);
			$caste_sect = $this->fm->validation($caste_sect);
			$post_office = $this->fm->validation($post_office);
			$upa_zilla = $this->fm->validation($upa_zilla);
			$district = $this->fm->validation($district);
			$phone_number = $this->fm->validation($phone_number);
			$parents_income = $this->fm->validation($parents_income);
			$student_email = $this->fm->validation($student_email);
			$gender = $this->fm->validation($gender);

			$present_house_road = $this->fm->validation($present_house_road);
			$present_post_office = $this->fm->validation($present_post_office);
			$present_upa_zilla = $this->fm->validation($present_upa_zilla);
			$present_district = $this->fm->validation($present_district);

			$present_house_no = mysqli_real_escape_string($this->db->link, $present_house_no);
			$present_post_code = mysqli_real_escape_string($this->db->link, $present_post_code);
			$house_no = mysqli_real_escape_string($this->db->link, $house_no);
			$post_code = mysqli_real_escape_string($this->db->link, $post_code);


			$GURDIAN_NAME = mysqli_real_escape_string($this->db->link, $GURDIAN_NAME);
			$student_id = mysqli_real_escape_string($this->db->link, $student_id);
			$reg_number = mysqli_real_escape_string($this->db->link, $reg_number);
			$subject_id = mysqli_real_escape_string($this->db->link, $subject_id);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$fathers_name = mysqli_real_escape_string($this->db->link, $fathers_name);
			$mothers_name = mysqli_real_escape_string($this->db->link, $mothers_name);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$nationality = mysqli_real_escape_string($this->db->link, $nationality);

			$religion = mysqli_real_escape_string($this->db->link, $religion);
			$caste_sect = mysqli_real_escape_string($this->db->link, $caste_sect);
			$post_office = mysqli_real_escape_string($this->db->link, $post_office);
			$upa_zilla = mysqli_real_escape_string($this->db->link, $upa_zilla);
			$district = mysqli_real_escape_string($this->db->link, $district);
			$phone_number = mysqli_real_escape_string($this->db->link, $phone_number);
			$parents_income = mysqli_real_escape_string($this->db->link, $parents_income);
			$student_email = mysqli_real_escape_string($this->db->link, $student_email);
			$gender = mysqli_real_escape_string($this->db->link, $gender);

			$present_house_road = mysqli_real_escape_string($this->db->link, $present_house_road);
			$present_post_office = mysqli_real_escape_string($this->db->link, $present_post_office);
			$present_upa_zilla = mysqli_real_escape_string($this->db->link, $present_upa_zilla);
			$present_district = mysqli_real_escape_string($this->db->link, $present_district);

			if (!empty($sourcePath)) {

				$data = getimagesize($sourcePath);
				$width = $data[0];
				$height = $data[1];

				if (in_array($image_ext, $validextensions) === false) {
					$msg = "<div class='alert alert-danger'>You can uploads only:-" . implode(', ', $validextensions) . "</div>";
					return $msg;

				} else if ($size_img > 1048576) {
					$msg = "<div class='alert alert-danger'>Image Size Should be less then 1 MB !</div>";
					return $msg;
				} else if (($width < 145 || $width > 160) || ($height < 130 || $height > 155)) {

					$msg = "<div class='alert alert-danger'>Image Size Should 150*150PX !</div>";
					return $msg;
				} else {

					$dir = $this->imageDir($SUBJECTS_ID);
					if (empty($dir)) {
						$dir = 's_images';
					}

					$targetDir = $dir . "/" . $reg_number . $session_id . $SUBJECTS_ID . "/";

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}

					if (file_exists($targetDir)) {
						array_map('unlink', glob($targetDir . "*"));
					}


					$imgUName = uniqid();

					$targetPath = $targetDir . $imgUName . "." . $image_ext;

					move_uploaded_file($sourcePath, $targetPath);

					//                  $sql = "UPDATE admitted_student SET
//                          present_house_no = '$present_house_no',
//                          present_post_code = '$present_post_code',
//                          house_no = '$house_no',
//                          post_code = '$post_code',
//                          GURDIAN_NAME = '$GURDIAN_NAME',
//                          ADMITTED_STUDENT_ADDRESS    = '$address',
//                          ADMITTED_STUDENT_FATHERS_N  = '$fathers_name',
//                          ADMITTED_STUDENT_MOTHERS_N  = '$mothers_name',
//                          ADMITTED_STUDENT_CONTACT_NO = '$phone_number',
//                          post_office                 = '$post_office',
//                          image_dir                 = '$dir',
//                          upa_zilla                   = '$upa_zilla',
//                          district                    = '$district',
//                          NATIONALITY                 = '$nationality',
//                          RELIGION                    = '$religion',
//                          CASTE_SECT                  = '$caste_sect',
//                          parents_income              = '$parents_income',
//                          ADMITTED_STUDENT_EMAIL      = '$student_email',
//                          present_house_road          = '$present_house_road',
//                          present_post_office         = '$present_post_office',
//                          present_upa_zilla           = '$present_upa_zilla',
//                          present_district            = '$present_district',
//                          ADMITTED_STUDENT_GENDER     = '$gender'
//                          WHERE ADMITTED_STUDENT_ID   = '$student_id'";
//

					$sql = "UPDATE admitted_student SET
                          present_house_no = '$present_house_no',
                          present_post_code = '$present_post_code',
                          house_no = '$house_no',
                          post_code = '$post_code',
                          GURDIAN_NAME = '$GURDIAN_NAME',
                          ADMITTED_STUDENT_ADDRESS    = '$address',
                          ADMITTED_STUDENT_CONTACT_NO = '$phone_number',
                          post_office                 = '$post_office',
                          image_dir                 = '$dir',
                          upa_zilla                   = '$upa_zilla',
                          district                    = '$district',
                          NATIONALITY                 = '$nationality',
                          RELIGION                    = '$religion',
                          CASTE_SECT                  = '$caste_sect',
                          parents_income              = '$parents_income',
                          ADMITTED_STUDENT_EMAIL      = '$student_email',
                          present_house_road          = '$present_house_road',
                          present_post_office         = '$present_post_office',
                          present_upa_zilla           = '$present_upa_zilla',
                          present_district            = '$present_district',
                          ADMITTED_STUDENT_GENDER     = '$gender'
                          WHERE ADMITTED_STUDENT_ID   = '$student_id'";





					$result = $this->db->update($sql);
					if ($result) {

						$msg = "<div class='alert alert-success'> Profile Updated Successfully! </div>";
						return $msg;

					} else {
						$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
						return $msg;
					}

				}
			} else {
				$sql = "UPDATE admitted_student SET
                          post_code    			= '$post_code',
                          present_post_code    	= '$present_post_code',
                          present_house_no    	= '$present_house_no',
                          house_no   			= '$house_no',
                          GURDIAN_NAME    = '$GURDIAN_NAME',
                          ADMITTED_STUDENT_ADDRESS    = '$address',

                          ADMITTED_STUDENT_FATHERS_N  = '$fathers_name',
                          ADMITTED_STUDENT_MOTHERS_N  = '$mothers_name',
                          ADMITTED_STUDENT_CONTACT_NO = '$phone_number',
                          post_office                 = '$post_office',
                          upa_zilla                   = '$upa_zilla',
                          district                    = '$district',
                          NATIONALITY                 = '$nationality',
                          RELIGION                    = '$religion',
                          CASTE_SECT                  = '$caste_sect',
                          parents_income              = '$parents_income',
                          ADMITTED_STUDENT_EMAIL      = '$student_email',
                          present_house_road          = '$present_house_road',
                          present_post_office         = '$present_post_office',

                          present_upa_zilla           = '$present_upa_zilla',
                          present_district            = '$present_district',
                          ADMITTED_STUDENT_GENDER     = '$gender'
                          WHERE ADMITTED_STUDENT_ID   = '$student_id'";
				$result = $this->db->update($sql);
				if ($result) {

					$msg = "<div class='alert alert-success'> Profile Updated Successfully!</div>";
					return $msg;

				} else {
					$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
					return $msg;
				}
			}
		}
	}


	public function update_student_info_API($ADMITTED_STUDENT_ID, $ADMITTED_STUDENT_FATHERS_N, $ADMITTED_STUDENT_MOTHERS_N, $ADMITTED_STUDENT_ADDRESS, $ADMITTED_STUDENT_CONTACT_NO, $NUReg, $ADMITTED_STUDENT_EMAIL)
	{

		$ADMITTED_STUDENT_FATHERS_N = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_FATHERS_N);
		$ADMITTED_STUDENT_MOTHERS_N = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_MOTHERS_N);
		$ADMITTED_STUDENT_ADDRESS = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ADDRESS);
		$ADMITTED_STUDENT_CONTACT_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_CONTACT_NO);
		$NUReg = mysqli_real_escape_string($this->db->link, $NUReg);
		$ADMITTED_STUDENT_EMAIL = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_EMAIL);

		$sql = "UPDATE `admitted_student` SET `ADMITTED_STUDENT_FATHERS_N`='$ADMITTED_STUDENT_FATHERS_N',`ADMITTED_STUDENT_MOTHERS_N`='$ADMITTED_STUDENT_MOTHERS_N',`ADMITTED_STUDENT_ADDRESS`='$ADMITTED_STUDENT_ADDRESS',`ADMITTED_STUDENT_CONTACT_NO`='$ADMITTED_STUDENT_CONTACT_NO',
    `ADMITTED_STUDENT_EMAIL`='$ADMITTED_STUDENT_EMAIL',`NUReg`='$NUReg' WHERE ADMITTED_STUDENT_ID = $ADMITTED_STUDENT_ID";

		$result = $this->db->update($sql);
		return $result;


	}
	public function getStudentNuregNumber($ADMITTED_STUDENT_ID)
	{
		try {
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$sql = "SELECT NUReg FROM admitted_student WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID'";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}



	public function updateStudentInfromationById($addmitted_sid, $village, $post_office, $upa_zilla, $district, $student_name, $fathers_name, $mothers_name, $phone_number, $parents_income, $student_dob, $nationality, $religion, $caste_sect, $password, $confirm_password, $profile_image, $width, $height)
	{

		try {

			$sourcePath = $profile_image['tmp_name'];
			$name_img = $profile_image['name'];
			$size_img = $profile_image['size'];
			$image_div = explode('.', $name_img);
			$image_ext = strtolower(end($image_div));
			$validextensions = array("jpeg", "jpg", "png");


			if (empty($village) || empty($post_office) || empty($upa_zilla) || empty($district) || empty($student_name) || empty($fathers_name) || empty($mothers_name) || empty($phone_number) || empty($password) || empty($confirm_password) || empty($sourcePath) || empty($student_dob) || empty($nationality) || empty($religion)) {
				echo "<span style='color:red;font-weight:bold;'>Field must not be Empty!</span>";
			} else {

				$addmitted_sid = $this->fm->validation($addmitted_sid);
				$village = $this->fm->validation($village);
				$post_office = $this->fm->validation($post_office);
				$upa_zilla = $this->fm->validation($upa_zilla);
				$district = $this->fm->validation($district);
				$student_name = $this->fm->validation($student_name);
				$fathers_name = $this->fm->validation($fathers_name);
				$mothers_name = $this->fm->validation($mothers_name);
				$phone_number = $this->fm->validation($phone_number);
				$parents_income = $this->fm->validation($parents_income);
				$student_dob = $this->fm->validation($student_dob);
				$nationality = $this->fm->validation($nationality);
				$religion = $this->fm->validation($religion);
				$caste_sect = $this->fm->validation($caste_sect);
				$password = $this->fm->validation($password);
				$confirm_password = $this->fm->validation($confirm_password);
				$addmitted_sid = mysqli_real_escape_string($this->db->link, $addmitted_sid);
				$village = mysqli_real_escape_string($this->db->link, $village);
				$post_office = mysqli_real_escape_string($this->db->link, $post_office);
				$upa_zilla = mysqli_real_escape_string($this->db->link, $upa_zilla);
				$district = mysqli_real_escape_string($this->db->link, $district);
				$student_name = mysqli_real_escape_string($this->db->link, $student_name);
				$fathers_name = mysqli_real_escape_string($this->db->link, $fathers_name);
				$mothers_name = mysqli_real_escape_string($this->db->link, $mothers_name);
				$phone_number = mysqli_real_escape_string($this->db->link, $phone_number);
				$parents_income = mysqli_real_escape_string($this->db->link, $parents_income);
				$student_dob = mysqli_real_escape_string($this->db->link, $student_dob);
				$nationality = mysqli_real_escape_string($this->db->link, $nationality);
				$religion = mysqli_real_escape_string($this->db->link, $religion);
				$caste_sect = mysqli_real_escape_string($this->db->link, $caste_sect);
				$password = mysqli_real_escape_string($this->db->link, $password);
				$confirm_password = mysqli_real_escape_string($this->db->link, $confirm_password);

				if (ctype_alnum($password) === false) {

					echo "<span style='color:red;font-weight:bold;'>Not Allow this " . $password . " Password only allow letters and digits</span>";

					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";

				} else if ($password != $confirm_password) {
					echo "<span style='color:red;font-weight:bold;'>Password and Confirm Password does not match!</span>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 5000);</script>";
				} else if (in_array($image_ext, $validextensions) === false) {
					echo "<span style='color:red;font-weight:bold;'>You can uploads only:-" . implode(', ', $validextensions) . "</span>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
				} else if ($size_img > 1048576) {
					echo "<span style='color:red;font-weight:bold;'>Image Size Should be less then 1 MB !</span>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
				} else if (($width < 145 || $width > 155) || ($height < 145 || $height > 155)) {

					echo "<span style='color:red;font-weight:bold;'>Image Size Should 150*150PX !</span>";
					echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
				} else {
					$csql = "SELECT * FROM admitted_student WHERE ACCOUNT_CREATE_STATUS = 0 AND ADMITTED_STUDENT_ID = '$addmitted_sid'";
					$cudresult = $this->db->select($csql);
					if ($cudresult) {
						$rows = $cudresult->fetch_assoc();
						$ADMITTED_STUDENT_REG_NO = $rows['ADMITTED_STUDENT_REG_NO'];
						$SUBJECTS_ID = $rows['SUBJECTS_ID'];
						$SESSION_ID = $rows['SESSION_ID'];
						$dir = $rows['image_dir'];
						$SUBJECTS_ID = $rows['SUBJECTS_ID'];

						$targetDir = "students/" . $dir . "/" . $ADMITTED_STUDENT_REG_NO . $SESSION_ID . $SUBJECTS_ID . "/";
						if (!is_dir($targetDir)) {
							mkdir($targetDir, 0777, true);
						}

						if (file_exists($targetDir)) {
							array_map('unlink', glob($targetDir . "*"));
						}

						$targetPath = $targetDir . $name_img;
						move_uploaded_file($sourcePath, $targetPath);

						$sql = "UPDATE admitted_student SET
                          ADMITTED_STUDENT_ADDRESS    = '$village',
                          post_office                 = '$post_office',
                          upa_zilla                   = '$upa_zilla',
                          district                    = '$district',
                          STUDENT_BANGLA_NAME         = '$student_name',
                          ADMITTED_STUDENT_FATHERS_N  = '$fathers_name',
                          ADMITTED_STUDENT_MOTHERS_N  = '$mothers_name',
                          ADMITTED_STUDENT_CONTACT_NO = '$phone_number',
                          ADMITTED_STUDENT_DOB        = '$student_dob',
                          NATIONALITY                 = '$nationality',
                          RELIGION                    = '$religion',
                          CASTE_SECT                  = '$caste_sect',
                          parents_income              = '$parents_income',
                          PASSWORD                    = '$password',
                          ACCOUNT_CREATE_STATUS       = '1'
                          WHERE ADMITTED_STUDENT_ID = '$addmitted_sid'";
						$result = $this->db->update($sql);
						if ($result) {

							if (empty($_SESSION['app'])) {

								echo "<div class='alert alert-success'> Registration Successfully! </div>";
								echo "<a href='index.php' class='btn btn-primary btn-block'> Login </a>";


							} else {

								echo "<div class='alert alert-success'>Registration Successfully! Go Back to Login.</div>";
							}

							echo "<script>alert('Registration Successfully!');</script>";
						} else {
							echo "<div class='alert-danger'>Something went wrong!</div>";
						}

					} else {
						echo "<div class='alert-danger'>Allready Created!</div>";
					}

				}

			}

		} catch (Exception $e) {

		}

	}

	public function registrationStudentInfromation($ssoticket, $last_enroll_session, $present_house_no, $present_post_code, $house_no, $post_code, $GURDIAN_NAME, $HALL, $registrationno, $REGISTERED_COLLEGE_ID, $SUBJECTS_ID, $session_id, $student_name_en, $village, $post_office, $upa_zilla, $district, $present_house_road, $present_post_office, $present_upa_zilla, $present_district, $student_name, $fathers_name, $mothers_name, $phone_number, $parents_income, $student_dob, $nationality, $religion, $caste_sect, $gender, $profile_image, $width, $height, $blood_group)
	{

		//try {

		$sourcePath = $profile_image['tmp_name'];
		$name_img = $profile_image['name'];
		$size_img = $profile_image['size'];
		$image_div = explode('.', $name_img);
		$image_ext = strtolower(end($image_div));
		$validextensions = array("jpeg", "jpg", "png");


		if (empty($present_house_no) || empty($present_post_code) || empty($house_no) || empty($post_code) || empty($GURDIAN_NAME) || empty($HALL) || empty($registrationno) || empty($REGISTERED_COLLEGE_ID) || empty($SUBJECTS_ID) || empty($session_id) || empty($student_name_en) || empty($village) || empty($post_office) || empty($upa_zilla) || empty($district) || empty($present_house_road) || empty($present_post_office) || empty($present_upa_zilla) || empty($present_district) || empty($student_name) || empty($fathers_name) || empty($mothers_name) || empty($phone_number) || empty($parents_income) || empty($gender) || empty($sourcePath) || empty($student_dob) || empty($nationality) || empty($religion)) {
			echo "<span style='color:red;font-weight:bold;'>202: * Field can not be empty!</span>";
		} else {

			$blood_group = $this->fm->validation($blood_group);
			$ssoticket = $this->fm->validation($ssoticket);
			$last_enroll_session = $this->fm->validation($last_enroll_session);
			$present_house_no = $this->fm->validation($present_house_no);
			$present_post_code = $this->fm->validation($present_post_code);
			$house_no = $this->fm->validation($house_no);
			$post_code = $this->fm->validation($post_code);
			$HALL = $this->fm->validation($HALL);
			$GURDIAN_NAME = $this->fm->validation($GURDIAN_NAME);
			$registrationno = $this->fm->validation($registrationno);
			$REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$session_id = $this->fm->validation($session_id);
			$student_name_en = $this->fm->validation($student_name_en);
			$village = $this->fm->validation($village);
			$post_office = $this->fm->validation($post_office);
			$upa_zilla = $this->fm->validation($upa_zilla);
			$district = $this->fm->validation($district);

			$present_house_road = $this->fm->validation($present_house_road);
			$present_post_office = $this->fm->validation($present_post_office);
			$present_upa_zilla = $this->fm->validation($present_upa_zilla);
			$present_district = $this->fm->validation($present_district);

			$student_name = $this->fm->validation($student_name);
			$fathers_name = $this->fm->validation($fathers_name);
			$mothers_name = $this->fm->validation($mothers_name);
			$phone_number = $this->fm->validation($phone_number);
			$parents_income = $this->fm->validation($parents_income);
			$student_dob = $this->fm->validation($student_dob);
			$nationality = $this->fm->validation($nationality);
			$religion = $this->fm->validation($religion);
			$caste_sect = $this->fm->validation($caste_sect);
			$gender = $this->fm->validation($gender);


			$blood_group = mysqli_real_escape_string($this->db->link, $blood_group);
			$last_enroll_session = mysqli_real_escape_string($this->db->link, $last_enroll_session);
			$ssoticket = mysqli_real_escape_string($this->db->link, $ssoticket);
			$present_house_no = mysqli_real_escape_string($this->db->link, $present_house_no);
			$present_post_code = mysqli_real_escape_string($this->db->link, $present_post_code);
			$house_no = mysqli_real_escape_string($this->db->link, $house_no);
			$post_code = mysqli_real_escape_string($this->db->link, $post_code);
			$HALL = mysqli_real_escape_string($this->db->link, $HALL);
			$GURDIAN_NAME = mysqli_real_escape_string($this->db->link, $GURDIAN_NAME);
			$registrationno = mysqli_real_escape_string($this->db->link, $registrationno);
			$REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$session_id = mysqli_real_escape_string($this->db->link, $session_id);
			$student_name_en = mysqli_real_escape_string($this->db->link, $student_name_en);
			$village = mysqli_real_escape_string($this->db->link, $village);
			$post_office = mysqli_real_escape_string($this->db->link, $post_office);
			$upa_zilla = mysqli_real_escape_string($this->db->link, $upa_zilla);
			$district = mysqli_real_escape_string($this->db->link, $district);

			$present_house_road = mysqli_real_escape_string($this->db->link, $present_house_road);
			$present_post_office = mysqli_real_escape_string($this->db->link, $present_post_office);
			$present_upa_zilla = mysqli_real_escape_string($this->db->link, $present_upa_zilla);
			$present_district = mysqli_real_escape_string($this->db->link, $present_district);

			$student_name = mysqli_real_escape_string($this->db->link, $student_name);
			$fathers_name = mysqli_real_escape_string($this->db->link, $fathers_name);
			$mothers_name = mysqli_real_escape_string($this->db->link, $mothers_name);
			$phone_number = mysqli_real_escape_string($this->db->link, $phone_number);
			$parents_income = mysqli_real_escape_string($this->db->link, $parents_income);
			$student_dob = mysqli_real_escape_string($this->db->link, $student_dob);
			$nationality = mysqli_real_escape_string($this->db->link, $nationality);
			$religion = mysqli_real_escape_string($this->db->link, $religion);
			$caste_sect = mysqli_real_escape_string($this->db->link, $caste_sect);
			$gender = mysqli_real_escape_string($this->db->link, $gender);

			/*  if (ctype_alnum($password) === false) {

																											 echo "<span style='color:red;font-weight:bold;'>Not Allow this ".$password." Password only allow letters and digits</span>";

																											 echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";

																											 } else if($password != $confirm_password){
																											   echo "<span style='color:red;font-weight:bold;'>Password and Confirm Password does not match!</span>";
																											   echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 5000);</script>";
																											 } else  */

			if (in_array($image_ext, $validextensions) === false) {
				echo "202: You can uploads only:-" . implode(', ', $validextensions) . "";
				// echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
			} else if ($size_img > 1048576) {
				echo "202:Image Size Should be less then 1 MB !";
				// echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
			} else if (($width < 145 || $width > 155) || ($height < 130 || $height > 155)) {

				echo "202:Image Size Should 150*150PX !";
				// echo "<script>setTimeout(function(){ window.location.href='sign_up.php'; }, 3000);</script>";
			} else {

				$csql = "SELECT * FROM admitted_student WHERE REGISTERED_COLLEGE_ID = '$REGISTERED_COLLEGE_ID' AND SUBJECTS_ID = '$SUBJECTS_ID' AND SESSION_ID = '$session_id' AND  ADMITTED_STUDENT_REG_NO = '$registrationno'";
				$cudresult = $this->db->select($csql);

				if ($cudresult == false) {

					$dir = $this->imageDir($SUBJECTS_ID);

					if (empty($dir)) {
						$dir = 's_images';
					}

					$targetDir = "students/" . $dir . "/" . $registrationno . $session_id . $SUBJECTS_ID . "/";
					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}

					if (file_exists($targetDir)) {
						array_map('unlink', glob($targetDir . "*"));
					}

					$targetPath = $targetDir . $name_img;
					move_uploaded_file($sourcePath, $targetPath);

					$sql = "INSERT INTO admitted_student (ssoticket,LAST_ENROLLMENT_SESSION,present_house_no,present_post_code,house_no,post_code,GURDIAN_NAME,HALL,SESSION_ID,REGISTERED_COLLEGE_ID,SUBJECTS_ID,ADMITTED_STUDENT_REG_NO,ADMITTED_STUDENT_NAME,STUDENT_BANGLA_NAME,ADMITTED_STUDENT_FATHERS_N,ADMITTED_STUDENT_MOTHERS_N,ADMITTED_STUDENT_ADDRESS,post_office,upa_zilla,district,present_house_road,present_post_office,present_upa_zilla,present_district,ADMITTED_STUDENT_CONTACT_NO,ADMITTED_STUDENT_DOB,NATIONALITY,RELIGION,CASTE_SECT,parents_income,image_dir,ADMITTED_STUDENT_GENDER,ACCOUNT_CREATE_STATUS,blood_group) VALUES('$ssoticket','$last_enroll_session','$present_house_no','$present_post_code','$house_no','$post_code','$GURDIAN_NAME','$HALL','$session_id','$REGISTERED_COLLEGE_ID','$SUBJECTS_ID','$registrationno','$student_name_en','$student_name','$fathers_name','$mothers_name','$village','$post_office','$upa_zilla','$district','$present_house_road','$present_post_office','$present_upa_zilla','$present_district','$phone_number','$student_dob','$nationality','$religion','$caste_sect','$parents_income','$dir','$gender','1','$blood_group')";

					//echo $sql;
					$result = $this->db->insert($sql);
					if ($result) {

						if (empty($_SESSION['app'])) {






							//login
							$query = "SELECT ssoticket,ADMITTED_STUDENT_ID,
							SESSION_ID,ADMITTED_STUDENT_REG_NO,
							subjects.SUBJECTS_ID,
							subjects.REGISTERED_COLLEGE_ID AS REGISTERED_COLLEGE_ID
						FROM admitted_student
						LEFT JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID
						WHERE `ADMITTED_STUDENT_REG_NO`='$registrationno'  LIMIT 1";


							$result = $this->db->select($query);
							if ($result) {
								while ($row1 = $result->fetch_assoc()) {

									$ADMITTED_STUDENT_REG_NO = $row1["ADMITTED_STUDENT_REG_NO"];
									$ADMITTED_STUDENT_ID = $row1["ADMITTED_STUDENT_ID"];
									$SUBJECTS_ID = $row1["SUBJECTS_ID"];
									$SESSION_ID = $row1["SESSION_ID"];
									$REGISTERED_COLLEGE_ID = $row1["REGISTERED_COLLEGE_ID"];
									$ssoticket = $row1["ssoticket"];

									Session::set("ADMITTED_STUDENT_REG_NO", $ADMITTED_STUDENT_REG_NO);
									Session::set("ADMITTED_STUDENT_ID", $ADMITTED_STUDENT_ID);
									Session::set("SUBJECTS_ID", $SUBJECTS_ID);
									Session::set("SESSION_ID", $SESSION_ID);
									Session::set("REGISTERED_COLLEGE_ID", $REGISTERED_COLLEGE_ID);
									Session::set("ssoticket", $ssoticket);

									$id = $row1["ADMITTED_STUDENT_REG_NO"];
									$dt = date("d-m-Y-h:i:sa");
									$access_token_insert = md5($id . $dt);
									Session::set("TOKEN", $access_token_insert);

									$sqlat = "INSERT INTO access_token (ADMITTED_STUDENT_ID,TOKEN) VALUES('$ADMITTED_STUDENT_ID','$access_token_insert')";
									$sqlAccessToken = $this->db->insert($sqlat);

									@header("Location:students/");
									// echo "student_redirect";

								}
							}






							echo "<div class='alert alert-success'>Registration Successfully!</div>";

							echo "<a href='index.php' class='btn btn-primary btn-block'> Login </a>";
						} else {

							echo "<div class='alert alert-success'>Registration Successfully! Go Back to Login.</div>";
						}

						echo "<script>alert('Registration Successfully!');</script>";
					} else {
						echo "202:Something went wrong!";
					}

				} else {
					echo "202:Allready Created!";
				}

			}

		}

		// } catch (Exception $e) {

		//}



	}





	public function printAdmitByStudentId($exam_id, $ADMITTED_STUDENT_ID, $SESSION_ID, $SUBJECTS_ID, $REGISTERED_COLLEGE_ID)
	{

		try {
			$exam_id = $this->fm->validation($exam_id);
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$SESSION_ID = $this->fm->validation($SESSION_ID);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$SESSION_ID = mysqli_real_escape_string($this->db->link, $SESSION_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);

			$query = "SELECT students_view.*,registered_students.fine,registered_students.AVG_ATTEN_MARKS,registered_exam.ADMIT_PRINT_STATUS,registered_students.REGISTERED_STUDENTS_TYPE,exam_view.EXAM_START_DATE,registered_students.REGISTERED_STUDENTS_ID, registered_students.REGISTERED_STUDENTS_EXAM_ROLL,registered_students.CLASS_ROLL,registered_students.CENTER_ID, registered_students.REGISTERED_STUDENTS_TYPE,exam_view.SUBJECTS_TITLE_EN,exam_view.COURSE_YEAR_TITLE,exam_view.EXAM_NAME,exam_view.REGISTERED_EXAM_YEAR,hall.hall_title_en
   	 		FROM students_view
   	 		INNER JOIN registered_students ON students_view.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID
   	 		LEFT JOIN exam_view on exam_view.REGISTERED_EXAM_ID=registered_students.REGISTERED_EXAM_ID
			LEFT JOIN registered_exam on registered_exam.REGISTERED_EXAM_ID =registered_students.REGISTERED_EXAM_ID
			LEFT JOIN hall ON hall.id = students_view.HALL
   	 		WHERE registered_students.REGISTERED_EXAM_ID=$exam_id
   	 		AND students_view.SUBJECTS_ID=$SUBJECTS_ID
   	 		AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY='1'
   	 		AND registered_students.HALL_VERIFY='1'
   	 		AND students_view.SESSION_ID = '$SESSION_ID'
   	 		AND students_view.ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID'

   	 		GROUP BY ADMITTED_STUDENT_ID";
			$result = $this->db->select($query);
			if ($ADMITTED_STUDENT_ID == '2276') {
				// echo $query;exit;
			}
			return $result;

		} catch (Exception $e) {

		}
	}


	public function studentExamInfoEditByCollege($data, $file)
	{

		$sourcePath = '';

		if (!empty($file['previous_doc']['name'])) {

			$sourcePath = $file['previous_doc']['tmp_name'];
			$name_img = $file['previous_doc']['name'];
			$size_img = $file['previous_doc']['size'];
			$image_div = explode('.', $name_img);
			$image_ext = strtolower(end($image_div));
			$validextensions = array("jpeg", "jpg", "png");
		}

		$exam_id = $data['exam_id'];
		$resid = $data['resid'];
		$student_id = $data['student_id'];
		$student_type = $data['student_type'];
		$class_roll_no = $data['class_roll_no'];
		//			$alebrn = $data['alebrn'];
//			$alebmn = $data['alebmn'];
//			$previous_degree = $data['previous_degree'];
//	        $last_passed_prof_month = $data['last_passed_prof_month'];
//			$last_passed_prof_year = $data['last_passed_prof_year'];
		$last_passed_prof_roll = $data['last_passed_prof_roll'];
		//			$year_of_admission = $data['year_of_admission'];
		$local_address = $data['local_address'];

		$punishment_exam = $data['punishment_exam'];
		$punishment_exam_month = $data['punishment_exam_month'];
		$punishment_exam_year = $data['punishment_exam_year'];
		$punishment_exam_roll = $data['punishment_exam_roll'];
		$punishment_name = $data['punishment_name'];
		$RESIDENTIAL_ROOM_NO = $data['RESIDENTIAL_ROOM_NO'];
		$question_language = $data['question_language'];



		if (empty($exam_id) || empty($resid) || empty($student_id) || empty($local_address) || empty($student_type) || empty($class_roll_no)) {
			$msg = "<div class='alert alert-danger'> * Field can not be Empty!</div>";
			return $msg;
		} else {

			$exam_id = $this->fm->validation($exam_id);
			$resid = $this->fm->validation($resid);
			$student_id = $this->fm->validation($student_id);
			$student_type = $this->fm->validation($student_type);
			$class_roll_no = $this->fm->validation($class_roll_no);
			if (empty($last_passed_prof_roll)) {
				$last_passed_prof_roll = '';
			}
			//$alebrn = $this->fm->validation($alebrn);
			//$alebmn = $this->fm->validation($alebmn);
//			$previous_degree = $this->fm->validation($previous_degree);
//			$last_passed_prof_month = $this->fm->validation($last_passed_prof_month);
//			$last_passed_prof_year = $this->fm->validation($last_passed_prof_year);
//			$last_passed_prof_roll = $this->fm->validation($last_passed_prof_roll);
//			$year_of_admission = $this->fm->validation($year_of_admission);
			$local_address = $this->fm->validation($local_address);
			$punishment_exam = $this->fm->validation($punishment_exam);
			$punishment_exam_month = $this->fm->validation($punishment_exam_month);
			$punishment_exam_year = $this->fm->validation($punishment_exam_year);
			$punishment_exam_roll = $this->fm->validation($punishment_exam_roll);
			$punishment_name = $this->fm->validation($punishment_name);
			$RESIDENTIAL_ROOM_NO = $this->fm->validation($RESIDENTIAL_ROOM_NO);
			$question_language = $this->fm->validation($question_language);

			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$resid = mysqli_real_escape_string($this->db->link, $resid);
			$student_id = mysqli_real_escape_string($this->db->link, $student_id);
			$student_type = mysqli_real_escape_string($this->db->link, $student_type);
			$class_roll_no = mysqli_real_escape_string($this->db->link, $class_roll_no);

			//$alebrn = mysqli_real_escape_string($this->db->link, $alebrn);
			//$alebmn = mysqli_real_escape_string($this->db->link, $alebmn);



			$local_address = mysqli_real_escape_string($this->db->link, $local_address);
			$punishment_exam = mysqli_real_escape_string($this->db->link, $punishment_exam);
			$punishment_exam_month = mysqli_real_escape_string($this->db->link, $punishment_exam_month);
			$punishment_exam_year = mysqli_real_escape_string($this->db->link, $punishment_exam_year);
			$punishment_exam_roll = mysqli_real_escape_string($this->db->link, $punishment_exam_roll);
			$punishment_name = mysqli_real_escape_string($this->db->link, $punishment_name);
			$RESIDENTIAL_ROOM_NO = mysqli_real_escape_string($this->db->link, $RESIDENTIAL_ROOM_NO);
			$question_language = mysqli_real_escape_string($this->db->link, $question_language);

			if (!empty($sourcePath)) {

				$data = getimagesize($sourcePath);
				$width = $data[0];
				$height = $data[1];

				if (in_array($image_ext, $validextensions) === false) {
					$msg = "<div class='alert alert-danger'>You can uploads only:-" . implode(', ', $validextensions) . "</div>";
					return $msg;

				} else if ($size_img > 3048576) {
					$msg = "<div class='alert alert-danger'>Image Size Should be less then 3 MB !</div>";
					return $msg;
				} else {

					$targetDir = "../students/students_doc/" . $resid . "/";

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}

					if (file_exists($targetDir)) {
						array_map('unlink', glob($targetDir . "*"));
					}


					$new_filename = str_replace(' ', '_', $name_img) . '_' . time() . '.' . $image_ext;

					$targetPath = $targetDir . $new_filename;
					move_uploaded_file($sourcePath, $targetPath);

					$sql = "UPDATE registered_students SET
                          alebrn = '$alebrn',
                          alebmn  = '$alebmn',
                          PREVIOUS_DEGREE_TYPE = $previous_degree,
                          last_passed_prof_month = '$last_passed_prof_month',
                          last_passed_prof_year = '$last_passed_prof_year',
                          last_passed_prof_roll = '$last_passed_prof_roll',
                          year_of_admission = '$year_of_admission',
                          local_address = '$local_address',
                          punishment_exam = '$punishment_exam',
                          punishment_exam_month = '$punishment_exam_month',
                          punishment_exam_year = '$punishment_exam_year',
                          punishment_exam_roll = '$punishment_exam_roll',
                          punishment_name = '$punishment_name',
                          REGISTERED_STUDENTS_TYPE = '$student_type',
						  RESIDENTIAL_ROOM_NO = '$RESIDENTIAL_ROOM_NO',
                          question_language = '$question_language',
                          CLASS_ROLL = '$class_roll_no'
                          WHERE ADMITTED_STUDENT_ID = '$student_id' AND REGISTERED_STUDENTS_ID = '$resid' AND REGISTERED_EXAM_ID = '$exam_id'";
					$result = $this->db->update($sql);
					if ($result) {

						$msg = "<div class='alert alert-success'> Updated Successfully! </div>";
						return $msg;

					} else {
						$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
						return $msg;
					}

				}
			} else {
				//                          alebrn = '$alebrn',
//                          alebmn  = '$alebmn',
				$sql = "UPDATE registered_students SET
                          last_passed_prof_roll = '$last_passed_prof_roll',
                          local_address = '$local_address',
                          punishment_exam = '$punishment_exam',
                          punishment_exam_month = '$punishment_exam_month',
                          punishment_exam_year = '$punishment_exam_year',
                          punishment_exam_roll = '$punishment_exam_roll',
                          punishment_name = '$punishment_name',
                          REGISTERED_STUDENTS_TYPE = '$student_type',
                          RESIDENTIAL_ROOM_NO = '$RESIDENTIAL_ROOM_NO',
                          question_language  = '$question_language ',
                          CLASS_ROLL = '$class_roll_no'
                          WHERE ADMITTED_STUDENT_ID = '$student_id' AND REGISTERED_STUDENTS_ID = '$resid' AND REGISTERED_EXAM_ID = '$exam_id'";
				$result = $this->db->update($sql);
				if ($result) {

					$msg = "<div class='alert alert-success'> Updated Successfully!</div>";
					return $msg;

				} else {
					$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
					return $msg;
				}
			}
		}
	}


	public function updateStudentSignicher($data, $file)
	{
		try {

			$sig_student_id = $data['sig_student_id'];
			$sig_reg_number = $data['sig_reg_number'];
			$sig_SUBJECTS_ID = $data['sig_subject_id'];
			$sig_session_id = $data['sig_session_id'];
			$s_signicher = $file['s_signicher'];

			$sig_student_id = $this->fm->validation($sig_student_id);
			$sig_reg_number = $this->fm->validation($sig_reg_number);
			$sig_SUBJECTS_ID = $this->fm->validation($sig_SUBJECTS_ID);
			$sig_session_id = $this->fm->validation($sig_session_id);

			$sig_student_id = mysqli_real_escape_string($this->db->link, $sig_student_id);
			$sig_reg_number = mysqli_real_escape_string($this->db->link, $sig_reg_number);
			$sig_SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $sig_SUBJECTS_ID);
			$sig_session_id = mysqli_real_escape_string($this->db->link, $sig_session_id);

			if (empty($sig_student_id) || empty($sig_reg_number) || empty($sig_SUBJECTS_ID) || empty($sig_session_id) || empty($s_signicher)) {
				$msg = "<div class='alert alert-danger'> Field can not be empty!</div>";
				return $msg;
			} else {

				$sourcePath = '';

				if (!empty($s_signicher)) {
					$sourcePath = $s_signicher['tmp_name'];
					$name_img = $s_signicher['name'];
					$size_img = $s_signicher['size'];
					$image_div = explode('.', $name_img);
					$image_ext = strtolower(end($image_div));
					$validextensions = array("jpeg", "jpg", "png");
				}

				if (!empty($sourcePath)) {

					$data = getimagesize($sourcePath);
					$width = $data[0];
					$height = $data[1];

					if (in_array($image_ext, $validextensions) === false) {
						$msg = "<div class='alert alert-danger'>You can uploads only:-" . implode(', ', $validextensions) . "</div>";
						return $msg;
					} else if ($size_img > 1048576) {
						$msg = "<div class='alert alert-danger'>Image Size Should be less then 1 MB !</div>";
						return $msg;
					} else if (($width < 145 || $width > 185) || ($height < 45 || $height > 60)) {
						$msg = "<div class='alert alert-danger'>Image size should \"180 px * 50 px\" !</div>";
						return $msg;
					} else {

						$dir = $this->imageDir($sig_SUBJECTS_ID);
						if (empty($dir)) {
							$dir = 's_images';
						}

						$targetDir = $dir . "/" . $sig_reg_number . $sig_session_id . $sig_SUBJECTS_ID . "_signicher/";

						if (!is_dir($targetDir)) {
							mkdir($targetDir, 0777, true);
						}

						if (file_exists($targetDir)) {
							array_map('unlink', glob($targetDir . "*"));
						}

						$targetPath = $targetDir . $name_img;
						move_uploaded_file($sourcePath, $targetPath);

						$sql = "UPDATE admitted_student SET   s_signicher = '$name_img', image_dir= '$dir' WHERE ADMITTED_STUDENT_ID   = '$sig_student_id'";
						$result = $this->db->update($sql);
						if ($result) {

							$msg = "<div class='alert alert-success'> Updated Successfully! </div>";

							return $msg;

						} else {
							$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
							return $msg;
						}

					}
				} else {
					$msg = "<div class='alert alert-danger'> File can not be empty ! </div>";
					return $msg;
				}

			}
		} catch (Exception $e) {

		}
	}//end signature class



	public function updateStudentpayslip($data, $ADMITTED_STUDENT_ID, $SUBJECTS_ID, $SESSION_ID, $REGISTERED_COLLEGE_ID, $REGISTERED_EXAM_ID, $file)
	{
		try {

			/*       $ADMITTED_STUDENT_ID = $data['ADMITTED_STUDENT_ID'];
																											   $SUBJECTS_ID = $data['SUBJECTS_ID'];
																											   $SESSION_ID = $data['SESSION_ID'];
																											   $REGISTERED_COLLEGE_ID = $data['REGISTERED_COLLEGE_ID'];
																											   $REGISTERED_EXAM_ID = $data['REGISTERED_EXAM_ID'];
																									   */
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$SESSION_ID = $this->fm->validation($SESSION_ID);
			$REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
			$REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);

			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
			$SESSION_ID = mysqli_real_escape_string($this->db->link, $SESSION_ID);
			$REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
			$REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);
			$payslip = '';
			$payslip = $file['payslip'];


			if (empty($ADMITTED_STUDENT_ID) || empty($SUBJECTS_ID) || empty($SESSION_ID) || empty($REGISTERED_EXAM_ID) || empty($payslip)) {
				$msg = "<div class='alert alert-danger'> Field can not be empty!</div>";
				return $msg;
			} else {

				$sourcePath = '';

				if (!empty($payslip)) {
					$sourcePath = $payslip['tmp_name'];
					$name_img = $payslip['name'];
					$size_img = $payslip['size'];
					$image_div = explode('.', $name_img);
					$image_ext = strtolower(end($image_div));
					$validextensions = array("jpeg", "jpg", "png");
				}

				if (!empty($sourcePath)) {

					$data = getimagesize($sourcePath);
					$width = $data[0];
					$height = $data[1];

					if (in_array($image_ext, $validextensions) === false) {
						$msg = "<div class='alert alert-danger'>You can uploads only:-" . implode(', ', $validextensions) . "</div>";
						return $msg;
					} else if ($size_img > 1048576) {
						$msg = "<div class='alert alert-danger'>Image Size Should be less then 1 MB !</div>";
						return $msg;
					}
					/* else if(($width<145 || $width>185) || ($height<45 || $height>60)) {
																																												   $msg = "<div class='alert alert-danger'>Image size should \"180 px * 50 px\" !</div>";
																																												   return $msg;
																																												}  */ else {

						$dir = $this->imageDir2($SUBJECTS_ID);
						if (empty($dir)) {
							$dir = 'payslip';
						}

						$targetDir = $dir . "/" . $REGISTERED_COLLEGE_ID . $ADMITTED_STUDENT_ID . $SUBJECTS_ID . $SESSION_ID . $REGISTERED_EXAM_ID . '/';

						if (!is_dir($targetDir)) {
							mkdir($targetDir, 0777, true);
						}

						if (file_exists($targetDir)) {
							array_map('unlink', glob($targetDir . "*"));
						}

						$targetPath = $targetDir . $name_img;
						move_uploaded_file($sourcePath, $targetPath);

						$sql = "UPDATE registered_students SET PAYSLIP_STATUS =1
                        WHERE REGISTERED_EXAM_ID   = '$REGISTERED_EXAM_ID'
						AND ADMITTED_STUDENT_ID   = '$ADMITTED_STUDENT_ID'
						";
						$result = $this->db->update($sql);
						if ($result) {
							$msg = "<div class='alert alert-success'> Updated Successfully! </div>";
							return $msg;
						} else {
							$msg = "<div class='alert alert-danger'> Something went wrong! </div>";
							return $msg;
						}
					}
				} else {
					$msg = "<div class='alert alert-danger'> File can not be empty ! </div>";
					return $msg;
				}

			}
		} catch (Exception $e) {

		}
	}//end signature class



	public function setApplicationOfCertificate_marksheet($ADMITTED_STUDENT_ID, $degree_awarded, $exam_held_in, $result_publish_date, $transcripts_id, $trans_file, $exam_year, $roll_no, $amount, $depositor, $transaction_id, $image_folder_name, $psid, $degree_level, $delivery_type, $degree_name, $passing_acyr, $CERTIFICATE_OR_MARKSHEET, $examSelect, $reason_of_application, $certificate_type, $result, $phone, $name, $hall_type, $seat_type)
	{

		$trs_file = '';

		$examSelect = mysqli_real_escape_string($this->db->link, $examSelect);

		$random_number = rand(1000, 10000);
		$folder_name = $ADMITTED_STUDENT_ID . $random_number;
		if ($image_folder_name != '') {
			$folder_name = $image_folder_name;
		}

		//        $admstid='3408';
		$admstid = '16810';

		//      if($admstid==$ADMITTED_STUDENT_ID){
//          exit;
//      }

		//   echo "Selected Exam:". $examSelect;
		if ($examSelect == '0' || $examSelect == '') {

			if ($trans_file['size'] > 0) {

				//                print_r($trans_file);
//                echo "File found Selected Exam:".$trans_file['size'];
//                exit();

				// for( $i=0 ; $i < count($trans_file) ; $i++ ) {

				//Get the temp file path
				$tmpFilePath = $_FILES['trans_file']['tmp_name'];

				// echo '<br>';

				//Make sure we have a file path
				if ($tmpFilePath != "") {
					//Setup our new file path

					$dir = 't_image';
					$targetDir = $dir . "/" . $folder_name . '/';

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}



					$extension = pathinfo($_FILES["trans_file"]["name"][$i], PATHINFO_EXTENSION); // Get the file extension

					$fileNmae = $this->sanitizeFilename($_FILES['trans_file']['name']);

					$new_file_path = $targetDir . $fileNmae . '.' . $extension;


					//$newFilePath = $targetDir.$_FILES['trans_file']['name'][$i];



					$trs_file_array[] = $fileNmae . '.' . $extension;

					//Upload the file into the temp dir
					if (move_uploaded_file($tmpFilePath, $new_file_path)) {
						//echo 'success';
						//Handle other code here

					} else {

						echo print_r($_FILES["trans_file"]["error"]);
					}
				}
				// }
			} else {

				$msg = "<div class='alert alert-danger'> Invalid Admit Card! </div>";
				echo $msg;
				//                echo "File Not found Selected Exam:". $examSelect;
				exit();
				return $msg;
			}
		}
		//echo $trans_file['name'];
		//echo '<pre>'; print_r($trans_file);


		try {
			$image_folder_name = $folder_name;
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$degree_awarded = $this->fm->validation($degree_awarded);
			$exam_held_in = $this->fm->validation($exam_held_in);
			$result_publish_date = $this->fm->validation($result_publish_date);

			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$degree_awarded = mysqli_real_escape_string($this->db->link, $degree_awarded);
			$exam_held_in = mysqli_real_escape_string($this->db->link, $exam_held_in);
			$result_publish_date = mysqli_real_escape_string($this->db->link, $result_publish_date);

			$reason_of_application = mysqli_real_escape_string($this->db->link, $reason_of_application);
			$certificate_type = mysqli_real_escape_string($this->db->link, $certificate_type);


			$exam_year = mysqli_real_escape_string($this->db->link, $exam_year);
			$roll_n = mysqli_real_escape_string($this->db->link, $roll_no);
			$result = mysqli_real_escape_string($this->db->link, $result);
			$ADMITTED_STUDENT_ID = preg_replace('/\D/', '', $ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = preg_replace('/[^0-9]+/', '', $ADMITTED_STUDENT_ID);



			//$trs_file=implode('###',$trs_file_array);
			$trs_file = '';

			$amount = $amount;
			$depositor = $depositor;
			$transaction_id = $transaction_id;
			$psid = $psid;
			$degree_level = $degree_level;
			$delivery_type = $delivery_type;
			$degree_name = $degree_name;
			$passing_acyr = $passing_acyr;



			// $psid,$degree_level,$delivery_type,$degree_name,$passing_acyr,$num_of_envelop,$num_of_transcript

			//if (empty($ADMITTED_STUDENT_ID) || empty($degree_awarded) || empty($exam_held_in) || empty($result_publish_date) || empty($number_of_page_trans)) {
			if (empty($result_publish_date)) {

				$msg = "<div class='alert alert-danger'> Field Should not be Empty!!:" . $result_publish_date . " </div>";

				//                echo $msg;
//                exit();
				return $msg;

			} else {



				if (filter_var($ADMITTED_STUDENT_ID, FILTER_VALIDATE_INT)) {


					$sql_i = "SELECT * FROM transcripts WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id='$transcripts_id'";


					$result_i = $this->db->select($sql_i);
					if ($result_i) {

						$sqlup = "UPDATE transcripts SET exam_year='$exam_year',result_id='$examSelect', roll_no='$roll_no',degree_awarded = '$degree_awarded', exam_held_in = '$exam_held_in', result_publish_date = '$result_publish_date',reason_of_application='$reason_of_application',cetrificate_type='$certificate_type' ,`result`='$result' WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id='$transcripts_id' ";

						$result = $this->db->update($sqlup);
						if ($result) {
							$msg = "<div class='alert alert-success'> Update Successfully! </div>";
							return $msg;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}

					} elseif ($hall_type == "Residential") {

						$sql = "INSERT INTO transcripts (psid,degree_level,delivery_type,degree_name,passing_acyr,image_folder_name,trs_file,ADMITTED_STUDENT_ID,degree_awarded,exam_held_in,result_publish_date,status,exam_year,roll_no,amount,depositor,transaction_id,result_id,APPLICATION_TYPE,hall_type,seat_type,cetrificate_type,reason_of_application,`result`) VALUES('$psid','$degree_level','$delivery_type','$degree_name','$passing_acyr','$image_folder_name','$trs_file','$ADMITTED_STUDENT_ID','$degree_awarded','$exam_held_in','$result_publish_date',0,'$exam_year','$roll_no','$amount','$depositor','$transaction_id','$examSelect','$CERTIFICATE_OR_MARKSHEET','$hall_type','$seat_type','$certificate_type','$reason_of_application','$result')";

						$result = $this->db->insert($sql);
						$lastid = mysqli_insert_id($this->db->link);


						if ($result) {

							$message = 'Dear ' . $name . ', Your ' . $delivery_type . ' application for a ' . $certificate_type . ' ' . $CERTIFICATE_OR_MARKSHEET . ' has been submitted and is PENDING verification by your hall. Application ID: ' . $lastid . '. Thanks.';

							$this->sendSMS($phone, $message);
							//$msg = "<div class='alert alert-success'> Save Successfully! </div>";
							$result_data = array(
								'lastid' => $lastid,
								'ADMITTED_STUDENT_ID' => $ADMITTED_STUDENT_ID
							);

							return $result_data;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}
					} elseif ($hall_type == "Non-Residential") {

						$sql = "INSERT INTO transcripts (psid,degree_level,delivery_type,degree_name,passing_acyr,image_folder_name,trs_file,ADMITTED_STUDENT_ID,degree_awarded,exam_held_in,result_publish_date,status,exam_year,roll_no,amount,depositor,transaction_id,result_id,APPLICATION_TYPE,hall_type,seat_type,cetrificate_type,reason_of_application,`result`,`HALL_VERIFICATION`,`hall_check_in_date_update`,accounts_verification) VALUES('$psid','$degree_level','$delivery_type','$degree_name','$passing_acyr','$image_folder_name','$trs_file','$ADMITTED_STUDENT_ID','$degree_awarded','$exam_held_in','$result_publish_date',0,'$exam_year','$roll_no','$amount','$depositor','$transaction_id','$examSelect','$CERTIFICATE_OR_MARKSHEET','$hall_type','$seat_type','$certificate_type','$reason_of_application','$result','0','1','0')";

						$result = $this->db->insert($sql);
						$lastid = mysqli_insert_id($this->db->link);


						if ($result) {

							$message = 'Dear ' . $name . ', Your ' . $delivery_type . ' application for a ' . $certificate_type . ' ' . $CERTIFICATE_OR_MARKSHEET . ' has been submitted and is PENDING verification by your hall. Application ID: ' . $lastid . '. Thanks.';

							$this->sendSMS($phone, $message);
							//$msg = "<div class='alert alert-success'> Save Successfully! </div>";
							$result_data = array(
								'lastid' => $lastid,
								'ADMITTED_STUDENT_ID' => $ADMITTED_STUDENT_ID
							);

							return $result_data;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}

					}

				} else {
					$msg = "<div class='alert alert-danger'> Student Id is not an integer. </div>";
					return $msg;
				}
			}

		} catch (Exception $e) {


		}
	}


	private function sendSMS($phone, $message)
	{
		// Prepare JSON payload dynamically using the function parameters
		$postData = json_encode([
			"phone" => $phone,
			"message" => $message
		]);

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://secure.7college.du.ac.bd/Dua7cApi/sendPublicSMS",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postData,  // Use the dynamic postData
			CURLOPT_HTTPHEADER => [
				"Accept: */*",  // Accept any response
				"Content-Type: application/json",
				"User-Agent: Custom Client"  // You can change this to any user agent
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			// Return or handle error in response
			return "cURL Error #:" . $err;
		} else {
			// Return the API response
			return $response;
		}
	}



	//////////////////  15-09-2021 Md. Imran Hosen www.github.com/MdImranHosen \\\\\\\\\\\\\\\\

	public function setApplicationOfTranscript($ADMITTED_STUDENT_ID, $degree_awarded, $exam_held_in, $result_publish_date, $transcripts_id, $trans_file, $exam_year, $roll_no, $amount, $depositor, $transaction_id, $image_folder_name, $psid, $degree_level, $delivery_type, $degree_name, $passing_acyr, $num_of_envelop, $num_of_transcript, $certificate, $nid)
	{
		$trs_file = '';

		$random_number = rand(1000, 10000);
		$folder_name = $ADMITTED_STUDENT_ID . $random_number;
		if ($image_folder_name != '') {
			$folder_name = $image_folder_name;
		}

		$admstid = '3408';

		//      if($admstid==$ADMITTED_STUDENT_ID){
//          exit;
//      }
		if ($trans_file > 0) {
			for ($i = 0; $i < count($trans_file); $i++) {

				//Get the temp file path
				$tmpFilePath = $_FILES['trans_file']['tmp_name'][$i];
				echo '<br>';

				//Make sure we have a file path
				if ($tmpFilePath != "") {
					//Setup our new file path

					$dir = 't_image';
					$targetDir = $dir . "/" . $folder_name . '/';

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}



					$extension = pathinfo($_FILES["trans_file"]["name"][$i], PATHINFO_EXTENSION); // Get the file extension

					$fileNmae = $this->sanitizeFilename($_FILES['trans_file']['name'][$i]);

					//                  if($admstid==$ADMITTED_STUDENT_ID){
//
//                      echo   "FN:".$fileNmae.", Extension:".$extension;
//                      exit;
//                  }

					$new_file_path = $targetDir . $fileNmae . '.' . $extension;


					//$newFilePath = $targetDir.$_FILES['trans_file']['name'][$i];



					$trs_file_array[] = $fileNmae . '.' . $extension;

					//Upload the file into the temp dir
					if (move_uploaded_file($tmpFilePath, $new_file_path)) {
						//echo 'success';
						//Handle other code here

					} else {

						echo print_r($_FILES["trans_file"]["error"][$i]);
					}
				}
			}
		}

		if ($certificate > 0) {
			for ($i = 0; $i < count($certificate); $i++) {

				//Get the temp file path
				$tmpFilePath = $_FILES['certificate']['tmp_name'][$i];
				echo '<br>';

				//Make sure we have a file path
				if ($tmpFilePath != "") {
					//Setup our new file path


					$dir = 'certificate';
					$targetDir = $dir . "/" . $ADMITTED_STUDENT_ID . '/';

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}

					$newFilePath = $targetDir . $_FILES['certificate']['name'][$i];


					/////


					$extension = pathinfo($_FILES["certificate"]["name"][$i], PATHINFO_EXTENSION); // Get the file extension

					$fileNmae = $this->sanitizeFilename($_FILES['certificate']['name'][$i]);

					$new_file_path = $targetDir . $fileNmae . '.' . $extension;



					/////


					$trs_file_array[] = $fileNmae . '.' . $extension;

					//Upload the file into the temp dir
					if (move_uploaded_file($tmpFilePath, $new_file_path)) {
						//echo 'success';
						//Handle other code here

					} else {

						echo print_r($_FILES["certificate"]["error"]);
					}
				}
			}
		}
		if ($nid > 0) {
			for ($i = 0; $i < count($nid); $i++) {

				//Get the temp file path
				$tmpFilePath = $_FILES['nid']['tmp_name'][$i];
				echo '<br>';

				//Make sure we have a file path
				if ($tmpFilePath != "") {
					//Setup our new file path


					$dir = 'nid';
					$targetDir = $dir . "/" . $ADMITTED_STUDENT_ID . '/';

					if (!is_dir($targetDir)) {
						mkdir($targetDir, 0777, true);
					}

					$newFilePath = $targetDir . $_FILES['nid']['name'][$i];

					/////


					$extension = pathinfo($_FILES["nid"]["name"][$i], PATHINFO_EXTENSION); // Get the file extension

					$fileNmae = $this->sanitizeFilename($_FILES['nid']['name'][$i]);

					$new_file_path = $targetDir . $fileNmae . '.' . $extension;



					/////


					$trs_file_array[] = $fileNmae . '.' . $extension;



					//Upload the file into the temp dir
					if (move_uploaded_file($tmpFilePath, $new_file_path)) {
						//echo 'success';
						//Handle other code here

					} else {

						echo print_r($_FILES["nid"]["error"]);
					}
				}
			}
		}
		//echo $trans_file['name'];
		//echo '<pre>'; print_r($trans_file);

		try {
			$image_folder_name = $folder_name;
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$degree_awarded = $this->fm->validation($degree_awarded);
			$exam_held_in = $this->fm->validation($exam_held_in);
			$result_publish_date = $this->fm->validation($result_publish_date);

			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$degree_awarded = mysqli_real_escape_string($this->db->link, $degree_awarded);
			$exam_held_in = mysqli_real_escape_string($this->db->link, $exam_held_in);
			$result_publish_date = mysqli_real_escape_string($this->db->link, $result_publish_date);

			$exam_year = mysqli_real_escape_string($this->db->link, $exam_year);
			$roll_n = mysqli_real_escape_string($this->db->link, $roll_n);
			$ADMITTED_STUDENT_ID = preg_replace('/\D/', '', $ADMITTED_STUDENT_ID);
			$ADMITTED_STUDENT_ID = preg_replace('/[^0-9]+/', '', $ADMITTED_STUDENT_ID);

			//$trs_file=implode('###',$trs_file_array);
			$trs_file = '';

			$amount = $amount;
			$depositor = $depositor;
			$transaction_id = $transaction_id;
			$psid = $psid;
			$degree_level = $degree_level;
			$delivery_type = $delivery_type;
			$degree_name = $degree_name;
			$passing_acyr = $passing_acyr;
			$num_of_envelop = $num_of_envelop;
			$num_of_transcript = $num_of_transcript;

			// $psid,$degree_level,$delivery_type,$degree_name,$passing_acyr,$num_of_envelop,$num_of_transcript

			//if (empty($ADMITTED_STUDENT_ID) || empty($degree_awarded) || empty($exam_held_in) || empty($result_publish_date) || empty($number_of_page_trans)) {
			if (empty($result_publish_date)) {

				$msg = "<div class='alert alert-danger'> Field Should not be Empty! </div>";
				return $msg;
			} else {

				if (filter_var($ADMITTED_STUDENT_ID, FILTER_VALIDATE_INT)) {


					$sql_i = "SELECT * FROM transcripts WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id='$transcripts_id'";


					$result_i = $this->db->select($sql_i);
					if ($result_i) {

						$sqlup = "UPDATE transcripts SET exam_year='$exam_year',roll_no='$roll_no',degree_awarded = '$degree_awarded', exam_held_in = '$exam_held_in', result_publish_date = '$result_publish_date' WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id='$transcripts_id' ";
						$result = $this->db->update($sqlup);
						if ($result) {
							$msg = "<div class='alert alert-success'> Update Successfully! </div>";
							return $msg;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}

					} else {

						$sql = "INSERT INTO transcripts (psid,degree_level,delivery_type,degree_name,passing_acyr,num_of_envelop,num_of_transcript,image_folder_name,trs_file,ADMITTED_STUDENT_ID,degree_awarded,exam_held_in,result_publish_date,status,exam_year,roll_no,amount,depositor,transaction_id)
		  VALUES('$psid','$degree_level','$delivery_type','$degree_name','$passing_acyr','$num_of_envelop','$num_of_transcript','$image_folder_name','$trs_file','$ADMITTED_STUDENT_ID','$degree_awarded','$exam_held_in','$result_publish_date',0,'$exam_year','$roll_no','$amount','$depositor','$transaction_id')";



						$result = $this->db->insert($sql);
						$lastid = mysqli_insert_id($this->db->link);
						if ($result) {

							//$msg = "<div class='alert alert-success'> Save Successfully! </div>";
							$result_data = array(
								'lastid' => $lastid,
								'ADMITTED_STUDENT_ID' => $ADMITTED_STUDENT_ID
							);
							return $result_data;
						} else {
							$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
							return $msg;
						}
					}

				} else {
					$msg = "<div class='alert alert-danger'> Student Id is not an integer. </div>";
					return $msg;
				}
			}

		} catch (Exception $e) {

		}
	}





	function sanitizeFilename($filename)
	{
		// Remove any characters that are not alphanumeric, underscores, hyphens, or periods

		$pattern = "/[^a-zA-Z0-9']/";

		$filename = preg_replace($pattern, "", $filename);

		$filename = str_replace("'", "", $filename);

		// Make sure the filename is not empty after sanitizing
		if (empty($filename)) {


			$randomString = bin2hex(random_bytes(8)); // Generate a random string
			return $randomString; // or generate a new filename
		}

		return $filename;
	}

	public function getTranscriptsBysid($sid = NULL, $transcripts_id)
	{

		try {
			$sid = $this->fm->validation($sid);
			$sid = mysqli_real_escape_string($this->db->link, $sid);
			$sql = "SELECT * FROM transcripts WHERE ADMITTED_STUDENT_ID = '$sid' AND trannscript_id ='$transcripts_id'";

			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}


	public function getDueAmount($transcripts_id)
	{

		try {
			$transcripts_id = $this->fm->validation($transcripts_id);
			$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);
			$sql = "SELECT * FROM `due_bill_for_students_by_accounts` WHERE `transcript_id` = 9089";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function getYearsBySubject($SUBJECTS_ID)
	{

		try {
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

			if (!empty($SUBJECTS_ID)) {
				$sql = "SELECT * FROM course_year WHERE SUBJECTS_ID = '$SUBJECTS_ID' AND ((COURSE_YEAR_CODE !=NULL) OR (COURSE_YEAR_CODE != '')) ORDER BY COURSE_YEAR_CODE ASC";
				$result = $this->db->select($sql);
				return $result;
			}
		} catch (Exception $e) {

		}
	}

	public function transcriptExamNameHeald($data, $ADMITTED_STUDENT_ID)
	{
		try {
			$trs_year_id = $data['transcripts_id'];
			$trs_program_id = $data['trs_program_id'];
			$examheldroll_ = $data['examheldroll_'];
			$trs_coursecod_id = $data['trs_coursecod_id'];

			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$trs_year_id = $this->fm->validation($trs_year_id);
			$trs_program_id = $this->fm->validation($trs_program_id);
			$examheldroll_ = $this->fm->validation($examheldroll_);
			$trs_coursecod_id = $this->fm->validation($trs_coursecod_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$trs_year_id = mysqli_real_escape_string($this->db->link, $trs_year_id);
			$trs_program_id = mysqli_real_escape_string($this->db->link, $trs_program_id);
			$examheldroll_ = mysqli_real_escape_string($this->db->link, $examheldroll_);
			$trs_coursecod_id = mysqli_real_escape_string($this->db->link, $trs_coursecod_id);

			$trs_year_id = preg_replace("/\D/", '', $trs_year_id);

			if (empty($ADMITTED_STUDENT_ID) || empty($trs_year_id) || empty($trs_program_id) || empty($examheldroll_)) {
				$msg = "<div class='alert alert-danger'>Field must not be Empty!</div>";
				return $msg;
			} else {
				$exam_y = '';

				if ($trs_coursecod_id == 1) {
					$exam_y = "roll_1";
				} elseif ($trs_coursecod_id == 2) {
					$exam_y = "roll_2";
				} elseif ($trs_coursecod_id == 3) {
					$exam_y = "roll_3";
				} elseif ($trs_coursecod_id == 4) {
					$exam_y = "roll_4";
				} elseif ($trs_coursecod_id == 5) {
					$exam_y = "roll_5";
				} elseif ($trs_coursecod_id == 6) {
					$exam_y = "roll_6";
				} elseif ($trs_coursecod_id == 7) {
					$exam_y = "roll_7";
				} elseif ($trs_coursecod_id == 8) {
					$exam_y = "roll_8";
				}

				$sql = "SELECT * FROM transcripts WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id = '$trs_year_id'";
				$result = $this->db->select($sql);
				if ($result) {

					$usql = "UPDATE transcripts SET $exam_y = '$examheldroll_' WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND trannscript_id = '$trs_year_id'";

					#$usql = "UPDATE transcripts SET examheldroll='$examheldroll_' WHERE ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID'";

					$uresult = $this->db->update($usql);

					if ($uresult) {
						$msg = "<div class='alert alert-success'> Update Successfully! </div>";
						return $msg;
					} else {
						$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
						return $msg;
					}
				} else {
					$sql2 = "INSERT INTO transcripts (ADMITTED_STUDENT_ID,$exam_y) VALUES('$ADMITTED_STUDENT_ID','$examheldroll_')";
					$result2 = $this->db->insert($sql2);
					if ($result2) {
						$msg = "<div class='alert alert-success'> Save Successfully! </div>";
						return $msg;
					} else {
						$msg = "<div class='alert alert-danger'> Something went Wrong! </div>";
						return $msg;
					}
				}
			}

		} catch (Exception $e) {

		}
	}

	public function getTranscriptSubjectByProgramYear($COURSE_YEAR_ID, $SUBJECTS_ID)
	{

		try {
			$COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
			$SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
			$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);


			if (!empty($COURSE_YEAR_ID) && !empty($SUBJECTS_ID)) {
				$sql = "SELECT * FROM course_code_title WHERE COURSE_YEAR_ID = '$COURSE_YEAR_ID' AND SUBJECTS_ID = '$SUBJECTS_ID'  ORDER BY order_by ASC";

				$result = $this->db->select($sql);
				return $result;
			}
		} catch (Exception $e) {

		}

	}

	public function getMdImranHosenSubjectByReferredResult($ADMITTED_STUDENT_ID, $COURSE_CODE_TITLE_ID, $transcripts_id)
	{

		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
			$COURSE_CODE_TITLE_ID = $this->fm->validation($COURSE_CODE_TITLE_ID);
			$transcripts_id = $this->fm->validation($transcripts_id);
			$ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
			$COURSE_CODE_TITLE_ID = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);
			$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);

			if (!empty($ADMITTED_STUDENT_ID) && !empty($COURSE_CODE_TITLE_ID) && !empty($transcripts_id)) {

				$sql = "SELECT * FROM  transcript_details WHERE COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID' AND trannscript_id = '$transcripts_id'";

				$result = $this->db->select($sql);
				return $result;
			}
		} catch (Exception $e) {

		}

	}

	public function getTranscriptsExamData($COURSE_CODE_TITLE_ID, $COURSE_YEAR_ID, $transcripts_id)
	{
		try {
			$COURSE_CODE_TITLE_ID = $this->fm->validation($COURSE_CODE_TITLE_ID);
			$COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
			$transcripts_id = $this->fm->validation($transcripts_id);

			$COURSE_CODE_TITLE_ID = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);
			$COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
			$transcripts_id = mysqli_real_escape_string($this->db->link, $transcripts_id);

			if (!empty($COURSE_YEAR_ID) && !empty($transcripts_id) && !empty($COURSE_CODE_TITLE_ID)) {

				// echo $sql = "SELECT * FROM transcript_details WHERE COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID' AND COURSE_YEAR_ID = '$COURSE_YEAR_ID' AND trannscript_id = '$transcripts_id'";
				$sql = "SELECT * FROM transcript_details WHERE COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID' AND trs_year_id_im = '$COURSE_YEAR_ID' AND trannscript_id = '$transcripts_id'";
				//exit;
				$result = $this->db->select($sql);
				return $result;
			}
		} catch (Exception $e) {

		}
	}



	public function getAccountUnpaidAmount($application_id)
	{
		$sql = "SELECT * FROM due_bill_for_students_by_accounts WHERE transcript_id = '$application_id'";
		$result = $this->db->select($sql);
		$total_amount_residential_rent = 0;
		$total_amount_kitchenware_fee = 0;
		$total_amount = 0;


		if ($result && mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result)) {
				if ($row['cost_name'] == 'Residential Seat Rent') {
					$total_amount_residential_rent += $row['amount'];
				} else if ($row['cost_name'] == 'Kitchenware Fee') {
					$total_amount_kitchenware_fee += $row['amount'];
				}
				$total_amount += $row['amount'];

			}
			$data_is_exist_or_not = 'exist';
		} else {
			$data_is_exist_or_not = 'not_exist';
		}

		//Return both values as an array
		return [
			'data_is_exist_or_not'=>$data_is_exist_or_not,
			'total_amount' => $total_amount,
			'residential_rent' => $total_amount_residential_rent,
			'kitchenware_fee' => $total_amount_kitchenware_fee
		];
	}





	function getSeatrentAndKitchenFee($ADMITTED_STUDENT_REG_NO, $application_id, $exam_year, $accounts_verification)
	{



		$url = "https://regservices.eis.du.ac.bd/exctrl/dustudusers/getSeatrentAndKitchenFee";
		$headers = [
			"Content-type: text/xml;charset=\"utf-8\"",
			"Accept: text/xml",
			"Cache-Control: no-cache",
			"Pragma: no-cache",
			"SOAPAction: \"run\""
		];

		try {
			// Initialize cURL
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// Create the XML payload (corrected structure)
			$xml_payload = '<?xml version="1.0" encoding="UTF-8"?>
        <dupgwp>
            <header>
                <pgwkey>abcd</pgwkey>
                <pgwreqid>12</pgwreqid>
            </header>
            <body>
                <requestdata>
                    <service>
                        <gentime>9876</gentime>
                    </service>
                    <params>
                        <param>
                            <payslip-data>
                                <sid>' . $ADMITTED_STUDENT_REG_NO . '</sid>
                                <app-id>' . $application_id . '</app-id>
                                <last-acyr>' . $exam_year . '</last-acyr>
                            </payslip-data>
                        </param>
                    </params>
                </requestdata>
            </body>
        </dupgwp>';

			// Attach the XML payload
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// Execute the cURL request
			$data = curl_exec($ch);

			// Handle cURL errors
			if ($data === false) {
				$error = curl_error($ch);
				return error_log("cURL Error: " . $error); // Log the error
			} else {
				// Convert XML response to array
				$data = json_decode(json_encode(simplexml_load_string($data)), true);

				if ($data['status'] == 'SUCCESS') {
					// print_r($data);
					if ($data['ctrl'] == '__NOT_FOUND__') {
						return 'no';
					} elseif ($data['ctrl'] == "__FOUND__") {

						if (isset($data["dinfo"]) && isset($data["dinfo"]["mis-payment-info"]["pin"])) {

							return "yes";
							// print_r('1-'.$data);

						} else if (isset($data["mis-payment-info"]) && isset($data["mis-payment-info"]["psid"])) {



							$psID = $data['psid'];
							$total_amount = $data['total-amount'];
							$examId = $data["mis-payment-info"]["exam-id"];

							//echo "FIne:".$fine;
							if ($accounts_verification == 0) {

								$this->updateAccountPayment($application_id);

								//echo $examId."#".$ADMITTED_STUDENT_ID;


							}



						}
					} else {
						return 'no';
					}

				}


			}

			curl_close($ch);
		} catch (Exception $e) {
			// Log the exception
			error_log("Exception: " . $e->getMessage());
			echo "<script>window.location = '/students/certificate_applications_list_v2.php';</script>";
		}
	}



	public function generatePaySlip($application_id, $reg_no, $exam_year, $sso_key, $fee_type, $seatrent, $kitchenfee)
	{


		$pay_amounts = $this->getAccountUnpaidAmount($application_id);
		;

		// Define the endpoint URL and headers
		$url = "https://regservices.eis.du.ac.bd/exctrl/dustudusers/getmiscellaneouspayslip";
		$headers = [
			"Content-type: text/xml;charset=\"utf-8\"",
			"Accept: text/xml",
			"Cache-Control: no-cache",
			"Pragma: no-cache",
			"SOAPAction: \"run\""
		];

		try {
			// Initialize cURL
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// Create the XML payload (corrected structure)
			$xml_payload = '<dupgwp>
					<header>
						<pgwkey>cba7996daecec3917b257d43728e6cc683bc026ef116bcfd2945ba8c39c65de80fa60b32faf23135a4137516386e1a4408960ac0f94ecd45ede373b413b0fdad</pgwkey>
						<pgwreqid>1219731579</pgwreqid>
					</header>
					<body>
						<requestdata>
							<service>
								<gentime>20240325211843</gentime>
								<priority>OT</priority>
							</service>
							<params>
							<param>

								<pslip-data>
										<psid>DUUGMISFEE</psid>
										<regno>' . $reg_no . '</regno>
										<step>2</step>

										<exam-year>' . $exam_year . '</exam-year>
										<app-id>' . $application_id . '</app-id>
										<sso-token>' . $sso_key . '</sso-token>
										<ip>103.221.252.148</ip>
										<fine-type>HRNT</fine-type>
										<fine>
											<seatrent>' . $pay_amounts['residential_rent'] . '</seatrent>
											<kitchenfee>' . $pay_amounts['kitchenware_fee'] . '</kitchenfee>
										</fine>
								</pslip-data>

							</param>
						</params>
						</requestdata>
					</body>
				</dupgwp>';

			// Attach the XML payload
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// Execute the cURL request
			$data = curl_exec($ch);

			// Handle cURL errors
			if ($data === false) {
				$error = curl_error($ch);
				return error_log("cURL Error: " . $error); // Log the error
			} else {

				$data = json_decode(json_encode(simplexml_load_string($data)), true);

				if ($data['status'] == 'SUCCESS') {

					?>


					<form id="myForm1" action="https://student.eis.du.ac.bd/bn/368b89a3226798d7db2706dcdc6b21989b4a8553" method="post">
						<input type="hidden" name="sso-ticket" value="<?php echo $_SESSION['sso_ticket']; ?>">
						<input type="hidden" name="type" value="dis_non_collegiate">
					</form>
					<script type="text/javascript">
						document.getElementById('myForm1').submit();
					</script>
					<?php
				}


			}

			curl_close($ch);
		} catch (Exception $e) {
			// Log the exception
			error_log("Exception: " . $e->getMessage());
			echo "<script>window.location = '/students/certificate_applications_list_v2.php';</script>";
		}

	}


	public function updateAccountPayment($application_id)
	{
		$sql = "UPDATE `transcripts` SET `accounts_verification`='1' WHERE trannscript_id=$application_id";
		$this->db->update($sql);
	}




}
