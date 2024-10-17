<?php
/**
 * User for admin controller
 */
class Adminclass extends Mainclass
{

	public function addNotice($data,$file) {
     try {
     	$notice_title = $data['notice_title'];
     	$notice_body  = $data['notice_body'];
     	$create_date  = $data['create_date'];

     	$notice_title = $this->fm->validation($notice_title);
     	$notice_body  = $this->fm->validation($notice_body);
     	$create_date  = $this->fm->validation($create_date);
		$notice_title = mysqli_real_escape_string($this->db->link, $notice_title);
		$notice_body  = mysqli_real_escape_string($this->db->link, $notice_body);
		$create_date  = mysqli_real_escape_string($this->db->link, $create_date);

     	$sourcePath = '';

     	if (isset($file['notice_doc']['name'])) {

     	    $sourcePath = $file['notice_doc']['tmp_name'];
	        $name_img   = $file['notice_doc']['name'];
	        $size_img   = $file['notice_doc']['size'];
	        $image_div  = explode('.', $name_img);
	        $image_ext  = strtolower(end($image_div));
	        $validextensions = array("jpeg", "jpg", "png","pdf","doc","docx","pptx");
     	}

     	 if (empty($notice_title) || empty($create_date) || empty($sourcePath)) {
     		$msg = "<div class='alert alert-danger'>Profile Updated Successfully!</div>";
	        return $msg;
     	  } else if (in_array($image_ext, $validextensions) === false) {
			$msg = "<div class='alert alert-danger'>You can uploads only:-".implode(', ', $validextensions)."</div>";
			return $msg;

		   } /*else if ($size_img > 5242880) {
	        $msg = "<div class='alert alert-danger'>Image Size Should be less then 5 MB!</div>";
	        return $msg;
		   } */else{

		   $notice_name = "notice_". time() .'.'.$image_ext;

           $sql = "INSERT INTO cmc_notice (notice_title,notice_doc,notice_body,create_date) VALUES('$notice_title','$notice_name','$notice_body','$create_date')";
           $result = $this->db->insert($sql);
           if ($result) {

               $last_id = mysqli_insert_id($this->db->link);

                $targetDir = "../notices/".$last_id."/";

			   	if(!is_dir($targetDir)) {
				  mkdir($targetDir, 0777, true);
				}

	            if (file_exists($targetDir)) {
			      array_map('unlink', glob($targetDir."*"));
				}

				$targetPath = $targetDir.$notice_name;

	            if (move_uploaded_file($sourcePath,$targetPath)) {
	            	$msg = "<div class='alert alert-success'> Notice Upload Successfully! </div>";
	            	return $msg;
	            }

          }

     	}



     } catch (Exception $e) {

     }
	}



	public function sendStatToProvost(){

     $hallQuery="SELECT `id`,`hall_title_en`,provost_contact_number FROM `hall` WHERE `status`='1'";
        $result = $this->db->select($hallQuery);

        if ($result) {

            while ($row = $result->fetch_assoc()) {

                $hall_id=$row['id'];
                $provost_contact_number=$row['provost_contact_number'];

                $countPendingQuery="SELECT COUNT(`REGISTERED_STUDENTS_ID`) AS TOTAL FROM `registered_students` JOIN admitted_student on admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID JOIN registered_exam ON registered_exam.REGISTERED_EXAM_ID=registered_students.REGISTERED_EXAM_ID  WHERE registered_students.`REGISTERED_STUDENTS_STATUS`='1' AND registered_students.`HALL_VERIFY`='0' AND admitted_student.HALL='$hall_id'";
                $reshult1 = $this->db->select($countPendingQuery);

                if ($reshult1) {

                    while ($rohw = $reshult1->fetch_assoc()) {

                        $total_pending=$rohw['TOTAL'];
                        if($total_pending>0){

                            $message="Dear Sir,\nI would like to bring to your attention that there are currently ".$total_pending." pending student exam form fill-up applications awaiting verification on the website https://eco.du.ac.bd. Without timely verification, students will be unable to attend exams.\nOffice of the controller of examinations\nUniversity of Dhaka";
                            $this->sendMessage($provost_contact_number,$message);

                        }


                    }
                }


            }

        }


    }

    function sendMessage($to,$message){

        $token = "2adc6a46028eaaf69879e7dce3f3037e";


        $url = "http://api.greenweb.com.bd/api.php?json";


        $data= array(
            'to'=>"$to",
            'message'=>"$message",
            'token'=>"$token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);

//Result
        //  echo $smsresult;

//Error Display
        //  echo curl_error($ch);
    }

    public function getAllNotice() {

		try {
			$sql = "SELECT * FROM cmc_notice ORDER BY id DESC";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function get_by_exam_support_message($exam_id,$start_from,$per_page) {

      try {
        $exam_id = $this->fm->validation($exam_id);
        $start_from = $this->fm->validation($start_from);
        $per_page   = $this->fm->validation($per_page);
        $exam_id = mysqli_real_escape_string($this->db->link,$exam_id);
        $start_from = mysqli_real_escape_string($this->db->link, $start_from);
        $per_page   = mysqli_real_escape_string($this->db->link, $per_page);
        $start_from = preg_replace('/\D/', '', $start_from);
        $per_page   = preg_replace('/\D/', '', $per_page);
        $start_from = (int)$start_from;
        $per_page   = (int)$per_page;

        $sql = "SELECT * FROM support WHERE `STATUS`=1 AND `EXAM_ID` = '$exam_id' ORDER BY ID DESC LIMIT $start_from, $per_page";
        $result = $this->db->select($sql);
        return $result;
      } catch (Exception $e) {

      }
  }

   public function supportMsgPaginations($ID,$per_page) {

     try {
      $ID = $this->fm->validation($ID);
      $per_page = $this->fm->validation($per_page);
      $ID = mysqli_real_escape_string($this->db->link,$ID);
      $per_page = mysqli_real_escape_string($this->db->link, $per_page);
      $per_page = preg_replace('/\D/', '', $per_page);
      $per_page = (int)$per_page;

      $sql = "SELECT * FROM support WHERE `EXAM_ID`= '$ID' AND STATUS = 1";
      $result = $this->db->select($sql);
      $total_row = @$result->num_rows;
      $toral = ceil($total_row/$per_page);
      return $toral;
     } catch (Exception $e) {
      $msg = '<div class="alert alert-danger"> Something went wrong. </div>';
      return $msg;
     }
   }

	public function get_single_paper_code($EXAM_ID,$SUBJECTS_ID,$COURSE_CODE_TITLE_ID) {
	    try {

	    	$EXAM_ID = $this->fm->validation($EXAM_ID);
        $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = $this->fm->validation($COURSE_CODE_TITLE_ID);
        $EXAM_ID = mysqli_real_escape_string($this->db->link,$EXAM_ID);
        $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);

	    	$sql = "SELECT COUNT(`COURSE_CODE_TITLE_ID`) AS TOTAL
			FROM `selected_courses`
			JOIN registered_students ON registered_students.REGISTERED_STUDENTS_ID = selected_courses.REGISTERED_STUDENTS_ID
			JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID
			WHERE selected_courses.REGISTERED_EXAM_ID = '$EXAM_ID'
			AND selected_courses.COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID'
			AND admitted_student.SUBJECTS_ID  = '$SUBJECTS_ID'
			AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1

			";
	        $result = $this->db->select($sql);
	        return $result;
	    } catch (Exception $e) {

	    }
	}
	public function get_single_paper_code_regular($EXAM_ID,$SUBJECTS_ID,$COURSE_CODE_TITLE_ID) {
	    try {

	    	$EXAM_ID = $this->fm->validation($EXAM_ID);
        $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = $this->fm->validation($COURSE_CODE_TITLE_ID);
        $EXAM_ID = mysqli_real_escape_string($this->db->link,$EXAM_ID);
        $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);

	    	$sql = "SELECT COUNT(`COURSE_CODE_TITLE_ID`) AS TOTAL
			FROM `selected_courses`
			JOIN registered_students ON registered_students.REGISTERED_STUDENTS_ID = selected_courses.REGISTERED_STUDENTS_ID
			JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID
			WHERE selected_courses.REGISTERED_EXAM_ID = '$EXAM_ID'
			AND selected_courses.COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID'
			AND admitted_student.SUBJECTS_ID  = '$SUBJECTS_ID'
			AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1
			AND registered_students.REGISTERED_STUDENTS_TYPE=1

			";
	        $result = $this->db->select($sql);
	        return $result;
	    } catch (Exception $e) {

	    }
	}
	public function get_single_paper_code_imp($EXAM_ID,$SUBJECTS_ID,$COURSE_CODE_TITLE_ID) {
	    try {

	    	$EXAM_ID = $this->fm->validation($EXAM_ID);
        $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = $this->fm->validation($COURSE_CODE_TITLE_ID);
        $EXAM_ID = mysqli_real_escape_string($this->db->link,$EXAM_ID);
        $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
        $COURSE_CODE_TITLE_ID   = mysqli_real_escape_string($this->db->link, $COURSE_CODE_TITLE_ID);

	    	$sql = "SELECT COUNT(`COURSE_CODE_TITLE_ID`) AS TOTAL
			FROM `selected_courses`
			JOIN registered_students ON registered_students.REGISTERED_STUDENTS_ID = selected_courses.REGISTERED_STUDENTS_ID
			JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID
			WHERE selected_courses.REGISTERED_EXAM_ID = '$EXAM_ID'
			AND selected_courses.COURSE_CODE_TITLE_ID = '$COURSE_CODE_TITLE_ID'
			AND admitted_student.SUBJECTS_ID  = '$SUBJECTS_ID'
			AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1
			AND registered_students.REGISTERED_STUDENTS_TYPE=2

			";
	        $result = $this->db->select($sql);
	        return $result;
	    } catch (Exception $e) {

	    }
	}

   public function	get_reg_college_exam_by_verify_students_total($EXAM_ID,$REG_COLLEGE_ID) {

     try {

     	 $EXAM_ID = $this->fm->validation($EXAM_ID);
     	 $REG_COLLEGE_ID = $this->fm->validation($REG_COLLEGE_ID);
	   	 $EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
	   	 $REG_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REG_COLLEGE_ID);

        $sql = "SELECT COUNT(`REGISTERED_STUDENTS_ID`) AS TOTAL_STUDENTS FROM `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID WHERE registered_students.REGISTERED_EXAM_ID = '$EXAM_ID' AND admitted_student.REGISTERED_COLLEGE_ID = '$REG_COLLEGE_ID' AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1 AND registered_students.REGISTERED_STUDENTS_STATUS =1";
	        $result = $this->db->select($sql);
	        return $result;
     } catch (Exception $e) {

     }
	}

