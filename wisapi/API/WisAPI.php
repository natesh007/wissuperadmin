<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); //
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mpdf\Mpdf;
require "../utilities/vendor/autoload.php";
//test
use \Firebase\JWT\JWT;

define('SiteURL', 'https://igreen.systems/wissuperadmin/');

require_once("../utilities/Rest.inc.php");
require_once("../utilities/class.MySQL.php");
require_once("../utilities/functions.php");
class WisAPI extends REST
{
	private $db;
	private $appSecret = "dfhfhfi&9)jnd%sndn&565ggghGGdedj*nsn&jsdnjdnj";
	private $jwtPassThroughRoutes = array("logout","test","editemployee","addemployee","employees","alldepartments","branches","adddepartment","editdepartment","departments","jobtitles","complaintcategory");
	private $logIndex = 0;
	private $EmpID = 0;
	private $EmailID = '';
	private $OrgID = '';
	private $FBTokenID = '';
	public function __construct()
	{
		parent::__construct();				// Init parent contructor
		$this->db = new MySQL();    // Initiate Database connection			
	}
	/*
	 * Public method for access api.
	 * This method dynmically call the method based on the query string
	 *
	 */
	public function processApi()
	{
		$func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
		//$func = strtolower(trim($this->_request['commandToExecute']));
		$params = print_r($this->_request, true);
		$this->logIndex = $this->logRequest($func, $params);
		if ((int)method_exists($this, $func) > 0) {
			if (in_array(strtolower($func), array_map("strtolower", $this->jwtPassThroughRoutes))) {
				$var = $this->validateUser();
				if ($var === 1) {
					$this->$func();
				} else {
					$this->errorMSG(400, "There is some technical error while processing your token. Please try again later.");
				}
			} else {
				$this->$func();
			}
		} else
	        
			$this->errorMSG(404, "Function not found");	// If the method not exist with in this class, response would be "Page not found".			
	}
	private function logRequest($fname, $params)
	{
		try {
			$query = "INSERT INTO logs(functionName,request,dateAdded) VALUES(			
			'" . mysqli_real_escape_string($this->db->mysql_link, $fname) . "',
			'" . mysqli_real_escape_string($this->db->mysql_link, $params) . "',
			'" . date('Y-m-d H:i:s') . "');";
			if ($this->db->executeQuery($query)) {
				return $this->db->getLastInsertID();
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}
	function logResponse($status, $response)
	{
		try {
			if ($this->logIndex == 0) return;
			$query = "UPDATE logs 
			SET `status`='" . mysqli_real_escape_string($this->db->mysql_link, $status) . "', 
			`response`='" . mysqli_real_escape_string($this->db->mysql_link, print_r($response, true)) . "' 
			WHERE logIndex='" . mysqli_real_escape_string($this->db->mysql_link, $this->logIndex) . "'";
			if ($this->db->executeQuery($query)) {
			} else {
			}
		} catch (Exception $e) {
		}
	}
	/*
	 *	API Test functions
	 */
	private function test()
	{
		echo  $this->EmpID;
		exit;
	}
	private function verifyTokentest()
	{
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$var = $this->validateUser();
		$this->successMSG('Varify token', $this->EmpID);
	}
	/*
	 *	Create Validate Verification of Token
	*/
	private function validateUser()
	{
		$token = $this->getBearerToken();
		if ($token != '') {
			$data = $this->verifyJWToken($token, $this->appSecret);
			if ($data->data->EmpID != '') {
				$var = $this->authenticateUser($data);
			} else {
				$this->errorMSG(400, "Not a valid token..!");
			}
			return $var;
		} else {
			$this->errorMSG(400, "AccessToken missed in the request..!");
		}
	}
	private function authenticateUser($data)
	{
		if ($this->db->hasRecords("SELECT * FROM `employees` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->EmpID) . "' AND EmailID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->EmailID) . "' AND OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->OrgID) . "';")) {
			$this->EmpID = $data->data->EmpID;
			$this->EmailID = $data->data->EmailID;
			$this->OrgID = $data->data->OrgID;
			$this->FBTokenID = $data->data->FBTokenID;
			return 1;
		} else {
			$this->errorMSG(401, "Authentication Failed.!");
		}
	}
	private function getJWToken($userIndex, $email, $org, $FBTokenID, $secret)
	{
		$token = array(
			"iss" => "http://igreen.systems",
			"aud" => "http://igreen.systems",
			"iat" => time(),
			"nbf" => time() + 0,
			"exp" => time() + 8640000,
			"data" => [                  	// Data related to the signer user
				'EmpID'   => $userIndex, 		// userIndex from the users table
				'EmailID' => $email,
				'OrgID' => $org,
				'FBTokenID' => $FBTokenID
			]
		);
		$jwt = JWT::encode($token, $secret);
		return $jwt;
	}
	private function revokeJWToken($userIndex, $email, $org, $FBTokenID, $secret)
	{
		$token = array(
			"iss" => "http://igreen.systems",
			"aud" => "http://igreen.systems",
			"iat" => time(),
			"nbf" => time() + 0,
			"exp" => time() + 8640000,
			"data" => [                  	// Data related to the signer user
				'EmpID'   => $userIndex, 		// userIndex from the users table
				'EmailID' => $email, 	// email
				'OrgID' => $org,
				'FBTokenID' => $FBTokenID
			]
		);
		$jwt = JWT::encode($token, $secret);
		return $jwt;
	}
	private function verifyJWToken($token, $secret)
	{
		try {
			$data = JWT::decode($token, $secret, array('HS256'));
		} catch (Exception $e) {
			$this->errorMSG(400, $e->getMessage());
		}
		return $data;
	}
	private function getAuthorizationHeader()
	{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}
	private function getBearerToken()
	{
		$headers = $this->getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return $headers;
	}
	/*
	 *	Sign up module
	*/
	private function login()
	{
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$email = $this->_request['email'];
		$password = $this->_request['password'];
		
		// Input validations
		if (!empty($email) and !empty($password)) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$sql = "SELECT e.OrgID,e.JobTID,e.DeptID,e.EmpID,e.EmpName,e.EmailID,e.Contact,e.Password,e.Gender,e.Address,e.JobType,e.RoleID,e.Status,e.CreatedDate,e.UpdatedDate,e.DateOfJoining,e.PreviousExp,o.OrgName FROM employees as e LEFT JOIN roles as r
				ON r.RoleID = e.RoleID LEFT JOIN organization as o
				ON o.OrgID = e.OrgID WHERE e.EmailID = '" . mysqli_real_escape_string($this->db->mysql_link, $email) . "' AND e.Status=1";
				$this->db->executeQuery($sql);
				
				//echo $this->db->getLastSQLStatement();exit;
				if ($this->db->getRowsCount() == 1) {
					$row = $this->db->getCurrentRow();
					
				    if (md5($password)==$row->Password) {
					    
						if ($row->Status != "1") {
							$this->errorMSG(400, "Your account is temporarily suspended. Please contact administrator.");
						}
						if ($row->Status != "") {
						    
							$FBTokenID = 0;
							
							$jwt = $this->getJWToken($row->EmpID, $row->EmailID, $row->OrgID, $FBTokenID, $this->appSecret);
							$result = json_decode(json_encode($row), true);
							$result['accessToken'] = $jwt;
							$result['fb'] = $FBTokenID;
							$result  = filterUserData($result);
							//echo "<pre>";print_r($result);exit;
							$this->successMSG('Authentication Successful.!', $result);
							//exit;
						} else {
							$this->errorMSG(400, "There is some technical issue while processing your request. Please contact administrator");
						}
					} else {
						$this->errorMSG(400, "Invalid Password");
					}
				} else {
					$this->errorMSG(400, "User Does Not Exist");
				}
			} else {
				$this->errorMSG(400, "Invalid EmailId");
			}
		} else {
			$this->errorMSG(400, "No Content");
		}
	}
	
	private function logout()
	{
		if ($this->get_request_method() != "GET") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$userIndex = $this->EmpID;
		$email = $this->EmailID;
		$org = $this->OrgID;
		$FBTokenID = $this->FBTokenID;
		//exit;

		try {

			$sql1 = "DELETE FROM `fcmtokens` WHERE TokenID='" . mysqli_real_escape_string($this->db->mysql_link, $FBTokenID) . "'";

			if (!$this->db->executeQuery($sql1)) {



				$this->errorMSG(400, "There is a network error while processing your request. Please try again later..!");
			} else {



				$jwt = $this->revokeJWToken($userIndex, $email, $org, $FBTokenID, $this->appSecret);







				$result = array();







				$result[0]['accessToken'] = $jwt;







				$this->successMSG('', $jwt);
			}
		} catch (Exception $e) {



			$this->errorMSG(400, $e->getMessage());
		}
	}	
	
    function organizationslist()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT o.OrgID,o.OrgName FROM organization o left join organization_type ot on ot.TypeID=o.OrgType", MYSQLI_ASSOC);
			//	echo $this->db->getLastSQLStatement();exit;
		
		/// dropdown view
		/*foreach ($query1 as $q) {
			$items[$q['EmpID']] = $q['EmployeeName'];
		}*/
		$this->successMSG('Organizations list', $query1);
	}
	function branches()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT b.BrID,b.BrName,b.Address,b.BrLangitude,b.BrLatitude,b.Status,b.UpdatedBy,b.UpdatedDate,o.OrgName,o.OrgID FROM branches b left join organization o on o.OrgID=b.OrgID where b.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);
			//	echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Branches list', $query1);
	}

	function jobtitles()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT OrgID,JobTID,JobTitle FROM jobtitle where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Job Titles list', $query1);
	}
	function departments()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		//$OrgID = $this->_request['OrgID'];
		$OrgID = $this->OrgID;
		$BrID = $this->_request['BrID'];
		$branches = explode(',',$BrID);
		
		
		if ($BrID == '') {
			$this->errorMSG(400, "Please enter Branch ID");
		}

		$query = $this->db->executeQueryAndGetArray("SELECT DeptID,DeptName,ParentDept FROM departments where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND BrID IN (".$BrID.")  AND ParentDept = '0' order by DeptID DESC", MYSQLI_ASSOC);
			
				//echo $this->db->getLastSQLStatement();exit;
			//$query = $this->db->executeQueryAndGetArray("SELECT DeptID,DeptName FROM departments where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND BrID IN (".$BrID.") AND ParentDept = 0 order by DeptID DESC", MYSQLI_ASSOC);

			foreach ($query as $rec) {
				$query1 = $this->db->executeQueryAndGetArray("SELECT DeptID,DeptName,ParentDept FROM departments WHERE ParentDept ='" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "'", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();echo "<br>";
				$ri = [];
				foreach ($query1 as $rec1) {
					$ri[] = array(
					"DeptID" =>  $rec1['DeptID'],
					"DeptName" => $rec1['DeptName'],
					"ParentDept" =>  $rec1['ParentDept'],
					);
				}
				$subdept = $ri;
				$r[] = array(
					"DeptID" =>  $rec['DeptID'],
					"DeptName" => $rec['DeptName'],
					"ParentDept" => $rec['ParentDept'],
					"Subdeparts" => $subdept
				);
			}
		//	$data['data'] = $query;
			
		$this->successMSG('Department list', $r);
	}
	function alldepartments()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;		
	    $DeptName = $this->_request['DeptName'];
		$BrID = $this->_request['BrID'];
		$SortType = $this->_request['SortType'];//branch,department
		//$query = $this->db->executeQueryAndGetArray("SELECT DeptID,DeptName FROM departments where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND BrID IN (".$BrID.") order by DeptID DESC", MYSQLI_ASSOC);

        $sql = "SELECT d.BrID,d.DeptID,d.DeptName,d.ParentDept,b.BrName,d.Status,dd.DeptName as ParentName FROM departments d left join departments dd on dd.DeptID = d.ParentDept left join branches b on b.BrId = d.BrId  where d.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'";
        
		//$sql = "SELECT d.BrID,d.DeptID,d.DeptName,d.ParentDept,dd.DeptName as ParentName,b.BrName,d.Status FROM departments d left join departments dd on dd.ParentDept = d.DeptID left join branches b on b.BrId = d.BrId  where d.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'";
		if($DeptName != ''){
			$sql.="AND d.DeptName like '%". $DeptName . "%'";
		}
		if($BrID != ''){
			$sql.="AND d.BrID = '" . mysqli_real_escape_string($this->db->mysql_link, $BrID) . "' ";
		}
		if($SortType != ''){
			if($SortType == 'branch'){
				$sql.=" order by b.BrName ASC";
			}
			if($SortType == 'department'){
				$sql.=" order by d.DeptName ASC";
			}
		}

		//echo $sql;exit;
		$query = $this->db->executeQueryAndGetArray($sql, MYSQLI_ASSOC);
		
			//echo $this->db->getLastSQLStatement();exit;
			/*foreach ($query as $rec) {
				$query1 = $this->db->executeQueryAndGetArray("SELECT DeptID,DeptName FROM departments WHERE ParentDept ='" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "'", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();echo "<br>";
				$ri = [];
				foreach ($query1 as $rec1) {
					$ri[] = array(
					"DeptID" =>  $rec1['DeptID'],
					"DeptName" => $rec1['DeptName']
					);
				}
				$subdept = $ri;
				$r[] = array(
					"DeptID" =>  $rec['DeptID'],
					"DeptName" => $rec['DeptName'],
					"Subdeparts" => $subdept
				);
			}
			$data['data'] = $r;*/
			
		$this->successMSG('Department list', $query);
	}

	function employees(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		$DeptID = $this->_request['DeptID'];
		$JobTID = $this->_request['JobTID'];
		$JoiningDate = $this->_request['JoiningDate'];

		if($DeptID != ''){
			$query = $this->db->executeQueryAndGetArray("SELECT OrgID,DeptID,DeptName from departments where OrgID = '" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND ParentDept = 0 AND DeptID = '" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'", MYSQLI_ASSOC);
		}else{
			$query = $this->db->executeQueryAndGetArray("SELECT OrgID,DeptID,DeptName from departments where OrgID = '" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND ParentDept = 0", MYSQLI_ASSOC);
		}
		

		foreach($query as $rec){
			$sql = "SELECT * FROM((SELECT e.EmpID,e.EmpName,e.DeptID,e.JobTID,e.Gender,e.EmailID,e.Address,e.Contact,e.JobType,e.DateOfJoining,ex.Experience as exp,ex.Exp_Desc as PreviousExperience,e.Status,e.CreatedDate,e.UpdatedDate,d.DeptName,j.JobTitle from employees e left join departments d on d.DeptID = e.DeptID left join jobtitle j on j.JobTID = e.JobTID left join experience ex on ex.ExeID = e.PreviousExp where e.DeptID = '" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "') UNION (SELECT e.EmpID,e.EmpName,e.DeptID,e.JobTID,e.Gender,e.EmailID,e.Address,e.Contact,e.JobType,e.DateOfJoining,ex.Experience as exp,ex.Exp_Desc as PreviousExperience,e.Status,e.CreatedDate,e.UpdatedDate,d.DeptName,j.JobTitle from employees e left join departments d on d.DeptID = e.DeptID left join jobtitle j on j.JobTID = e.JobTID left join experience ex on ex.ExeID = e.PreviousExp WHERE e.DeptID IN(SELECT d.DeptID FROM departments d WHERE d.ParentDept = '" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "'))) AS N";
			if($JobTID != ''){
				$sql.=" WHERE N.JobTID = '" . mysqli_real_escape_string($this->db->mysql_link, $JobTID) . "'";
				if($JoiningDate!='' && $JobTID != ''){
					if($JoiningDate=="1"){
						$sql.=" AND N.DateOfJoining BETWEEN  CURDATE() - INTERVAL 6 MONTH AND CURDATE()";
					}
					if($JoiningDate=="2"){
						$sql.=" AND N.DateOfJoining BETWEEN  CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
					}
					if($JoiningDate=="3"){
						$sql.= "";
					}
				}
			}
			if($JoiningDate!='' && $JobTID == ''){
				if($JoiningDate=="1"){
					$sql.=" WHERE N.DateOfJoining BETWEEN  CURDATE() - INTERVAL 6 MONTH AND CURDATE()";
				}
				if($JoiningDate=="2"){
					$sql.=" WHERE N.DateOfJoining BETWEEN  CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
				}
				if($JoiningDate=="3"){
					$sql.= "";
				}
			}
			
			
			//echo $sql;exit;
			$query1 = $this->db->executeQueryAndGetArray($sql, MYSQLI_ASSOC);
			//$query1 = $this->db->executeQueryAndGetArray($sql, MYSQLI_ASSOC);
			//echo $this->db->getLastSQLStatement();exit;
			

			$ri=[];
			foreach($query1 as $rec1){
				if($rec1['DateOfJoining']!="0000-00-00"){
					$origin = new DateTime($rec1['DateOfJoining']);
					$target = new DateTime(date('Y-m-d'));
					$interval = $origin->diff($target);
					if($interval->format('%y')!=0){
						$rec1['Experience']=$interval->format('%y Year');
					}else if($interval->format('%m')!=0){
						$rec1['Experience']=$interval->format('%m Month');
					}else{
						$rec1['Experience']=0;
					}
				}else{
					$rec1['Experience'] = "0";
				}
				$ri[] = $rec1;
			}

			
			
			if(!empty($query1)){
				$data[]=array(
					"DeptID" => $rec['DeptID'],
					"DeptName" => $rec['DeptName'],
					"Employees" => $ri
				);
			}
			
		}

		//exit;
		$this->successMSG('Employees list', $data);
		
	}

	function complaintcategory()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT cco.ComCatID,cc.CategoryName,cco.OrgID,cc.CategoryIcon FROM complaintcategoryorganizations cco left join complaintcategory cc on cc.ComCatID = cco.ComCatID where cco.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);
		foreach($query1 as $rec){
			$r[] = array(
				"ComCatID" => $rec['ComCatID'],
				"CategoryName" => $rec['CategoryName'],
				"OrgID" => $rec['OrgID'],
				"CategoryIcon" => SiteURL.$rec['CategoryIcon']

			);
		}
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Complaint Category list', $r);
	}

	function roles()
	{
		$query1 = $this->db->executeQueryAndGetArray("SELECT RoleID,RoleName FROM roles", MYSQLI_ASSOC);
		//"1"=>"Order Created","2"=>"In-Progress","3"=>"Ready","4"=>"Delivered"
		foreach ($query1 as $q) {
			$items[$q['RoleID']] = $q['RoleName'];
		}
		$this->successMSG('Roles list', $items);
	}
	
	function addemployee(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

       // echo $this->EmpID;exit;
	   	$UserIndex = $this->_request['UserIndex'];
		$EmpName = $this->_request['EmpName'];
		$OrgID = $this->OrgID;
		$BrID = $this->_request['BrID'];
		$DeptID = $this->_request['DeptID'];
		$JobTID = $this->_request['JobTID'];
		$Email = $this->_request['Email'];
		$Gender = $this->_request['Gender'];
		$Mobile = $this->_request['Mobile'];
		$DateOfJoining = $this->_request['DateOfJoining'];
		$JobType = $this->_request['JobType'];
		$Address = $this->_request['Address'];
		$PreviousExp = $this->_request['PreviousExp'];
		$branches = explode(",",$BrID);
		if ($EmpName == '') {
			$this->errorMSG(400, "Please enter Employee Name.");
		}
		if ($Email == '') {	
			$this->errorMSG(400, "Please enter Email.");
		} else {
			if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			} else {
				$this->errorMSG(400, "Invalid EmailId");
			}
		}
		if ($DeptID == '') {
			$this->errorMSG(400, "Please enter Department.");
		}
		if ($BrID == '') {
			$this->errorMSG(400, "Please enter Branches.");
		}
		if ($JobTID == '') {
			$this->errorMSG(400, "Please enter Job Title.");
		}
		if ($Mobile == '') {
			$this->errorMSG(400, "Please enter Mobile.");
		}

	//	$Mobile = '+91' . $Mobile;


		if ($this->db->hasRecords("SELECT * FROM `employees` WHERE EmailID='" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "' AND Status=1;")) {
			$this->errorMSG(400, "Not Available. Email Already Registered");
		} else {
			try {

				//$OrgID = $this->db->getFirstRowFirstColumn("SELECT `OrgID` FROM `departments` WHERE `DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "';");
				

				$this->db->executeQuery("INSERT INTO `employees`(`RoleID`,`EmpName`,`DeptID`, `OrgID`,`JobTID`,`Gender`, `EmailID`, `Password`, `Address`, `Contact`, `JobType`,`DateOfJoining`,`PreviousExp`,`Status`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('0','" . mysqli_real_escape_string($this->db->mysql_link, $EmpName) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $JobTID) . "'
				,
				'" . mysqli_real_escape_string($this->db->mysql_link, $Gender) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, md5("123456")) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $Address) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $Mobile) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $JobType) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $DateOfJoining) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $PreviousExp) . "',
				'1',
				'" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "','" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "')");
				//echo $this->db->getLastSQLStatement();exit;
				$empid = $this->db->getLastInsertID();
				if(!empty($branches)){
					for($i=0;$i<count($branches);$i++){
						
						$this->db->executeQuery("INSERT INTO `employeebranches`(`EmpID`,`BrID`,`CreatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $empid) . "','" . mysqli_real_escape_string($this->db->mysql_link, $branches[$i]) . "','" . date('Y-m-d H:i:s') . "')");
					}
				}
				$this->successMSG('Employee Added Succesfully..!', '');
				
			} catch (Exception $e) {
				$this->db->rollbackTransaction();
				$this->errorMSG(400, $e->getMessage());
			}
		}
	}

	function getemployee()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$EmpID = $this->_request['EmpID'];
		if ($EmpID == '') {
			$this->errorMSG(400, "Please enter Employee ID");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT e.OrgID,e.JobTID,e.DeptID,e.EmpID,e.EmpName,e.EmailID,e.Contact,e.Gender,e.Address,e.JobType,e.Contact,e.RoleID,e.Status,e.CreatedDate,e.UpdatedDate,e.PreviousExp,e.DateOfJoining FROM employees e where e.EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'", MYSQLI_ASSOC);
		
		$query2 = $this->db->executeQueryAndGetArray("SELECT * FROM employeebranches where EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'", MYSQLI_ASSOC);
		
		foreach($query2 as $q){
			$brs[]=$q['BrID'];
		}
		$Brid=implode(",",$brs);
		$items = array();
		foreach($query1 as $qu){
			$items[] = array(
				"OrgID" => $qu['OrgID'],
				"JobTID" => $qu['JobTID'],
				"DeptID" => $qu['DeptID'],
				"EmpID" => $qu['EmpID'],
				"EmpName" => $qu['EmpName'],
				"EmailID" => $qu['EmailID'],
				"Mobile" => $qu['Contact'],
				"Gender" => $qu['Gender'],
				"Address" => $qu['Address'],
				"JobType" => $qu['JobType'],
				"CreatedDate" => $qu['CreatedDate'],
				"Status" => $qu['Status'],
				"PreviousExp" => $qu['PreviousExp'],
				"DateOfJoining" => $qu['DateOfJoining'],
				"UpdatedDate" => $qu['UpdatedDate'],
				"BrID" => $Brid
			);
		}
		
		$this->successMSG('Employee Data', $items);
	}

    function getdepartment()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$DeptID = $this->_request['DeptID'];
		if ($DeptID == '') {
			$this->errorMSG(400, "Please enter Deparment ID");
		}
		if (!$this->db->hasRecords("SELECT * FROM `departments` WHERE DeptID='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'")) {
			//echo $this->db->getLastSQLStatement();exit;
			$this->errorMSG(400, "Not Available. Department Not Registered");
		} else {
		    $query1 = $this->db->executeQueryAndGetArray("SELECT b.BrName,d.DeptID,d.ParentDept,d.BrID,d.DeptName,d.Status,d.CreatedDate,d.UpdatedDate FROM departments d left join branches b on b.BrID = d.BrID where d.DeptID='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'", MYSQLI_ASSOC);
	    	//echo $this->db->getLastSQLStatement();exit;
	    
	    	$this->successMSG('Department Data', $query1);
		}
	}	
	

	function editemployee(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

		$EmpID = $this->_request['EmpID'];
		$EmpName = $this->_request['EmpName'];
		$OrgID = $this->OrgID;
		$BrID = $this->_request['BrID'];
		$DeptID = $this->_request['DeptID'];
		$JobTID = $this->_request['JobTID'];
		$Email = $this->_request['Email'];
		$Gender = $this->_request['Gender'];
		$Mobile = $this->_request['Mobile'];
		$DateOfJoining = $this->_request['DateOfJoining'];
		$PreviousExp = $this->_request['PreviousExp'];
		$JobType = $this->_request['JobType'];
		$Address = $this->_request['Address'];
		$branches = explode(",",$BrID);
		if ($EmpID == '') {
			$this->errorMSG(400, "Please enter Employee ID.");
		}
		if ($EmpName == '') {
			$this->errorMSG(400, "Please enter Employee Name.");
		}
		if ($Email == '') {	
			$this->errorMSG(400, "Please enter Email.");
		} else {
			if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			} else {
				$this->errorMSG(400, "Invalid EmailId");
			}
		}
		if ($DeptID == '') {
			$this->errorMSG(400, "Please enter Department.");
		}
		if ($BrID == '') {
			$this->errorMSG(400, "Please enter Branches.");
		}
		if ($JobTID == '') {
			$this->errorMSG(400, "Please enter Job Title.");
		}
		if ($Mobile == '') {
			$this->errorMSG(400, "Please enter Mobile.");
		}
		
		$DBEmailID = $this->db->getFirstRowFirstColumn("SELECT `EmailID` FROM `employees` WHERE `EmpID`= '" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';");
	    if($DBEmailID != $Email){
	        	if ($this->db->hasRecords("SELECT * FROM `employees` WHERE EmailID='" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "'")) {
    			//echo $this->db->getLastSQLStatement();exit;
    			$this->errorMSG(400, "Email Already exist!");
    		    }
	    }
	    
		//$Mobile = '+91' . $Mobile;
		if (!$this->db->hasRecords("SELECT * FROM `employees` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'")) {
			//echo $this->db->getLastSQLStatement();exit;
			$this->errorMSG(400, "Not Available. Employee Not Registered");
		} else {
			try {
	
				$sql = "UPDATE `employees` SET `EmpName`='" . mysqli_real_escape_string($this->db->mysql_link, $EmpName) . "',`DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "',`OrgID`='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',`JobTID`='" . mysqli_real_escape_string($this->db->mysql_link, $JobTID) . "',`Gender`='" . mysqli_real_escape_string($this->db->mysql_link, $Gender) . "',`EmailID`='" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "',`Address`='" . mysqli_real_escape_string($this->db->mysql_link, $Address) . "',`Contact`='" . mysqli_real_escape_string($this->db->mysql_link, $Mobile) . "',`JobType`='" . mysqli_real_escape_string($this->db->mysql_link, $JobType) . "',`DateOfJoining`='" . mysqli_real_escape_string($this->db->mysql_link, $DateOfJoining) . "',`PreviousExp`='" . mysqli_real_escape_string($this->db->mysql_link, $PreviousExp) . "',`UpdatedBy`='" .mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "',`UpdatedDate`='" . date('Y-m-d H:i:s') . "' WHERE `EmpID`='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';";
				if ($this->db->executeQuery($sql)) {
					$sql = $this->db->executeQuery("DELETE FROM `employeebranches` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';");
					if(!empty($branches)){
						for($i=0;$i<count($branches);$i++){
							
							$this->db->executeQuery("INSERT INTO `employeebranches`(`EmpID`,`BrID`,`CreatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $branches[$i]) . "','" . date('Y-m-d H:i:s') . "')");
						}
					}
					$this->successMSG('Employee Updated Succesfully..!', '');
				}
			} catch (Exception $e) {
				$this->db->rollbackTransaction();
				$this->errorMSG(400, $e->getMessage());
			}
		}
		
	}

	function deleteemployee(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

		$EmpID = $this->_request['EmpID'];
		$sql = "DELETE FROM `employees` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';";
		if ($this->db->executeQuery($sql)) {
			$this->db->executeQuery("DELETE FROM `employeebranches` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'");
			$this->successMSG('Employee Deleted Successfully..!', '');
		} 
	}
	
	function activeinactive(){
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}
		
		$MasterTable = $this->_request['MasterTable'];
		$ID = $this->_request['ID'];
		$Status = $this->_request['Status'];
		if($MasterTable == "getemployee"){
		    $table = "employees";
		    $KeyID = "EmpID";
		}
		if($MasterTable == "getdepartment"){
		    $table = "departments";
		    $KeyID = "DeptID";
		}
		
			$sql = "UPDATE `".$table."` SET `Status`='" . mysqli_real_escape_string($this->db->mysql_link, $Status) . "' WHERE `".$KeyID."` = '" . mysqli_real_escape_string($this->db->mysql_link, $ID) . "';";
				if ($this->db->executeQuery($sql)) {
				    	$this->successMSG('Status Updated Successfully..!', '');
				}
		
	}
	
	
	function experiencelist()
	{
		$query1 = $this->db->executeQueryAndGetArray("SELECT Exp_Desc,ExeID,Experience FROM experience", MYSQLI_ASSOC);
		//"1"=>"Order Created","2"=>"In-Progress","3"=>"Ready","4"=>"Delivered"
		foreach ($query1 as $q) {
			$items[$q['ExeID']] = $q['Exp_Desc'];
		}
		$this->successMSG('Experience list', $items);
	}

	function adddepartment(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

		$OrgID = $this->OrgID;
		$BrID = $this->_request['BrID'];
		$DeptName = $this->_request['DeptName'];
		$ParentDeptID = $this->_request['ParentDeptID'];
		
		if ($DeptName == '') {
			$this->errorMSG(400, "Please enter Deptment Name.");
		}
		if ($BrID == '') {
			$this->errorMSG(400, "Please enter Branches.");
		}
		/*if ($ParentDeptID == '') {
			$this->errorMSG(400, "Please enter Parent Department.");
		}	*/
		
		$ParentDeptID = $ParentDeptID;
		if($ParentDeptID == ''){
		    $ParentDeptID = 0;
		}
		
		try {			

			$this->db->executeQuery("INSERT INTO `departments`(`ParentDept`,`OrgID`, `BrID`,`DeptName`,`Status`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $ParentDeptID) . "',
			'" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',
			'" . mysqli_real_escape_string($this->db->mysql_link, $BrID) . "',
			'" . mysqli_real_escape_string($this->db->mysql_link, $DeptName) . "'
			,'1','" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "','" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "')");
			
			
			$this->successMSG('Department Added Succesfully..!', '');
			
		} catch (Exception $e) {
			$this->db->rollbackTransaction();
			$this->errorMSG(400, $e->getMessage());
		}
		
	}

	function editdepartment(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

		$OrgID = $this->OrgID;
		$DeptID = $this->_request['DeptID'];
		$BrID = $this->_request['BrID'];
		$DeptName = $this->_request['DeptName'];
		$ParentDeptID = $this->_request['ParentDeptID'];
		
		if ($DeptID == '') {
			$this->errorMSG(400, "Please enter Deptment ID.");
		}
		if ($DeptName == '') {
			$this->errorMSG(400, "Please enter Deptment Name.");
		}
		if ($BrID == '') {
			$this->errorMSG(400, "Please enter Branches.");
		}
		$ParentDeptID = $ParentDeptID;
		if($ParentDeptID == ''){
		    $ParentDeptID = 0;
		}	

		if (!$this->db->hasRecords("SELECT * FROM `departments` WHERE DeptID='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'")) {
			//echo $this->db->getLastSQLStatement();exit;
			$this->errorMSG(400, "Department Not Registered!");
		}
		
		try {			

			$sql = "UPDATE `departments` SET `ParentDept`='" . mysqli_real_escape_string($this->db->mysql_link, $ParentDeptID) . "',`OrgID`='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',`BrID`='" . mysqli_real_escape_string($this->db->mysql_link, $BrID) . "',`DeptName`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptName) . "',`UpdatedBy`='" .mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "',`UpdatedDate`='" . date('Y-m-d H:i:s') . "' WHERE `DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "';";
			//echo $sql;exit;
				if ($this->db->executeQuery($sql)) {
					$this->successMSG('Department Updated Succesfully..!', '');
				}
			
		} catch (Exception $e) {
			$this->db->rollbackTransaction();
			$this->errorMSG(400, $e->getMessage());
		}
		
	}

	/*
	 *	Success and error Handlers
	*/
	private function errorMSG($errcode, $msg)
	{
		$error = array('status' => "Failed", "msg" => $msg);
		$this->logResponse("Failed", $msg);
		$this->response($this->json($error), $errcode);
	}
	private function successMSG($msg, $data)
	{
		$susmsg = array('status' => "Success", "msg" => $msg, "data" => $data);
		$this->logResponse("Success", $data);
		$this->response($this->json($susmsg), 200);
	}
	/*
	 *	Encode array into JSON
	*/
	public function json($data)
	{
		if (is_array($data)) {
			return json_encode($data);
		}
	}
}
// Initiiate Library
$api = new WisAPI();
$api->processApi();