	public function get_exam_details($exam_id) {

      try {
      	 $exam_id = $this->fm->validation($exam_id);
	   	 $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
      	 $sql = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`=$exam_id";
	     $result = $this->db->select($sql);
	     return $result;
      } catch (Exception $e) {

      }

	}

	 public function get_all_paper_code_on_exam($COURSE_YEAR_ID) {

	   try {
	   	 $COURSE_YEAR_ID = $this->fm->validation($COURSE_YEAR_ID);
	   	 $COURSE_YEAR_ID = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);

	   	 $sql = "SELECT * FROM `course_code_title` WHERE COURSE_CODE_TITLE_STATUS = 1 AND COURSE_YEAR_ID = '$COURSE_YEAR_ID'";
		$result = $this->db->select($sql);
		return $result;

	   } catch (Exception $e) {

	   }
	 }

	 public function getUnpuslishSubjectList($examid) {

	  try {

	  	$examid = $this->fm->validation($examid);
	    $examid = mysqli_real_escape_string($this->db->link, $examid);

	     $sql = "SELECT subjects.* FROM subjects;";

	    //$sql = "SELECT * FROM subjects";
	    $result = $this->db->select($sql);
	    if ($result) {
	    	$output = '<option value="" style="display: none;"> Select Department </option>';
	    	while ($row = $result->fetch_assoc()) {
	    		$subject_id = $row['SUBJECTS_ID'];
	    		$subject_title = $row['SUBJECTS_TITLE'];

	    		$sqlck = "SELECT * FROM result_publish WHERE result_publish_status = 1 AND subject_id = '$subject_id' AND exam_id = '$examid'";
	    		$resultck = $this->db->select($sqlck);
	    		if ($resultck) {


	    		} else{

	    			$output .= '<option value="'.$subject_id.'">'.$subject_title.'</option>';
	    		}


	    	}
	    	echo $output;
	    }

	  } catch (Exception $e) {
	  	echo "<div class='alert alert-danger'>Something went Wrong.</div>";
	  }
	}


	 public function get_all_paper_code_on_exam_for_college($SUBJECT_ID){
	   try {
	   	$SUBJECT_ID = $this->fm->validation($SUBJECT_ID);
	    $SUBJECT_ID = mysqli_real_escape_string($this->db->link, $SUBJECT_ID);

	   	$sql = "SELECT `COURSE_CODE_TITLE_CODE`,
		`COURSE_CODE_TITLE`,
		`COURSE_CODE_TITLE_ID`
		FROM `course_code_title`
		WHERE `COURSE_CODE_TITLE_STATUS`=1
		AND
		`SUBJECTS_ID`=$SUBJECT_ID";
	    $result = $this->db->select($sql);
	    return $result;
	   } catch (Exception $e) {

	   }
	 }

	 public function get_selected_course($registered_student_id){

	 try {
	 	 $registered_student_id = $this->fm->validation($registered_student_id);
	   $registered_student_id = mysqli_real_escape_string($this->db->link, $registered_student_id);

	 	 $query="SELECT course_code_title.COURSE_CODE_TITLE_CODE, course_code_title.COURSE_CODE_TITLE FROM `course_code_title` JOIN selected_courses ON selected_courses.COURSE_CODE_TITLE_ID=course_code_title.COURSE_CODE_TITLE_ID WHERE selected_courses.REGISTERED_STUDENTS_ID=$registered_student_id";

	   $result = $this->db->select($query);
			return $result;
	 } catch (Exception $e) {

	 }
	 }

	 public function get_student_registration_id($ADMITTED_STUDENT_ID,$REGISTERED_EXAM_ID){

	  try {
	  	$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
	  	$REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);
	    $ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
	    $REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);

	  	$query="SELECT `REGISTERED_STUDENTS_ID` FROM `registered_students` WHERE `ADMITTED_STUDENT_ID` = '$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID` = '$REGISTERED_EXAM_ID'";

	    $result = $this->db->select($query);
			return $result;
	  } catch (Exception $e) {

	  }

	 }
	public function allocate_centre($exam_id,$colleg_id,$centre_id,$subject_id){

		try {
			$exam_id = $this->fm->validation($exam_id);
	  	$colleg_id = $this->fm->validation($colleg_id);
	  	$centre_id = $this->fm->validation($centre_id);
	  	$subject_id = $this->fm->validation($subject_id);
	    $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
	    $colleg_id = mysqli_real_escape_string($this->db->link, $colleg_id);
	    $centre_id = mysqli_real_escape_string($this->db->link, $centre_id);
	    $subject_id = mysqli_real_escape_string($this->db->link, $subject_id);

			$modify_query = "UPDATE `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID SET `CENTER_ID`='$centre_id'  WHERE  registered_students.`REGISTERED_EXAM_ID` = '$exam_id'  AND admitted_student.REGISTERED_COLLEGE_ID='$colleg_id' AND admitted_student.SUBJECTS_ID='$subject_id'";
		  $result = $this->db->update($modify_query);
		  return $result;
		} catch (Exception $e) {

		}
	}

	public function updateFormStatusAndVerify($request_from,$verification_type,$REGISTERED_COLLEGE_ID,$submit_type,$admitted_student_id,$exam_id,$payment_no,$payment_date){
     //   echo "<br>Step 3 ";

        $request_from = $this->fm->validation($request_from);
        $verification_type = $this->fm->validation($verification_type);
        $REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
        $submit_type = $this->fm->validation($submit_type);
        $admitted_student_id = $this->fm->validation($admitted_student_id);
        $exam_id = $this->fm->validation($exam_id);
        $payment_no = $this->fm->validation($payment_no);
        $payment_date = $this->fm->validation($payment_date);

        $request_from = mysqli_real_escape_string($this->db->link, $request_from);
        $verification_type = mysqli_real_escape_string($this->db->link, $verification_type);
        $REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
        $submit_type = mysqli_real_escape_string($this->db->link, $submit_type);
        $admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);
        $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
        $payment_no = mysqli_real_escape_string($this->db->link, $payment_no);
        $payment_date = mysqli_real_escape_string($this->db->link, $payment_date);

        $date=date_create($payment_date);
        $payment_date= date_format($date,"Y-m-d");

$update_query="";
if($request_from==1){
    if($verification_type==1){
        if($submit_type==0){
            $update_query="UPDATE `registered_students` SET  `REGISTERED_STUDENTS_COLLEGE_VERIFY`='0',`HALL_VERIFY`='0',`REGISTERED_STUDENTS_STATUS`='0' WHERE `ADMITTED_STUDENT_ID`='$admitted_student_id' AND `REGISTERED_EXAM_ID`='$exam_id';";
        }else if ($submit_type==1) {

            $update_query="UPDATE `registered_students` SET `REGISTERED_STUDENTS_STATUS`='1' WHERE `ADMITTED_STUDENT_ID`='$admitted_student_id' AND `REGISTERED_EXAM_ID`='$exam_id';";

        }
    }else if($verification_type==2){
        $update_query="UPDATE `registered_students` SET `REGISTERED_STUDENTS_COLLEGE_VERIFY`='0' WHERE `ADMITTED_STUDENT_ID`='$admitted_student_id' AND `REGISTERED_EXAM_ID`='$exam_id';";
    }else if($verification_type==3){
        $update_query="UPDATE `registered_students` SET `fine`='1',non_col_payment_submit_datetime=NOW(),non_col_payment_date='$payment_date' WHERE `ADMITTED_STUDENT_ID`='$admitted_student_id' AND `REGISTERED_EXAM_ID`='$exam_id' AND non_col_payslip_no='$payment_no';";
    }

}else{
    if($verification_type==3){
        $update_query="UPDATE `registered_students`  JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID SET `fine`='1',non_col_payment_submit_datetime=NOW(),non_col_payment_date='$payment_date' WHERE registered_students.`ADMITTED_STUDENT_ID`='$admitted_student_id' AND registered_students.`REGISTERED_EXAM_ID`='$exam_id' AND registered_students.non_col_payslip_no='$payment_no' AND admitted_student.SUBJECTS_ID='$REGISTERED_COLLEGE_ID';";
    }


}
        $result = $this->db->update($update_query);

      return "Submitted";

    }

	public function get_unallocated_subject_list($exam_id,$college_id) {

		try {
			$exam_id = $this->fm->validation($exam_id);
	  	$college_id = $this->fm->validation($college_id);
	    $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
	    $college_id = mysqli_real_escape_string($this->db->link, $college_id);

			$sql = "SELECT `SUBJECTS_ID`,`SUBJECTS_TITLE` FROM `selected_course_view` WHERE `CENTER_ID`=0 AND `REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND `REGISTERED_COLLEGE_ID`='$college_id' AND `REGISTERED_EXAM_ID`='$exam_id' GROUP BY `SUBJECTS_ID`";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}

	}


	public function modifyStudentInfoUpdate($EXAM_ID,$admitted_student_id){
		try {
			$EXAM_ID    = mysqli_real_escape_string($this->db->link, $EXAM_ID);
		$admitted_student_id = mysqli_real_escape_string($this->db->link, $admitted_student_id);
		$modify_query = "UPDATE `registered_students` SET REGISTERED_STUDENTS_STATUS=0, REGISTERED_STUDENTS_MOFIFICATION=1,REGISTERED_STUDENTS_COLLEGE_VERIFY=0,REGISTERED_STUDENTS_EXAM_ROLL=0 WHERE REGISTERED_EXAM_ID='$EXAM_ID' AND ADMITTED_STUDENT_ID = '$admitted_student_id'";
		$result = $this->db->update($modify_query);
		return $result;
		} catch (Exception $e) {

		}
	}

	public function admittedStudentCollegeIdCheck($DU_REG){
		try {
			$DU_REG = $this->fm->validation($DU_REG);
			$DU_REG = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $student_query = "SELECT ADMITTED_STUDENT_ID FROM admitted_student WHERE ADMITTED_STUDENT_REG_NO='$DU_REG'";
		  $result = $this->db->select($student_query);
		  return $result;
		} catch (Exception $e) {

		}
	}


public function admittedStudentCollegeIdCheck1($DU_REG,$PROGRMM_ID) {

		try {
			$DU_REG  = mysqli_real_escape_string($this->db->link, $DU_REG);
			$PROGRMM_ID  = mysqli_real_escape_string($this->db->link, $PROGRMM_ID);

		  $student_query = "SELECT ADMITTED_STUDENT_ID FROM admitted_student JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID JOIN programs ON programs.PROGRAMS_ID=subjects.PROGRAMS_ID WHERE ADMITTED_STUDENT_REG_NO = '$DU_REG' AND programs.PROGRAMS_ID='$PROGRMM_ID'";
		  $result = $this->db->select($student_query);
		  return $result;
		} catch (Exception $e) {

		}
	}

	public function insertLateQuery($student_id,$EXAM_ID,$finalRoll) {
	  try {
        $student_id = $this->fm->validation($student_id);
        $EXAM_ID    = $this->fm->validation($EXAM_ID);
        $finalRoll  = $this->fm->validation($finalRoll);
		    $student_id = mysqli_real_escape_string($this->db->link, $student_id);
		    $EXAM_ID    = mysqli_real_escape_string($this->db->link, $EXAM_ID);
		    $finalRoll  = mysqli_real_escape_string($this->db->link, $finalRoll);
		    if (!empty($student_id) && !empty($EXAM_ID)) {

			   $sql = "INSERT INTO `registered_students`(`REGISTERED_STUDENTS_ID`, `ADMITTED_STUDENT_ID`, `REGISTERED_EXAM_ID`, `REGISTERED_STUDENTS_TYPE`, `REGISTERED_STUDENTS_EXAM_ROLL`, `REGISTERED_STUDENTS_DATE`, `REGISTERED_STUDENTS_COLLEGE_VERIFY`, `REGISTERED_STUDENTS_MOFIFICATION`, `REGISTERED_STUDENTS_LATE`, `REGISTERED_STUDENTS_FORM_FILL_DATE`, `REGISTERED_STUDENTS_STATUS`) VALUES ('',$student_id,$EXAM_ID,'',$finalRoll,NOW(),0,0,1,NOW(),0)";
		    $result = $this->db->insert($sql);
		    return $result;
		}

		} catch (Exception $e) {

		}

	}

	public function studentInformationCheck($DU_REG){
		try {
			$DU_REG  = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $studentInfoQuery = "SELECT ADMITTED_STUDENT_ID FROM admitted_student WHERE ADMITTED_STUDENT_REG_NO = '$DU_REG'";
		  $result = $this->db->select($studentInfoQuery);
		  return $result;
		} catch (Exception $e) {

		}
	}

	public function studentInformationCheck1($DU_REG,$SUBJECTS_ID){
		$DU_REG = mysqli_real_escape_string($this->db->link, $DU_REG);
		$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		$studentInfoQuery = "SELECT admitted_student.ADMITTED_STUDENT_ID
		FROM admitted_student
		JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID
		WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$DU_REG' AND subjects.SUBJECTS_ID = '$SUBJECTS_ID'";
		$result = $this->db->select($studentInfoQuery);
		return $result;
	}

	public function admittedStudentModifiChack($DU_REG,$EXAM_ID){
		$DU_REG    = mysqli_real_escape_string($this->db->link, $DU_REG);
		$EXAM_ID   = mysqli_real_escape_string($this->db->link, $EXAM_ID);
		$sql = "SELECT admitted_student.SESSION_ID, allowed_session.SESSION_ID, allowed_session.REGISTERED_EXAM_ID
		FROM admitted_student
		JOIN allowed_session ON admitted_student.SESSION_ID=allowed_session.SESSION_ID
		WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$DU_REG' AND allowed_session.REGISTERED_EXAM_ID = '$EXAM_ID'";
		$result = $this->db->select($sql);
		return $result;
	}

	public function admittedStudentModifiChack1($DU_REG,$EXAM_ID,$SUBJECTS_ID) {

	 try {
		$DU_REG     = mysqli_real_escape_string($this->db->link, $DU_REG);
		$EXAM_ID    = mysqli_real_escape_string($this->db->link, $EXAM_ID);
		$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		$sql = "SELECT admitted_student.SESSION_ID, allowed_session.SESSION_ID, allowed_session.REGISTERED_EXAM_ID
		FROM admitted_student
		JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID
		JOIN allowed_session ON admitted_student.SESSION_ID=allowed_session.SESSION_ID
		WHERE admitted_student.ADMITTED_STUDENT_REG_NO = '$DU_REG' AND allowed_session.REGISTERED_EXAM_ID ='$EXAM_ID' AND subjects.SUBJECTS_ID='$SUBJECTS_ID'";
		$result = $this->db->select($sql);
		return $result;
		} catch (Exception $e) {

		}
	}

	public function addmittedStudentCheck($DU_REG) {
		try {

			$DU_REG = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $sql = "SELECT * FROM admitted_student JOIN registered_students on admitted_student.ADMITTED_STUDENT_ID = registered_students.ADMITTED_STUDENT_ID WHERE admitted_student.ADMITTED_STUDENT_REG_NO='$DU_REG'";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}
	}


	public function addmittedStudentCheck1($DU_REG,$exam_id) {

		try {
			$DU_REG   = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $exam_id  = mysqli_real_escape_string($this->db->link, $exam_id);
		  $sql = "SELECT registered_students.`REGISTERED_STUDENTS_ID` FROM `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE  registered_students.REGISTERED_EXAM_ID='$exam_id' AND admitted_student.ADMITTED_STUDENT_REG_NO='$DU_REG'";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}
	}

	public function check_is_exam_valid_for_reg($exam_id){

	  try {
	  	$exam_id = $this->fm->validation($exam_id);
		  $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

	  	$sql = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`='$exam_id' AND `REGISTERED_EXAM_LATE_FOR_FILL_UP`=1 OR `STUDENT_FORM_FILL_UP`=1 ";
			$result = $this->db->select($sql);
			return $result;
	  } catch (Exception $e) {

	  }
	}

		public function check_is_exam_valid_for_reg1($exam_id){

	    try {
	    	$exam_id = $this->fm->validation($exam_id);
		    $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

	    	$sql = "SELECT * FROM `registered_exam` WHERE `REGISTERED_EXAM_ID`='$exam_id' AND `REGISTERED_EXAM_STATUS`=1 ";
			  $result = $this->db->select($sql);
			  return $result;
	    } catch (Exception $e) {

	    }
	}

	public function change_exam_Status($exam_id,$status) {

		$exam_id = $this->fm->validation($exam_id);
		$status  = $this->fm->validation($status);
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$status  = mysqli_real_escape_string($this->db->link, $status);

	    $query="";

		if($status==1) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=0,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=0,`ADMIT_CARD_ISSUE`=0,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=0 WHERE `REGISTERED_EXAM_ID`=$exam_id";

		} else if($status==2) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=1,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=0,`ADMIT_CARD_ISSUE`=0,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=0 WHERE `REGISTERED_EXAM_ID`=$exam_id";


		} else if($status==3) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=2,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=0,`ADMIT_CARD_ISSUE`=0,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=0 WHERE `REGISTERED_EXAM_ID`=$exam_id";


		} else if($status==4) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=2,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=1,`ADMIT_CARD_ISSUE`=0,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=0 WHERE `REGISTERED_EXAM_ID`=$exam_id";


		} else if($status==5) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=2,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=2,`ADMIT_CARD_ISSUE`=0,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=0 WHERE `REGISTERED_EXAM_ID`=$exam_id";

		} else if($status==6) {

		$query="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=2,`REGISTERED_EXAM_LATE_FOR_FILL_UP`=2,`ADMIT_CARD_ISSUE`=1,`REGISTERED_EXAM_STATUS`=1,`REGISTERED_EXAM_RESULT_PUB`=1 WHERE `REGISTERED_EXAM_ID`=$exam_id";
		}

	$result = $this->db->update($query);
	return $result;
	}


	public function get_all_support_message($REGISTERED_EXAM_ID) {

	     try {
	     	   $REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);
		       $REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);

	     	   $sql = "SELECT * FROM support WHERE `STATUS`=1 AND `EXAM_ID`= '$REGISTERED_EXAM_ID' ORDER BY ID DESC";
		       $result = $this->db->select($sql);
		       return $result;
	     } catch (Exception $e) {

	     }

	}



	public function get_all_reply_message($ID) {

	  try {
	  	$ID = $this->fm->validation($ID);
		  $ID = mysqli_real_escape_string($this->db->link, $ID);

	  	$sql = "SELECT * FROM support_replay WHERE `SUPPORT_ID`= '$ID' ORDER BY ID DESC";
		  $result = $this->db->select($sql);
		  return $result;
	  } catch (Exception $e) {

	  }

	}

    public function get_single_student_appairing_paper_code($ADMITTED_STUDENT_ID,$REGISTERED_EXAM_ID){

	     try {
	     	$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
	     	$REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);
		    $ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);
		    $REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);

	     	$sql = "SELECT `COURSE_CODE_TITLE_CODE` FROM `selected_course_view` WHERE `ADMITTED_STUDENT_ID` = '$ADMITTED_STUDENT_ID' AND `REGISTERED_EXAM_ID` = '$REGISTERED_EXAM_ID'";
	      $result = $this->db->select($sql);
	      return $result;
	     } catch (Exception $e) {

	     }
    }

    public function get_all_registrar_student($REGISTERED_EXAM_ID) {

	   try {
	   	$REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);
		  $REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);

	   	$sql = "SELECT ADMITTED_STUDENT_ID,REGISTERED_STUDENTS_EXAM_ROLL,REGISTERED_STUDENTS_TYPE,CENTER_ID,REGISTERED_STUDENTS_TYPE FROM `registered_students` WHERE `REGISTERED_EXAM_ID` = '$REGISTERED_EXAM_ID' AND `REGISTERED_STUDENTS_COLLEGE_VERIFY`=1";
		  $result = $this->db->select($sql);
		  return $result;
	   } catch (Exception $e) {

	   }
    }


    public function get_all_registrar_student_for_centre($REGISTERED_EXAM_ID,$REGISTERED_COLLEGE_ID){

	    try {
	    	$REGISTERED_EXAM_ID = $this->fm->validation($REGISTERED_EXAM_ID);
	    	$REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
		    $REGISTERED_EXAM_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_EXAM_ID);
		    $REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);

	    	$sql = "SELECT registered_students.* FROM `registered_students` JOIN admitted_student  ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID JOIN subjects ON subjects.SUBJECTS_ID=admitted_student.SUBJECTS_ID WHERE `REGISTERED_EXAM_ID`='$REGISTERED_EXAM_ID' AND `REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND CENTER_ID='$REGISTERED_COLLEGE_ID' ORDER BY subjects.SUBJECTS_ID ASC, registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";
		  $result = $this->db->select($sql);

		  return $result;
	    } catch (Exception $e) {

	    }

     }

     public function get_all_registrar_student_for_college_admin($exam_id) {

	  try {
	  	  $exam_id = $this->fm->validation($exam_id);
        $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

	  	$sql = "SELECT registered_students.*
			FROM `registered_students`
			JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
			JOIN registered_college ON registered_college.REGISTERED_COLLEGE_ID = admitted_student.REGISTERED_COLLEGE_ID
			WHERE registered_students.`REGISTERED_EXAM_ID`='$exam_id' AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
			AND registered_college.REGISTERED_COLLEGE_ID = admitted_student.REGISTERED_COLLEGE_ID
			 ORDER BY admitted_student.HALL ASC
		";//ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC
		$result = $this->db->select($sql);
		return $result;
	  } catch (Exception $e) {

	  }

     }


//	 ($exam_id,$REGISTERED_COLLEGE_ID,$SUBJECTS_ID);
	 public function get_all_registrar_student_for_college($exam_id,$SUBJECTS_ID) {

	  try {

	  	$exam_id = $this->fm->validation($exam_id);
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
      $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		  $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

	  //  ORDER BY admitted_student.HALL ASC	$sql = "SELECT registered_students.* FROM `registered_students`  JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE registered_students.`REGISTERED_EXAM_ID`=$exam_id AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND admitted_student.REGISTERED_COLLEGE_ID=$REGISTERED_COLLEGE_ID AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID' ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";
//		$sql = "SELECT registered_students.*
//		FROM `registered_students`
//		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
//		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
//		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
//		AND registered_students.`HALL_VERIFY`=1
//		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
//		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";

          $sql = "SELECT registered_students.*
		FROM `registered_students`
		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";


          $result = $this->db->select($sql);
		return $result;
	  } catch (Exception $e) {

	  }

 }
//	 ($exam_id,$REGISTERED_COLLEGE_ID,$SUBJECTS_ID);
	 public function get_all_registrar_student_for_college_improvement($exam_id,$SUBJECTS_ID) {

	  try {
	  	$exam_id = $this->fm->validation($exam_id);
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
      $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		  $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

	  //  ORDER BY admitted_student.HALL ASC	$sql = "SELECT registered_students.* FROM `registered_students`  JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE registered_students.`REGISTERED_EXAM_ID`=$exam_id AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND admitted_student.REGISTERED_COLLEGE_ID=$REGISTERED_COLLEGE_ID AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID' ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";
//		$sql = "SELECT registered_students.*
//		FROM `registered_students`
//		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
//		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
//		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
//		AND registered_students.`HALL_VERIFY`=1
//		AND registered_students.`REGISTERED_STUDENTS_TYPE`=2
//		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
//		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";

			$sql = "SELECT registered_students.*
		FROM `registered_students`
		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
		AND registered_students.`REGISTERED_STUDENTS_TYPE`=2
		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";

		$result = $this->db->select($sql);
		return $result;
	  } catch (Exception $e) {

	  }

 }
//	 ($exam_id,$REGISTERED_COLLEGE_ID,$SUBJECTS_ID);
	 public function get_all_registrar_student_for_college_regular($exam_id,$SUBJECTS_ID) {

	  try {

	  	$exam_id = $this->fm->validation($exam_id);
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
      $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		  $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

	  //  ORDER BY admitted_student.HALL ASC	$sql = "SELECT registered_students.* FROM `registered_students`  JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE registered_students.`REGISTERED_EXAM_ID`=$exam_id AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1 AND admitted_student.REGISTERED_COLLEGE_ID=$REGISTERED_COLLEGE_ID AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID' ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";
//		$sql = "SELECT registered_students.*
//		FROM `registered_students`
//		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
//		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
//		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
//		AND registered_students.`HALL_VERIFY`=1
//		AND registered_students.`REGISTERED_STUDENTS_TYPE`=1
//		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
//		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";
//
			$sql = "SELECT registered_students.*
		FROM `registered_students`
		JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID
		WHERE registered_students.`REGISTERED_EXAM_ID` = '$exam_id'
		AND registered_students.`REGISTERED_STUDENTS_COLLEGE_VERIFY`=1
		AND registered_students.`REGISTERED_STUDENTS_TYPE`=1
		AND admitted_student.SUBJECTS_ID = '$SUBJECTS_ID'
		ORDER BY registered_students.REGISTERED_STUDENTS_EXAM_ROLL ASC";


		$result = $this->db->select($sql);
		return $result;
	  } catch (Exception $e) {

	  }

 }


	public function get_couunt_of_each_college($EXAM_ID,$SUBJECT_ID,$REGISTERED_COLLEGE_ID){
	   try {
	   	  $EXAM_ID = $this->fm->validation($EXAM_ID);
		    $SUBJECT_ID = $this->fm->validation($SUBJECT_ID);
		    $REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
        $EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);
		    $SUBJECT_ID = mysqli_real_escape_string($this->db->link, $SUBJECT_ID);
		    $REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);

	   	  $get_reg_student="SELECT admitted_student.ADMITTED_STUDENT_ID,(SELECT registered_college.COLLEGE_NAME FROM registered_college WHERE registered_college.REGISTERED_COLLEGE_ID=registered_students.CENTER_ID) AS CENTER_NAME FROM `registered_students` JOIN admitted_student ON admitted_student.ADMITTED_STUDENT_ID=registered_students.ADMITTED_STUDENT_ID WHERE registered_students.REGISTERED_EXAM_ID='$EXAM_ID' AND admitted_student.SUBJECTS_ID = '$SUBJECT_ID' AND admitted_student.REGISTERED_COLLEGE_ID='$REGISTERED_COLLEGE_ID' AND registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY=1";
		     $result = $this->db->select($get_reg_student);
		     return $result;
	   } catch (Exception $e) {

	   }
	}



	public function update_student_info($registration_no,$student_name,$student_gender,$father_name,$mother_name,$student_id,$subject_ic,$SESSION_ID,$REGISTERED_COLLEGE_ID,$image) {

		 try {

      $registration_no = $this->fm->validation($registration_no);
		  $student_name = $this->fm->validation($student_name);
		  $student_gender = $this->fm->validation($student_gender);
		  $father_name = $this->fm->validation($father_name);
		  $mother_name = $this->fm->validation($mother_name);
		  $student_id = $this->fm->validation($student_id);
		  $subject_ic = $this->fm->validation($subject_ic);
		  $SESSION_ID = $this->fm->validation($SESSION_ID);
		  $REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);

          $registration_no = mysqli_real_escape_string($this->db->link, $registration_no);
		  $student_name = mysqli_real_escape_string($this->db->link, $student_name);
		  $student_gender = mysqli_real_escape_string($this->db->link, $student_gender);
		  $father_name = mysqli_real_escape_string($this->db->link, $father_name);
		  $mother_name = mysqli_real_escape_string($this->db->link, $mother_name);
		  $student_id = mysqli_real_escape_string($this->db->link, $student_id);
		  $subject_ic = mysqli_real_escape_string($this->db->link, $subject_ic);
		  $SESSION_ID = mysqli_real_escape_string($this->db->link, $SESSION_ID);
		  $REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);

		  $sourcePath ='';

		  if (!empty($image)) {

			$sourcePath = $image['tmp_name'];
	        echo $name_img   = $image['name'];
	        $size_img   = $image['size'];
	        $image_div  = explode('.', $name_img);
	        $image_ext  = strtolower(end($image_div));
	        $validextensions = array("jpeg", "jpg", "png");
		  }

		     $sql = "UPDATE `admitted_student` SET `ADMITTED_STUDENT_NAME`='$student_name',`ADMITTED_STUDENT_FATHERS_N`='$father_name',`ADMITTED_STUDENT_MOTHERS_N`='$mother_name',`ADMITTED_STUDENT_GENDER`='$student_gender',SUBJECTS_ID=$subject_ic,SESSION_ID= '$SESSION_ID', REGISTERED_COLLEGE_ID = '$REGISTERED_COLLEGE_ID' WHERE `ADMITTED_STUDENT_ID`=$student_id";
			  $result = $this->db->update($sql);

			  if($result) {

			  if (!empty($sourcePath)) {

			    $data = getimagesize($sourcePath);
				$width  = $data[0];
				$height = $data[1];

				if (in_array($image_ext, $validextensions) === false) {
				$msg = "You can uploads only:-".implode(', ', $validextensions);
				return $msg;

			   } else if ($size_img > 1048576) {
		        $msg = "Image Size Should be less then 1 MB!";
		        return $msg;
			   } else if(($width<145 || $width>155) || ($height<130 || $height>160 )) {

			    $msg = "Image Size Should 150*150PX!";
		        return $msg;
			   } else{

                $targetDir = "../students/s_images/".$registration_no.$SESSION_ID.$subject_ic."/";

			   	if(!is_dir($targetDir)) {
				  mkdir($targetDir, 0777, true);
				}

	            if (file_exists($targetDir)) {
			      array_map('unlink', glob($targetDir."*"));
				}

				$targetPath = $targetDir.$name_img;

	            if (move_uploaded_file($sourcePath,$targetPath)) {
	            	$msg = "Profile Updated Successfully!";
	            	return $msg;
	            }

			  } } else{
			  	$msg = "Profile Updated Successfully!";
			  	return $msg;
			  }

              } else{
             	$msg = "Something went wrong! ";
             	return $msg;

             }

		 } catch (Exception $e) {

		 }
	}

	public function get_single_student_details_with_reg($DU_REG,$SUBJECTS_ID,$session_id) {
		try {
		  $DU_REG     = $this->fm->validation($DU_REG);
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
		  $session_id = $this->fm->validation($session_id);
		  $DU_REG     = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
		  $session_id = mysqli_real_escape_string($this->db->link, $session_id);

		  $sql = "SELECT * FROM `students_view` WHERE SESSION_ID = '$session_id' AND `ADMITTED_STUDENT_REG_NO` = '$DU_REG' AND SUBJECTS_ID = '$SUBJECTS_ID'";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}

	}
	public function get_single_student_details_by_college($DU_REG,$SUBJECTS_ID,$session_id) {

		try {
		  $DU_REG       = $this->fm->validation($DU_REG);
		  $SUBJECTS_ID   = $this->fm->validation($SUBJECTS_ID);
		  $session_id   = $this->fm->validation($session_id);

		  $DU_REG       = mysqli_real_escape_string($this->db->link, $DU_REG);
		  $SUBJECTS_ID   = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
		  $session_id   = mysqli_real_escape_string($this->db->link, $session_id);

		  $sql = "SELECT * FROM `students_view` WHERE  SESSION_ID = '$session_id' AND `ADMITTED_STUDENT_REG_NO`='$DU_REG' AND SUBJECTS_ID='$SUBJECTS_ID'";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}

	}

	public function get_enrolledexam_list($ADMITTED_STUDENT_ID){
		try {
			$ADMITTED_STUDENT_ID = $this->fm->validation($ADMITTED_STUDENT_ID);
		  $ADMITTED_STUDENT_ID = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ID);

			$sql = "SELECT registered_students.*,(SELECT registered_college.COLLEGE_NAME FROM registered_college  WHERE REGISTERED_COLLEGE_ID=registered_students.CENTER_ID) AS COLLEGE_NAME FROM `registered_students` JOIN registered_exam ON registered_exam.REGISTERED_EXAM_ID=registered_students.REGISTERED_EXAM_ID WHERE registered_students.`ADMITTED_STUDENT_ID`='$ADMITTED_STUDENT_ID' ORDER BY registered_exam.REGISTERED_EXAM_YEAR ASC";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}
	}

	public function get_single_exam_details($EXAM_ID){

	 try {
	 	$EXAM_ID = $this->fm->validation($EXAM_ID);
		$EXAM_ID = mysqli_real_escape_string($this->db->link, $EXAM_ID);

	 	$sql = "SELECT * FROM `exam_view` WHERE `REGISTERED_EXAM_ID`='$EXAM_ID' GROUP BY `REGISTERED_EXAM_ID`";
		$result = $this->db->select($sql);
		return $result;
	 } catch (Exception $e) {

	 }

	}

	public function get_single_student_details($student_id = NULL) {
	 try {
	 	$student_id = $this->fm->validation($student_id);
    $student_id = mysqli_real_escape_string($this->db->link,$student_id);
    $student_id = preg_replace('/[^-a-zA-Z0-9_]/','', $student_id);
		$student_id = preg_replace('/\D/', '', $student_id);
		$student_id = htmlentities($student_id);
		$student_id = (int)$student_id;
        if (!empty($student_id)) {
        	$sql = "SELECT students_view.*,hall.hall_title_en FROM `students_view`
			 LEFT JOIN hall ON hall.id=students_view.HALL
			WHERE `ADMITTED_STUDENT_ID`=$student_id";
			$result = $this->db->select($sql);
			return $result;
        }

	   } catch (Exception $e) { }
	}

	public function studentCollegeIdBysId() {

	  try {
		$sql = "SELECT * FROM registered_college ORDER BY REGISTERED_COLLEGE_ID ASC";
		$result = $this->db->select($sql);
		return $result;

	  } catch (Exception $e) {

	  }

	}

	public function get_admitted_student($SUBJECTS_ID,$session_selection) {

	 try {

	 	  $SUBJECTS_ID       = $this->fm->validation($SUBJECTS_ID);
      $session_selection  = $this->fm->validation($session_selection);
      $SUBJECTS_ID       = mysqli_real_escape_string($this->db->link,$SUBJECTS_ID);
      $session_selection  = mysqli_real_escape_string($this->db->link,$session_selection);
      if (!empty($STUDENTS_ID)  || !empty($SUBJECTS_ID)) {

	 	   $sql = "SELECT `ADMITTED_STUDENT_ID`,`ADMITTED_STUDENT_NAME`,`ADMITTED_STUDENT_REG_NO`,`ADMITTED_STUDENT_FATHERS_N` FROM `students_view` WHERE `SESSION_ID` = '$session_selection' AND `SUBJECTS_ID`='$SUBJECTS_ID' AND ADMITTED_STUDENT_STATUS=1"  ;
		   $result = $this->db->select($sql);
		   return $result;
		}
	 } catch (Exception $e) {

	 }
	}
	public function get_all_subject(){

		$sql = "SELECT * FROM `subjects` WHERE `SUBJECTS_STATUS`=1";
		$result = $this->db->select($sql);
		return $result;

	}

	public function get_all_sesation(){


		$sql = "SELECT * FROM `session` WHERE `SESSION_STATUS`=1 ORDER BY SESSION_ID DESC";
		$result = $this->db->select($sql);
		return $result;



	}
	public function get_all_subject1($SUBJECTS_ID) {

		try {
			$SUBJECTS_ID  = $this->fm->validation($SUBJECTS_ID);
      $SUBJECTS_ID  = mysqli_real_escape_string($this->db->link,$SUBJECTS_ID);

			$sql = "SELECT * FROM `subjects` WHERE `SUBJECTS_STATUS`=1 AND SUBJECTS_ID = '$SUBJECTS_ID'";
		  $result = $this->db->select($sql);
		  return $result;
		} catch (Exception $e) {

		}

	}


	public function get_all_colleges() {

	 try {
	 	$sql = "SELECT * FROM `registered_college` WHERE `REGISTERED_COLLEGE_STATUS`=1";
		$result = $this->db->select($sql);
		return $result;

	 	} catch (Exception $e) {

	 	}
	}

	public function get_colleges_exam_year_id($yid = NULL) {

	 try {
	 	$yid = $this->fm->validation($yid);
	 	$yid = mysqli_real_escape_string($this->db->link,$yid);

	 	$sql = "SELECT * FROM registered_college JOIN programs ON programs.PROGRAMS_ID =  registered_college.college_program JOIN course_year ON course_year.PROGRAMS_ID = programs.PROGRAMS_ID WHERE course_year.COURSE_YEAR_ID = '$yid' AND registered_college.REGISTERED_COLLEGE_STATUS = 1";
		$result = $this->db->select($sql);
		return $result;
	 } catch (Exception $e) {

	 }
	}


	public function session_get_qurey(){
		$sql = "SELECT * FROM `session` WHERE `SESSION_STATUS`=1 ORDER BY `SESSION_NAME` DESC";
		$result = $this->db->select($sql);
		return $result;
	}
	public function showExamView(){
		$exam_query="SELECT * FROM `exam_view` WHERE `REGISTERED_EXAM_STATUS`!=2 GROUP BY REGISTERED_EXAM_ID";
		$result = $this->db->select($exam_query);
		return $result;
	}
	public function checkProgramYear($SUBJECTS_ID,$program_year) {
		try {
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);
		  $program_year = $this->fm->validation($program_year);
		  $SUBJECTS_ID  = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
          $program_year = mysqli_real_escape_string($this->db->link, $program_year);

		   $year_id="SELECT `COURSE_YEAR_ID` FROM `course_year` WHERE `SUBJECTS_ID` = '$SUBJECTS_ID' AND `COURSE_YEAR_ID` = '$program_year'";
		   $cresult = $this->db->select($year_id);
		   return $cresult;
		} catch (Exception $e) {

		}
	}
	public function registeredExam($REGISTERED_COLLEGE_ID,$SUBJECTS_ID,$COURSE_YEAR_ID,$exam_year,$last_date_form_fillup,$exam_name){
		try {

		  $COURSE_YEAR_ID        = $this->fm->validation($COURSE_YEAR_ID);
		  $exam_year             = $this->fm->validation($exam_year);
		  $last_date_form_fillup = $this->fm->validation($last_date_form_fillup);
		  $exam_name             = $this->fm->validation($exam_name);
		  $REGISTERED_COLLEGE_ID = $this->fm->validation($REGISTERED_COLLEGE_ID);
		  $SUBJECTS_ID = $this->fm->validation($SUBJECTS_ID);

		  $COURSE_YEAR_ID        = mysqli_real_escape_string($this->db->link, $COURSE_YEAR_ID);
          $exam_year             = mysqli_real_escape_string($this->db->link, $exam_year);
          $last_date_form_fillup = mysqli_real_escape_string($this->db->link, $last_date_form_fillup);
          $exam_name             = mysqli_real_escape_string($this->db->link, $exam_name);
          $REGISTERED_COLLEGE_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
          $SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		   $query="INSERT INTO `registered_exam`(`REGISTERED_COLLEGE_ID`,`SUBJECTS_ID`,`EXAM_NAME`,`COURSE_YEAR_ID`, `REGISTERED_EXAM_YEAR`,`LAST_DATE`)
		  VALUES ('$REGISTERED_COLLEGE_ID','$SUBJECTS_ID','$exam_name','$COURSE_YEAR_ID','$exam_year','$last_date_form_fillup')";
		  $insert = $this->db->insert($query);
		  return $insert;

		} catch (Exception $e) {

		}
	}
	public function registeredExamLastInsertId(){
		$sql = "SELECT REGISTERED_EXAM_ID FROM `registered_exam` ORDER BY REGISTERED_EXAM_ID DESC LIMIT 1";
		$result = $this->db->select($sql);
		return $result;
	}
	public function sessionIdQuery($value) {

		try {
			$value = mysqli_real_escape_string($this->db->link, $value);

			$session_id_query="SELECT `SESSION_ID` FROM `session` WHERE `SESSION_NAME`='$value'";
		  $result = $this->db->select($session_id_query);
		  return $result;
		} catch (Exception $e) {

		}
	}
	public function allowedSession($last_id,$SESSION_ID){
		try {
      $last_id    = $this->fm->validation($last_id);
      $SESSION_ID = $this->fm->validation($SESSION_ID);
		  $last_id    = mysqli_real_escape_string($this->db->link, $last_id);
		  $SESSION_ID = mysqli_real_escape_string($this->db->link, $SESSION_ID);

		  $insert_query="INSERT INTO `allowed_session`( `REGISTERED_EXAM_ID`, `SESSION_ID`) VALUES ('$last_id','$SESSION_ID')";
		  $insert = $this->db->insert($insert_query);
		  return $insert;

		} catch (Exception $e) {

		}
	}
	public function showExamDetails($exam_id) {
		try {
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
			$exam_query="SELECT * FROM `exam_view` WHERE `REGISTERED_EXAM_ID`='$exam_id' GROUP BY `REGISTERED_EXAM_ID`";
		$result = $this->db->select($exam_query);
		return $result;
		} catch (Exception $e) {

		}
	}
	public function resister_examIdSession($exam_id){
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

		$session_query="SELECT `SESSION_NAME`  FROM `exam_view` WHERE `REGISTERED_EXAM_ID`='$exam_id'";
		$result = $this->db->select($session_query);
		return $result;
	}


		public function get_count_total_not_compelete_student($exam_id){

		  $exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		  $session_query="SELECT COUNT(`REGISTERED_STUDENTS_ID`) AS NOT_COMPELETE FROM `registered_students` WHERE `REGISTERED_EXAM_ID`=$exam_id  AND `REGISTERED_STUDENTS_STATUS`=0";


		$result = $this->db->select($session_query);
		return $result;
	}

		public function get_count_total_compelete_student($exam_id){
			$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$session_query="SELECT COUNT(`REGISTERED_STUDENTS_ID`) AS COMPELETE FROM `registered_students` WHERE `REGISTERED_EXAM_ID`=$exam_id  AND `REGISTERED_STUDENTS_STATUS`=1 AND REGISTERED_STUDENTS_COLLEGE_VERIFY=1";


		$result = $this->db->select($session_query);
		return $result;
	}

	public function get_count_total_not_verified_student($exam_id){
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$session_query="SELECT COUNT(`REGISTERED_STUDENTS_ID`) AS NOT_VERIFIED FROM `registered_students` WHERE `REGISTERED_EXAM_ID`=$exam_id  AND `REGISTERED_STUDENTS_STATUS`=1";


		$result = $this->db->select($session_query);
		return $result;
	}



	public function changeExamStatus($type,$exam_id){
		$type = mysqli_real_escape_string($this->db->link, $type);
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$exam_status_change="";

		if($type==1){

		$exam_status_change="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=1 WHERE  `REGISTERED_EXAM_ID`=$exam_id";

		}else if($type==2){
		$exam_status_change="UPDATE `registered_exam` SET `STUDENT_FORM_FILL_UP`=2 WHERE  `REGISTERED_EXAM_ID`=$exam_id";

		}else if($type==3){
		$exam_status_change="UPDATE `registered_exam` SET `REGISTERED_EXAM_LATE_FOR_FILL_UP`=1 WHERE  `REGISTERED_EXAM_ID`=$exam_id";

		}else if($type==4){
		$exam_status_change="UPDATE `registered_exam` SET `REGISTERED_EXAM_LATE_FOR_FILL_UP`=2 WHERE  `REGISTERED_EXAM_ID`=$exam_id";
		}else if($type==5){
		$exam_status_change="UPDATE `registered_exam` SET `ADMIT_CARD_ISSUE`=1 WHERE  `REGISTERED_EXAM_ID`=$exam_id";
		}
		$updat = $this->db->update($exam_status_change);
		return $updat;

	}

	public function cvs_fileUpload($column){

		 date_default_timezone_set('UTC');
         $timestamp = strtotime($column[9]);
         $column[9] = date("Y-m-d", $timestamp);

		 $SESSION_ID                  = $this->fm->validation($column[0]);
		 $REGISTERED_COLLEGE_ID       = $this->fm->validation($column[1]);
		 $SUBJECTS_ID                 = $this->fm->validation($column[2]);
		 $ADMITTED_STUDENT_REG_NO     = $this->fm->validation($column[3]);
		 $ADMITTED_STUDENT_NAME       = $this->fm->validation($column[4]);
		 $ADMITTED_STUDENT_FATHERS_N  = $this->fm->validation($column[5]);
		 $ADMITTED_STUDENT_MOTHERS_N  = $this->fm->validation($column[6]);
		 $ADMITTED_STUDENT_ADDRESS    = $this->fm->validation($column[7]);
		 $ADMITTED_STUDENT_CONTACT_NO = $this->fm->validation($column[8]);
		 $ADMITTED_STUDENT_GENDER     = $this->fm->validation($column[10]);
		 $ADMITTED_STUDENT_EMAIL      = $this->fm->validation($column[11]);
		 $ADMITTED_STUDENT_STATUS     = $this->fm->validation($column[12]);
		 $SUBJECTS_ID                  = $this->fm->validation($column[13]);

		 $SESSION_ID                  = mysqli_real_escape_string($this->db->link, $SESSION_ID);
		 $REGISTERED_COLLEGE_ID       = mysqli_real_escape_string($this->db->link, $REGISTERED_COLLEGE_ID);
		 $SUBJECTS_ID                 = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);
		 $ADMITTED_STUDENT_REG_NO     = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_REG_NO);
         $ADMITTED_STUDENT_NAME       = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_NAME);
         $ADMITTED_STUDENT_FATHERS_N  = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_FATHERS_N);
         $ADMITTED_STUDENT_MOTHERS_N  = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_MOTHERS_N);
         $ADMITTED_STUDENT_ADDRESS    = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_ADDRESS);
         $ADMITTED_STUDENT_CONTACT_NO = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_CONTACT_NO);
         $ADMITTED_STUDENT_GENDER     = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_GENDER);
         $ADMITTED_STUDENT_EMAIL      = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_EMAIL);
         $ADMITTED_STUDENT_STATUS     = mysqli_real_escape_string($this->db->link, $ADMITTED_STUDENT_STATUS);
         $SUBJECTS_ID                  = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		 $sql = "SELECT * FROM `students_view` WHERE `ADMITTED_STUDENT_REG_NO`= '$ADMITTED_STUDENT_REG_NO' AND PROGRAMS_ID='$SUBJECTS_ID'";
		 $datap = $this->db->select($sql);

		if ($datap) {

		  return null;
		} else{

		$sqlInsert = "INSERT INTO admitted_student (SESSION_ID,REGISTERED_COLLEGE_ID,SUBJECTS_ID,ADMITTED_STUDENT_REG_NO,ADMITTED_STUDENT_NAME,ADMITTED_STUDENT_FATHERS_N,ADMITTED_STUDENT_MOTHERS_N,ADMITTED_STUDENT_ADDRESS,ADMITTED_STUDENT_CONTACT_NO,ADMITTED_STUDENT_GENDER,ADMITTED_STUDENT_EMAIL,ADMITTED_STUDENT_STATUS)
                   VALUES ('$SESSION_ID','$REGISTERED_COLLEGE_ID','$SUBJECTS_ID','$ADMITTED_STUDENT_REG_NO','$ADMITTED_STUDENT_NAME','$ADMITTED_STUDENT_FATHERS_N','$ADMITTED_STUDENT_MOTHERS_N','$ADMITTED_STUDENT_ADDRESS','$ADMITTED_STUDENT_CONTACT_NO','$ADMITTED_STUDENT_GENDER','$ADMITTED_STUDENT_EMAIL','$ADMITTED_STUDENT_STATUS')";
        $result = $this->db->insert($sqlInsert);
		return $result;
      }

	}

	public function showDataCvs(){
		$sql = "SELECT * FROM admitted_student  ORDER BY ADMITTED_STUDENT_ID DESC LIMIT 10";
		$result = $this->db->select($sql);
		return $result;
	}

	public function getAllExamPapers($exam_id){
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);
		$sql = "SELECT * FROM selected_course_view WHERE REGISTERED_EXAM_ID = '$exam_id' GROUP BY COURSE_CODE_TITLE";
		$result = $this->db->select($sql);
		return $result;
	}
	public function studentResultUploadByPapersId($column,$examIdChak,$paper_selection,$resultType){
		if(strlen($column[0]) > 5){
		  $divcolumn     = str_split($column[0]);
          $college_id    = $divcolumn[0];
          $subject_id    = $divcolumn[1].$divcolumn[2];
          $student_type  = $divcolumn[3];
          $student_rolls = $divcolumn[4].$divcolumn[5].$divcolumn[6].$divcolumn[7];
          $student_roll  = (int)$student_rolls;

          $columtow = $column[1];

          //echo '<script>alert("'.$paper_selection.'");</script>';

          $checkResult = "SELECT * FROM selected_course_view WHERE REGISTERED_COLLEGE_ID = $college_id AND SUBJECTS_ID = $subject_id AND REGISTERED_STUDENTS_TYPE =$student_type AND REGISTERED_STUDENTS_EXAM_ROLL = $student_roll AND REGISTERED_EXAM_ID = $examIdChak AND COURSE_CODE_TITLE_ID = $paper_selection";
          $resultRight = $this->db->select($checkResult);
          if ($resultRight) {

          	  $resultShow       = $resultRight->fetch_assoc();
              $STUDENT_ID       = $resultShow['REGISTERED_STUDENTS_ID'];

          	 if($resultType==1){
               $sqlUpdate = "UPDATE selected_courses SET general_result = $columtow WHERE REGISTERED_EXAM_ID = $examIdChak AND REGISTERED_STUDENTS_ID = $STUDENT_ID AND COURSE_CODE_TITLE_ID = $paper_selection";
             }elseif($resultType==2){
               $sqlUpdate = "UPDATE selected_courses SET practial_result = $columtow WHERE REGISTERED_EXAM_ID = $examIdChak AND REGISTERED_STUDENTS_ID = $STUDENT_ID AND COURSE_CODE_TITLE_ID = $paper_selection";
             }elseif($resultType==3){
               $sqlUpdate = "UPDATE selected_courses SET encoure_result = $columtow WHERE REGISTERED_EXAM_ID = $examIdChak AND REGISTERED_STUDENTS_ID = $STUDENT_ID AND COURSE_CODE_TITLE_ID = $paper_selection";
             }
             $update = $this->db->update($sqlUpdate);
		     return $update;

          }

		 }

	}

	public function getAllExamSubject($exam_id){
		$exam_id = mysqli_real_escape_string($this->db->link, $exam_id);

		$sql = "SELECT subjects.*,exam_view.PROGRAMS_ID,exam_view.REGISTERED_EXAM_ID FROM subjects JOIN exam_view ON subjects.PROGRAMS_ID = exam_view.PROGRAMS_ID WHERE exam_view.REGISTERED_EXAM_ID = '$exam_id' AND subjects.PROGRAMS_ID = exam_view.PROGRAMS_ID GROUP BY subjects.SUBJECTS_TITLE";
		$result = $this->db->select($sql);
		return $result;

	}

	public function subjectByPapersList($SUBJECTS_ID){
		$SUBJECTS_ID = mysqli_real_escape_string($this->db->link, $SUBJECTS_ID);

		$sql = "SELECT * FROM course_code_title WHERE SUBJECTS_ID = '$SUBJECTS_ID'";
		$result = $this->db->select($sql);
		return $result;
	}
	public function subjectByPapersListerr(){
		$sql = "SELECT * FROM course_code_title";
		$result = $this->db->select($sql);
		return $result;
	}
	public function checkSystemUpDown(){
		$sql = "SELECT * FROM system_settings ORDER BY id DESC LIMIT 1";
		$result = $this->db->select($sql);
		return $result;
	}
	public function  systemUpdate($system_id,$system_setting) {
		$system_id = mysqli_real_escape_string($this->db->link, $system_id);
		$system_setting = mysqli_real_escape_string($this->db->link, $system_setting);

		$upsql = "UPDATE system_settings SET system_setting = '$system_setting' WHERE id = '$system_id'";
		$result = $this->db->update($upsql);
		return $result;
	}

	public function studentResultViewByPapersId($examIdChak,$subject_select_v) {

		$examIdChak = mysqli_real_escape_string($this->db->link, $examIdChak);
		$subject_select_v = mysqli_real_escape_string($this->db->link, $subject_select_v);

		$sql = "SELECT sv.ADMITTED_STUDENT_NAME,scv.REGISTERED_STUDENTS_EXAM_ROLL,sv.ADMITTED_STUDENT_REG_NO,sv.SESSION_NAME,scv.REGISTERED_STUDENTS_TYPE,scv.REGISTERED_STUDENTS_ID,sv.REGISTERED_COLLEGE_ID,sv.SUBJECTS_ID FROM students_view as sv, selected_course_view as scv WHERE sv.SUBJECTS_ID = $subject_select_v AND sv.ADMITTED_STUDENT_ID = scv.ADMITTED_STUDENT_ID AND scv.REGISTERED_EXAM_ID = $examIdChak AND scv.SUBJECTS_ID = $subject_select_v AND scv.REGISTERED_STUDENTS_COLLEGE_VERIFY = 1 GROUP BY scv.ADMITTED_STUDENT_ID";


       $result = $this->db->select($sql);
	   return $result;
	}
	public function getSubjectPapers($subject_select_v) {
		$subject_select_v = mysqli_real_escape_string($this->db->link, $subject_select_v);

		$sql = "SELECT * FROM course_code_title WHERE SUBJECTS_ID = $subject_select_v";
		$result = $this->db->select($sql);
		return $result;
	}
	public function getPapersCodewithResult($course_code_t_id,$REGISTERED_STUDENTS_ID,$examIdChak){
		try {
		 $course_code_t_id       = $this->fm->validation($course_code_t_id);
	     $REGISTERED_STUDENTS_ID = $this->fm->validation($REGISTERED_STUDENTS_ID);
	     $examIdChak             = $this->fm->validation($examIdChak);
	     $course_code_t_id       = mysqli_real_escape_string($this->db->link, $course_code_t_id);
	     $REGISTERED_STUDENTS_ID = mysqli_real_escape_string($this->db->link, $REGISTERED_STUDENTS_ID);
	     $examIdChak             = mysqli_real_escape_string($this->db->link, $examIdChak);
		 $sql = "SELECT * FROM selected_courses WHERE REGISTERED_STUDENTS_ID = $REGISTERED_STUDENTS_ID AND REGISTERED_EXAM_ID = $examIdChak AND COURSE_CODE_TITLE_ID = $course_code_t_id";
		 $result = $this->db->select($sql);
		 return $result;
		} catch (Exception $e) {

		}
	}

	public function updatePaperbyResult($paper_code_t_id,$student_id_paper,$examId_paper,$paperbyresult,$ppbypractical,$ppbyincourse) {

    $paper_code_t_id = mysqli_real_escape_string($this->db->link, $paper_code_t_id);
    $student_id_paper = mysqli_real_escape_string($this->db->link, $student_id_paper);
    $examId_paper = mysqli_real_escape_string($this->db->link, $examId_paper);
    $paperbyresult = mysqli_real_escape_string($this->db->link, $paperbyresult);
    $ppbypractical = mysqli_real_escape_string($this->db->link, $ppbypractical);
    $ppbyincourse = mysqli_real_escape_string($this->db->link, $ppbyincourse);

		$sqlOld = "SELECT * FROM selected_courses WHERE COURSE_CODE_TITLE_ID = '$paper_code_t_id' AND REGISTERED_EXAM_ID = '$examId_paper' AND REGISTERED_STUDENTS_ID = '$student_id_paper'";
		$oldResults = $this->db->select($sqlOld);
		if($oldResults){
			$resultOld   = $oldResults->fetch_assoc();
			$generalRes  = $resultOld['general_result'];
			$practialRes = $resultOld['practial_result'];
			$incorseRes  = $resultOld['encoure_result'];
		}

		if(empty($paper_code_t_id) || empty($student_id_paper) || empty($examId_paper)){
           echo "<span style='color:red;font-weight: bold;'>Field must not be Empty!</span>";
		}else{
		$sqlup = "UPDATE selected_courses
		                 SET
		         general_result  = '$paperbyresult',
		         practial_result = '$ppbypractical',
		         encoure_result  = '$ppbyincourse'
		       WHERE COURSE_CODE_TITLE_ID = '$paper_code_t_id' AND REGISTERED_EXAM_ID = '$examId_paper' AND REGISTERED_STUDENTS_ID = '$student_id_paper'";
		$result = $this->db->update($sqlup);
		if ($result) {
			echo "<span style='color:green;font-weight: bold;'>Result Update Successfully!</span>";

			$log_message = '<span style="color:red;font-weight:bold;">Result Updated Student </span> id='.$student_id_paper.', Exam id='.$examId_paper.', Paper Code Title id='.$paper_code_t_id.' Course Finel '.$generalRes.' New <span style="color:red;font-weight: bold;">'.$paperbyresult.'</span>, Practial '.$practialRes.' New <span style="color:red;font-weight: bold;">'.$ppbypractical.'</span> and Incourse '.$incorseRes.' New <span style="color:red;font-weight: bold;">'.$ppbyincourse.'</span> .';
			$this->log_insert($log_message);
		}else{
			echo "<span style='color:red;font-weight: bold;'>Result not Updated!</span>";
		}
		//return $result;
	  }
	}

	public function examNameByRegisterExam($examIdChak){
		$examIdChak = mysqli_real_escape_string($this->db->link, $examIdChak);

		$exam_query="SELECT * FROM `exam_view` WHERE REGISTERED_EXAM_ID = '$examIdChak'";
		$result = $this->db->select($exam_query);
		return $result;
	}

	public function resetStudentAccountById($resid){
		  $resid = mysqli_real_escape_string($this->db->link, $resid);

      $sql = "UPDATE admitted_student SET ACCOUNT_CREATE_STATUS = 0 WHERE ADMITTED_STUDENT_ID = '$resid'";
      $result = $this->db->update($sql);
      if ($result) {
      	echo '<div class="alert alert-success">Reset Successfully!</div>';
      } else{
      	echo '<div class="alert alert-danger"> Something went Wrong!</div>';
      }
	}

	public function getProgramsData() {
		try {
			$sql = "SELECT * FROM programs WHERE PROGRAMS_STATUS = 1 ORDER BY PROGRAMS_ID ASC";
			$result = $this->db->select($sql);
			return $result;
		} catch (Exception $e) {

		}
	}

	public function getResultPublishList($exam_id){

	   try {

	  	$examid = $this->fm->validation($exam_id);
	    $examid = mysqli_real_escape_string($this->db->link, $examid);

	     $sql = "SELECT subjects.* FROM subjects JOIN course_year ON subjects.SUBJECTS_ID = course_year.SUBJECTS_ID
	     JOIN registered_exam ON course_year.COURSE_YEAR_ID = registered_exam.COURSE_YEAR_ID
	     WHERE registered_exam.REGISTERED_EXAM_ID = '$examid'";

	    //$sql = "SELECT * FROM subjects";
	    $result = $this->db->select($sql);
	    if ($result) {
	    	$output = '<table class="table table-bordered table-striped"><thead><tr><th>No</th><th>Subject</th><th>Action</th></tr></thead><tbody><tr>';
	    	$i = 0;
	    	while ($row = $result->fetch_assoc()) {
                $i++;
	    		$subject_id = $row['SUBJECTS_ID'];
	    		$subject_title = $row['SUBJECTS_TITLE'];

	    		$sqlck = "SELECT * FROM result_publish WHERE result_publish_status = 1 AND subject_id = '$subject_id' AND exam_id = '$examid' LIMIT 1";
	    		$resultck = $this->db->select($sqlck);
	    		if ($resultck) {
	    			$rprow = $resultck->fetch_assoc();
	    			$rpid = $rprow['id'];
                   $output .= '<td>'.$i.'</td><td>'.$subject_title.'</td><td><a data-respubid="'.$rpid.'" href="#" class="btn btn-info click_get_subjectid"> Unpublish</a></td>';

	    		}

	    	}
	    	$output .= '</tr></tbody></table>';
	    	return $output;
	    }

	  } catch (Exception $e) {
	  	$msg = "<div class='alert alert-danger'>Something went Wrong.</div>";
	  	return $msg;
	  }
	}

	public function addResultPublishBySubject($examid,$subject_id,$rp_date){

	    try {

	    $examid     = $this->fm->validation($examid);
	    $subject_id = $this->fm->validation($subject_id);
	    $rp_date    = $this->fm->validation($rp_date);
		$examid     = mysqli_real_escape_string($this->db->link, $examid);
		$subject_id = mysqli_real_escape_string($this->db->link, $subject_id);
		$rp_date    = mysqli_real_escape_string($this->db->link, $rp_date);

		if (empty($examid) || empty($subject_id) || empty($rp_date)) {
			$msg = '<div class="alert alert-danger">Field must not be Empty.</div>';
			return $msg;
		} elseif (strlen($subject_id) > 10) {
			$msg = '<div class="alert alert-danger"> Subject Id too Long. </div>';
			return $msg;
		} elseif (strlen($rp_date) > 20) {
			$msg = '<div class="alert alert-danger"> Publish Date is too Long. </div>';
			return $msg;
		} else {

         	$sql = "INSERT INTO result_publish (exam_id,subject_id,result_publish_date,result_publish_status) VALUES('$examid','$subject_id','$rp_date','1')";
         	$result = $this->db->insert($sql);
					$resultupdate;


         	if ($result) {
         		$sqlck = "SELECT registered_students.* FROM registered_students JOIN admitted_student ON registered_students.ADMITTED_STUDENT_ID = admitted_student.ADMITTED_STUDENT_ID WHERE admitted_student.SUBJECTS_ID = '$subject_id'  AND registered_students.REGISTERED_EXAM_ID = '$examid'";
         		$getck = $this->db->select($sqlck);

         		// if ($getck) {
         		// 	while ($rowsc = $getck->fetch_assoc()) {
						//
         		// 		$REGISTERED_STUDENTS_ID = $rowsc['REGISTERED_STUDENTS_ID'];
         		// 		$ADMITTED_STUDENT_ID    = $rowsc['ADMITTED_STUDENT_ID'];
						//
            //             $upsql = "UPDATE registered_students SET RESULT_PUBLISH_DATE = '$rp_date' WHERE REGISTERED_STUDENTS_ID = '$REGISTERED_STUDENTS_ID' AND ADMITTED_STUDENT_ID = '$ADMITTED_STUDENT_ID' AND REGISTERED_EXAM_ID = '$examid'";
            //             $resultupdate = $this->db->update($upsql);
         		// 	}
         		// }

         		if ($result) {
                  $msg = '<div class="alert alert-success"> Result Publish Successfully. </div><script>
                setTimeout(function(){ window.location.href=""; }, 3000); </script>';
 		          return $msg;
                } else{
	         		$msg = '<div class="alert alert-danger"> Result not Published. </div>';
				    return $msg;
	         	}

         	} else{
         		$msg = '<div class="alert alert-danger"> Result not Published. </div>';
			    return $msg;
         	}
		}

	    } catch (Exception $e) {
	    	$msg = "<div class='alert alert-danger'>Something went Wrong.</div>";
			return $msg;
	    }
	}

	public function resultPublishDeleteByID($respubid,$examid) {

	 try {

		$expr = '/^[1-9][0-9]*$/';

        $respubid = $this->fm->validation($respubid);
        $examid    = $this->fm->validation($examid);
	    $respubid = mysqli_real_escape_string($this->db->link, $respubid);
	    $examid    = mysqli_real_escape_string($this->db->link, $examid);

	    if (empty($respubid) || empty($examid)) {
	    	echo '<div class="alert alert-danger"> Something went worng! </div>';
	    } else if ((preg_match($expr, $respubid) && filter_var($respubid, FILTER_VALIDATE_INT)) || (preg_match($expr, $examid) && filter_var($examid, FILTER_VALIDATE_INT)) ) {
          $sql = "DELETE FROM result_publish WHERE exam_id = '$examid' AND id = '$respubid'";
          $result = $this->db->delete($sql);
          if ($result) {
          	echo '<div class="alert alert-success"> Unpublish Successfully! </div>';
          	echo '<script>
                setTimeout(function(){ window.location.href=""; }, 3000);
          	</script>';
          } else{
            echo '<div class="alert alert-danger"> Something went worng! </div>';
          }
		  } else {
		   echo '<div class="alert alert-danger"> Something went worng! </div>';
		}

		} catch (Exception $e) {
			echo "<div class='alert alert-danger'>Something went Wrong.</div>";
		}

	}

/*	public function getsdfdfge(){
		$sql = "SELECT ADMITTED_STUDENT_ID, ADMITTED_STUDENT_NAME, ADMITTED_STUDENT_FATHERS_N, ADMITTED_STUDENT_ADDRESS FROM admitted_student2";
		$result = $this->db->select($sql);
		return $result;
	}
	public function getShowresult(){
		$sql = "SHOW columns FROM admitted_student2";
		$result = mysqli_query($this->db->link, $sql);
	  return $result;

	}*/


	public function newRollGenerate(){
		try {
			$sql = "SELECT * FROM registered_college WHERE REGISTERED_COLLEGE_STATUS = 1 ORDER BY REGISTERED_COLLEGE_ID ASC";
			$result = $this->db->select($sql);
			//$i = 1662; EXAM One
			$i = 1;
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$REGISTERED_COLLEGE_ID = $row['REGISTERED_COLLEGE_ID'];

               $sdfd = "SELECT max(REGISTERED_STUDENTS_EXAM_ROLL) AS max_roll FROM registered_students WHERE REGISTERED_STUDENTS_COLLEGE_VERIFY = 1";
            		$dfgdfsg = $this->db->select($sdfd);
            		if ($dfgdfsg) {
            			$sfsdf = $dfgdfsg->fetch_assoc();
            		   $roll_num = $sfsdf['max_roll'];
            		}

					$csql = "SELECT registered_students.* FROM admitted_student JOIN registered_students ON registered_students.ADMITTED_STUDENT_ID = admitted_student.ADMITTED_STUDENT_ID WHERE registered_students.REGISTERED_STUDENTS_COLLEGE_VERIFY = 1 AND registered_students.REGISTERED_EXAM_ID = 1 AND admitted_student.REGISTERED_COLLEGE_ID = '$REGISTERED_COLLEGE_ID' AND admitted_student.ACCOUNT_CREATE_STATUS = 1 AND admitted_student.ADMITTED_STUDENT_STATUS = 1 ORDER BY registered_students.sub_count DESC";
                    $cresult = $this->db->select($csql);

                    if ($cresult) {
                    	while ($urow = $cresult->fetch_assoc()) {
                    		//$roll_num = $urow['REGISTERED_STUDENTS_EXAM_ROLL'];

                    		$REGISTERED_STUDENTS_ID = $urow['REGISTERED_STUDENTS_ID'];
                    		$ADMITTED_STUDENT_ID = $urow['ADMITTED_STUDENT_ID'];
                    		$REGISTERED_EXAM_ID = $urow['REGISTERED_EXAM_ID'];

                    		/*$csubsql = "SELECT COUNT(SELECTED_COURSES_ID) AS TOTAL_SUB FROM selected_courses WHERE REGISTERED_STUDENTS_ID = '$REGISTERED_STUDENTS_ID'";
                    		$csubresult = $this->db->select($csubsql);
                            if ($csubresult) {
                            	while ($csubrow = $csubresult->fetch_assoc()) {
                            		 $sub_count = $csubrow['TOTAL_SUB'];

                            		 $updsql = "UPDATE registered_students SET sub_count = '$sub_count' WHERE REGISTERED_STUDENTS_ID = '$REGISTERED_STUDENTS_ID' AND REGISTERED_EXAM_ID = '$REGISTERED_EXAM_ID'";
                                     $updds = $this->db->update($updsql);
                            	}
                            }*/




			            		if ($roll_num != 0) {
                    			   $roll_num += 1;
	                    		} else{
	                    			$roll_num = 1;
	                    		}

	                    		$roll_num."<br>";

                    		$updsql = "UPDATE registered_students SET REGISTERED_STUDENTS_EXAM_ROLL = $i WHERE REGISTERED_EXAM_ID = 1 AND REGISTERED_STUDENTS_ID = '$REGISTERED_STUDENTS_ID'";
                             $updds = $this->db->update($updsql);



                          $i +=1;

                    	}

                    }


				}
			}
			 $i;
		} catch (Exception $e) {

		}
	}





}
