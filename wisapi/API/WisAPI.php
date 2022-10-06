<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); //
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mpdf\Mpdf;
require "../utilities/vendor/autoload.php";
//test
use \Firebase\JWT\JWT;

define('SiteURL', 'http://igreen.systems/wisadmin/');
define('SiteURL1', 'http://igreen.systems/wissuperadmin/');

require_once("../utilities/Rest.inc.php");
require_once("../utilities/class.MySQL.php");
require_once("../utilities/functions.php");
class WisAPI extends REST
{
	private $db;
	private $appSecret = "dfhfhfi&9)jnd%sndn&565ggghGGdedj*nsn&jsdnjdnj";
	private $jwtPassThroughRoutes = array("logout","test","editemployee","addemployee","employees","alldepartments","branches","adddepartment","editdepartment","departments","jobtitles","getcomplaints","complaintcategorysearch","getorgsrooms");
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
				$sql = "SELECT e.OrgID,e.JobTID,e.DeptID,e.EmpID,e.EmpName,e.EmailID,e.Contact,e.WhatsApp,e.Password,e.Gender,e.Address,e.JobType,e.RoleID,e.Status,e.CreatedDate,e.UpdatedDate,e.DateOfJoining,e.PreviousExp,e.ProfilePic,o.OrgName,o.Logo,d.DeptName FROM employees as e LEFT JOIN roles as r
				ON r.RoleID = e.RoleID LEFT JOIN organization as o
				ON o.OrgID = e.OrgID LEFT JOIN departments as d
				ON d.DeptID = e.DeptID WHERE e.EmailID = '" . mysqli_real_escape_string($this->db->mysql_link, $email) . "' AND e.Status=1";
				$this->db->executeQuery($sql);
				
				
				if ($this->db->getRowsCount() == 1) {
					$row = $this->db->getCurrentRow();
					$qu = $row;
						$items = array(
							"OrgID" => $qu->OrgID,
							"JobTID" => $qu->JobTID,
							"RoleID" => $qu->RoleID,
							"DeptID" => $qu->DeptID,
							"EmpID" => $qu->EmpID,
							"Password" => $qu->Password,
							"EmpName" => $qu->EmpName,
							"EmailID" => $qu->EmailID,
							"Mobile" => $qu->Contact,
							"WhatsApp" => $qu->WhatsApp,
							"Gender" => $qu->Gender,
							"Address" => $qu->Address,
							"JobType" => $qu->JobType,
							"CreatedDate" => $qu->CreatedDate,
							"Status" => $qu->Status,
							"Shift" => $qu->Shift,
							"PreviousExp" => $qu->PreviousExp,
							"ProfilePic" => SiteURL.$qu->ProfilePic,
							"Logo" => SiteURL1.$qu->Logo,
							"DateOfJoining" => $qu->DateOfJoining,
							"UpdatedDate" => $qu->UpdatedDate,
							"OrgName" => $qu->OrgName,
							"DeptName" => $qu->DeptName
						);
					
					
				    if (md5($password)==$row->Password) {
					    
						if ($row->Status != "1") {
							$this->errorMSG(400, "Your account is temporarily suspended. Please contact administrator.");
						}
						if ($row->Status != "") {
						    
							$FBTokenID = 0;
							
							$jwt = $this->getJWToken($row->EmpID, $row->EmailID, $row->OrgID, $FBTokenID, $this->appSecret);
							$result = json_decode(json_encode($items), true);
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
		$query1 = $this->db->executeQueryAndGetArray("SELECT o.OrgID,o.OrgName FROM organization o left join organization_type ot on ot.TypeID=o.OrgType where o.Status = 1", MYSQLI_ASSOC);
			//	echo $this->db->getLastSQLStatement();exit;
		
		/// dropdown view
		/*foreach ($query1 as $q) {
			$items[$q['EmpID']] = $q['EmployeeName'];
		}*/
		$this->successMSG('Organizations list', $query1);
	}
	function shiftslist()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT s.ShID,s.ShiftName,s.ShiftDesc FROM shifts s where s.Status = 1", MYSQLI_ASSOC);
		$this->successMSG('Shifts list', $query1);
	}
	function branches()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT b.BrID,b.BrName,b.Address,b.BrLangitude,b.BrLatitude,b.Status,b.UpdatedBy,b.UpdatedDate,o.OrgName,o.OrgID FROM branches b left join organization o on o.OrgID=b.OrgID where b.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND b.Status = 1", MYSQLI_ASSOC);
			//	echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Branches list', $query1);
	}

	function jobtitles()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT OrgID,JobTID,JobTitle FROM jobtitle where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Job Titles list', $query1);
	}

	function getbuildings()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->_request['OrgID'];
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT b.BID,b.BuildingName,br.BrName FROM building b left join branches br on br.BrID = b.BrID where b.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND b.Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Buildings list', $query1);
	}

	function getorgsrooms(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->OrgID;
		
		$data['rooms'] = $this->db->executeQueryAndGetArray("SELECT b.BID,b.BuildingName,f.FID,f.FloorName,r.RID,r.RoomName FROM room r left join building b on b.BID = r.BID left join floor f on f.FID = r.FID  where r.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND r.Status = 1", MYSQLI_ASSOC);
		
		
		/*$data['buildings'] = $this->db->executeQueryAndGetArray("SELECT * FROM building b where b.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND b.Status = 1", MYSQLI_ASSOC);

		if(!empty($data['buildings'])){
            foreach($data['buildings'] as $i => $building){
				$data['buildings'][$i]['floors'] = $this->db->executeQueryAndGetArray("SELECT * FROM floor f where f.BID='" . mysqli_real_escape_string($this->db->mysql_link, $building['BID']) . "' AND f.Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
				if(!empty($data['buildings'][$i]['floors'])){
					foreach($data['buildings'][$i]['floors'] as $j => $floor){
						$data['buildings'][$i]['floors'][$j]['rooms'] = $this->db->executeQueryAndGetArray("SELECT * FROM room r where r.FID='" . mysqli_real_escape_string($this->db->mysql_link, $floor['FID']) . "' AND r.Status = 1", MYSQLI_ASSOC);
					}
				}
			}
		}*/

		$this->successMSG('Buildings list', $data);

	}

	/*function getblocks()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$BID = $this->_request['BuildingID'];

		$query1 = $this->db->executeQueryAndGetArray("SELECT bk.BKID,bk.BlockName FROM block bk where bk.BID='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "' AND bk.Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Blocks list', $query1);
	}*/

	function getfloors()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		//$BID = $this->_request['BuildingID'];
		$BID = $this->_request['BuildingID'];

		$query1 = $this->db->executeQueryAndGetArray("SELECT f.FID,f.FloorName FROM floor f where f.BID='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "' AND  f.Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Floors list', $query1);
	}

	function getrooms()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$FID = $this->_request['FloorID'];

		$query1 = $this->db->executeQueryAndGetArray("SELECT r.RID,r.RoomName FROM room r where r.FID='" . mysqli_real_escape_string($this->db->mysql_link, $FID) . "' AND r.Status = 1", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Rooms list', $query1);
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
		$BrID = $this->_request['BrID'];
		$Status = $this->_request['Status'];

		$sql1 = "SELECT OrgID,DeptID,DeptName from departments where OrgID = '" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND ParentDept = 0";

		if($DeptID != ''){
			$sql1.=" AND DeptID = '" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'";
		}
		if($BrID != ''){
			$sql1.=" AND BrID = '" . mysqli_real_escape_string($this->db->mysql_link, $BrID) . "'";
		}
	
		
		$query = $this->db->executeQueryAndGetArray($sql1, MYSQLI_ASSOC);

		foreach($query as $rec){
			$sql = "SELECT * FROM((SELECT e.EmpID,e.EmpName,e.DeptID,e.JobTID,e.Gender,e.EmailID,e.Address,e.Contact,e.WhatsApp,e.JobType,e.DateOfJoining,ex.Experience as exp,ex.Exp_Desc as PreviousExperience,e.Status,e.CreatedDate,e.UpdatedDate,d.DeptName,j.JobTitle from employees e left join departments d on d.DeptID = e.DeptID left join jobtitle j on j.JobTID = e.JobTID left join experience ex on ex.ExeID = e.PreviousExp where e.DeptID = '" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "') UNION (SELECT e.EmpID,e.EmpName,e.DeptID,e.JobTID,e.Gender,e.EmailID,e.Address,e.Contact,e.WhatsApp,e.JobType,e.DateOfJoining,ex.Experience as exp,ex.Exp_Desc as PreviousExperience,e.Status,e.CreatedDate,e.UpdatedDate,d.DeptName,j.JobTitle from employees e left join departments d on d.DeptID = e.DeptID left join jobtitle j on j.JobTID = e.JobTID left join experience ex on ex.ExeID = e.PreviousExp WHERE e.DeptID IN(SELECT d.DeptID FROM departments d WHERE d.ParentDept = '" . mysqli_real_escape_string($this->db->mysql_link, $rec['DeptID']) . "'))) AS N";
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

			if($Status != "" && $JoiningDate!='' && $JobTID != ''){
				$sql.=" AND N.Status = '" . mysqli_real_escape_string($this->db->mysql_link, $Status) . "'";					
			}else if($Status != "" && $JoiningDate!='' && $JobTID == ''){
				$sql.=" AND N.Status = '" . mysqli_real_escape_string($this->db->mysql_link, $Status) . "'";					
			}else if($Status != "" && $JoiningDate=='' && $JobTID != ''){
				$sql.=" AND N.Status = '" . mysqli_real_escape_string($this->db->mysql_link, $Status) . "'";					
			}else if($Status != "" && $JoiningDate=='' && $JobTID == ''){
				$sql.=" where N.Status = '" . mysqli_real_escape_string($this->db->mysql_link, $Status) . "'";					
			}
			
			
			//echo $sql;
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

		//$OrgID = $this->OrgID;	
		$BID = $this->_request['BID'];
		//$BKID = $this->_request['BKID'];
		$FID = $this->_request['FID'];	
		$RID = $this->_request['RID'];

		if ($BID == '') {
			$this->errorMSG(400, "Please enter Building");
		}
		/*if ($BKID == '') {
			$this->errorMSG(400, "Please enter Block");
		}*/
		if ($FID == '') {
			$this->errorMSG(400, "Please enter Floor");
		}
		if ($RID == '') {
			$this->errorMSG(400, "Please enter Romm");
		}

		if (!$this->db->hasRecords("SELECT * FROM `building` WHERE BID='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "'")) {
			$this->errorMSG(400, "Building Not Exist!");
		}
		/*if (!$this->db->hasRecords("SELECT * FROM `block` WHERE BKID='" . mysqli_real_escape_string($this->db->mysql_link, $BKID) . "'")) {
			$this->errorMSG(400, "Block Not Exist!");
		}*/
		if (!$this->db->hasRecords("SELECT * FROM `floor` WHERE FID='" . mysqli_real_escape_string($this->db->mysql_link, $FID) . "'")) {
			$this->errorMSG(400, "Floor Not Exist!");
		}
		if (!$this->db->hasRecords("SELECT * FROM `room` WHERE RID='" . mysqli_real_escape_string($this->db->mysql_link, $RID) . "'")) {
			$this->errorMSG(400, "Room Not Exist!");
		}

		$OrgID = $this->db->getFirstRowFirstColumn("SELECT `OrgID` FROM `building` WHERE `BID`='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "';");

		$BName = $this->db->getFirstRowFirstColumn("SELECT `BuildingName` FROM `building` WHERE `BID`='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "';");

		/*$BKName = $this->db->getFirstRowFirstColumn("SELECT `BlockName` FROM `block` WHERE `BKID`='" . mysqli_real_escape_string($this->db->mysql_link, $BKID) . "';");*/

		$FName = $this->db->getFirstRowFirstColumn("SELECT `FloorName` FROM `floor` WHERE `FID`='" . mysqli_real_escape_string($this->db->mysql_link, $FID) . "';");

		$RName = $this->db->getFirstRowFirstColumn("SELECT `RoomName` FROM `room` WHERE `RID`='" . mysqli_real_escape_string($this->db->mysql_link, $RID) . "';");

		$query1 = $this->db->executeQueryAndGetArray("SELECT cco.ComCatID,cc.CategoryName,cco.OrgID,cc.CategoryIcon FROM complaintcategoryorganizations cco left join complaintcategory cc on cc.ComCatID = cco.ComCatID where cco.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND cc.Status = 1", MYSQLI_ASSOC);

		$r["location"] = array(
			"BID"=>$BID,
			"BuildingName"=>$BName,
			"FID"=>$FID,
			"FloorName"=>$FName,
			"RID"=>$RID,
			"RoomName"=>$RName);
		foreach($query1 as $rec){
			$r["data"][] = array(
				"ComCatID" => $rec['ComCatID'],
				"CategoryName" => $rec['CategoryName'],
				"OrgID" => $rec['OrgID'],
				"CategoryIcon" => SiteURL1.$rec['CategoryIcon']

			);
		}
				//echo $this->db->getLastSQLStatement();exit;
		
	
		$this->successMSG('Complaint Category list', $r);
	}

	function complaintcategorysearch()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}

		$OrgID = $this->OrgID;	
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT cco.ComCatID,cc.CategoryName,cco.OrgID,cc.CategoryIcon FROM complaintcategoryorganizations cco left join complaintcategory cc on cc.ComCatID = cco.ComCatID where cco.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);

		foreach($query1 as $rec){
			$r["data"][] = array(
				"ComCatID" => $rec['ComCatID'],
				"CategoryName" => $rec['CategoryName'],
				"OrgID" => $rec['OrgID'],
				"CategoryIcon" => SiteURL1.$rec['CategoryIcon']

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
		$WhatsApp = $this->_request['WhatsApp'];
		$DateOfJoining = $this->_request['DateOfJoining'];
		$JobType = $this->_request['JobType'];
		$Address = $this->_request['Address'];
		$Shift = $this->_request['Shift'];
		$PreviousExp = $this->_request['PreviousExp'];
		$ProfilePic = $this->_request['ProfilePic'];
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
		
		if ($Gender == '') {
			$this->errorMSG(400, "Please enter Gender.");
		}

		if($ProfilePic == "" || $ProfilePic == NULL){
			if($Gender == "M"){
				$ProfilePic = "writable/uploads/ProfilePics/man.png";
			}else if($Gender == "F"){
				$ProfilePic = "writable/uploads/ProfilePics/woman.png";
			}
		} 

		if ($this->db->hasRecords("SELECT * FROM `employees` WHERE EmailID='" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "' AND Status=1;")) {
			$this->errorMSG(400, "Not Available. Email Already Registered");
		} else {
			try {

				//$OrgID = $this->db->getFirstRowFirstColumn("SELECT `OrgID` FROM `departments` WHERE `DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "';");
				

				$this->db->executeQuery("INSERT INTO `employees`(`RoleID`,`EmpName`,`DeptID`, `OrgID`,`JobTID`,`Gender`, `EmailID`, `Password`, `Address`, `Contact`, `WhatsApp`, `JobType`,`DateOfJoining`,`PreviousExp`,`ProfilePic`,`Status`,`Shift`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('0','" . mysqli_real_escape_string($this->db->mysql_link, $EmpName) . "','" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $JobTID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Gender) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, md5("123456")) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Address) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Mobile) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $WhatsApp) . "','" . mysqli_real_escape_string($this->db->mysql_link, $JobType) . "','" . mysqli_real_escape_string($this->db->mysql_link, $DateOfJoining) . "','" . mysqli_real_escape_string($this->db->mysql_link, $PreviousExp) . "','" . mysqli_real_escape_string($this->db->mysql_link, $ProfilePic) . "','1','" . mysqli_real_escape_string($this->db->mysql_link, $Shift) . "','" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "','" . mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "','" . date('Y-m-d H:i:s') . "')");
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
		$query1 = $this->db->executeQueryAndGetArray("SELECT e.OrgID,e.JobTID,e.DeptID,e.EmpID,e.EmpName,e.EmailID,e.Contact,e.WhatsApp,e.Gender,e.Address,e.JobType,e.Contact,e.RoleID,e.Status,e.Shift,e.CreatedDate,e.UpdatedDate,e.PreviousExp,e.ProfilePic,e.DateOfJoining FROM employees e where e.EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'", MYSQLI_ASSOC);
		
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
				"WhatsApp" => $qu['WhatsApp'],
				"Gender" => $qu['Gender'],
				"Address" => $qu['Address'],
				"JobType" => $qu['JobType'],
				"CreatedDate" => $qu['CreatedDate'],
				"Status" => $qu['Status'],
				"Shift" => $qu['Shift'],
				"PreviousExp" => $qu['PreviousExp'],
				"ProfilePic" => SiteURL.$qu['ProfilePic'],
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
		$WhatsApp = $this->_request['WhatsApp'];
		$DateOfJoining = $this->_request['DateOfJoining'];
		$PreviousExp = $this->_request['PreviousExp'];
		$ProfilePic = $this->_request['ProfilePic'];
		$JobType = $this->_request['JobType'];
		$Address = $this->_request['Address'];
		$Shift = $this->_request['Shift'];
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
		
		if ($Gender == '') {
			$this->errorMSG(400, "Please enter Gender.");
		}

		$ExistPic = $this->db->getFirstRowFirstColumn("SELECT `ProfilePic` FROM `employees` WHERE `EmpID`= '" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';");

		if($ProfilePic == "" || $ProfilePic == NULL){
			if($ExistPic == ""){
				if($Gender == "M"){
					$ProfilePic = "writable/uploads/ProfilePics/man.png";
				}else if($Gender == "F"){
					$ProfilePic = "writable/uploads/ProfilePics/woman.png";
				}
			}else{
				$ProfilePic = $ExistPic;
			}
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
	
				$sql = "UPDATE `employees` SET `EmpName`='" . mysqli_real_escape_string($this->db->mysql_link, $EmpName) . "',`DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "',`OrgID`='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',`JobTID`='" . mysqli_real_escape_string($this->db->mysql_link, $JobTID) . "',`Gender`='" . mysqli_real_escape_string($this->db->mysql_link, $Gender) . "',`EmailID`='" . mysqli_real_escape_string($this->db->mysql_link, $Email) . "',`Address`='" . mysqli_real_escape_string($this->db->mysql_link, $Address) . "',`Contact`='" . mysqli_real_escape_string($this->db->mysql_link, $Mobile) . "',`WhatsApp`='" . mysqli_real_escape_string($this->db->mysql_link, $WhatsApp) . "',`JobType`='" . mysqli_real_escape_string($this->db->mysql_link, $JobType) . "',`DateOfJoining`='" . mysqli_real_escape_string($this->db->mysql_link, $DateOfJoining) . "',`PreviousExp`='" . mysqli_real_escape_string($this->db->mysql_link, $PreviousExp) . "',`ProfilePic`='" . mysqli_real_escape_string($this->db->mysql_link, $ProfilePic) . "',`Shift`='" . mysqli_real_escape_string($this->db->mysql_link, $Shift) . "',`UpdatedBy`='" .mysqli_real_escape_string($this->db->mysql_link, $this->EmpID) . "',`UpdatedDate`='" . date('Y-m-d H:i:s') . "' WHERE `EmpID`='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "';";
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

	function complaintnature()
	{
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}

		$ComCatID = $this->_request['ComCatID'];
		if ($ComCatID == '') {
			$this->errorMSG(400, "Please enter Complaint Category ID.");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT ComNatID,ComplaintNature FROM complaintnature where ComCatID = '" . mysqli_real_escape_string($this->db->mysql_link, $ComCatID) . "' AND Status = 1", MYSQLI_ASSOC);
		//"1"=>"Order Created","2"=>"In-Progress","3"=>"Ready","4"=>"Delivered"
		foreach ($query1 as $q) {
			$items[$q['ComNatID']] = $q['ComplaintNature'];
		}
		$this->successMSG('Complaint Nature List', $items);
	}

	function complaintpriority()
	{
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT PriorityID,Priority FROM complaintpriority", MYSQLI_ASSOC);
		foreach ($query1 as $q) {
			$items[$q['PriorityID']] = $q['Priority'];
		}
		$this->successMSG('Complaint Priority List', $items);
	}

	function complaintstatus()
	{
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT StatusID,StausName FROM complaintstatus", MYSQLI_ASSOC);
		foreach ($query1 as $q) {
			$items[$q['StatusID']] = $q['StausName'];
		}
		$this->successMSG('Complaint Status List', $items);
	}

	function addcomplaint(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong Method");
		}
		$BID = $this->_request['BID'];
		//$BKID = $this->_request['BKID'];
		$FID = $this->_request['FID'];	
		$RID = $this->_request['RID'];
		$ComCatID = $this->_request['ComCatID'];
		$ComNatID = $this->_request['ComNatID'];
		$CustomComplaint = $this->_request['CustomComplaint'];
		$Priority = $this->_request['Priority'];
		$Remarks = $this->_request['Remarks'];
	   	$EmpID = $this->_request['EmpID'];
		$images = $this->_request['Images'];
		$Name = $this->_request['Name'];
		$Mobile = $this->_request['Mobile'];
		$ComplaintRaisedBy = $this->_request['ComplaintRaisedBy'];
		if($EmpID == ""){
			$EmpID = 0;
		}
		if ($BID == '') {
			$this->errorMSG(400, "Please enter Building");
		}
		/*if ($BKID == '') {
			$this->errorMSG(400, "Please enter Block");
		}*/
		if ($FID == '') {
			$this->errorMSG(400, "Please enter Floor");
		}
		if ($RID == '') {
			$this->errorMSG(400, "Please enter Romm");
		}
		if ($ComCatID == '') {
			$this->errorMSG(400, "Please enter Complaint Category.");
		}
		if ($ComplaintRaisedBy == '') {
			$this->errorMSG(400, "Please enter Complaint Raised By.");
		}
		
		
		$OrgID = $this->db->getFirstRowFirstColumn("SELECT `OrgID` FROM `building` WHERE `BID`='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "';");

			try {

				$this->db->executeQuery("INSERT INTO `complaints`(`OrgID`,`BID`, `FID`,`RID`,`ComCatID`, `ComNatID`, `CustomComplaint`, `ComplaintPriority`, `ComplaintRemarks`, `ComplaintStatus`, `DeptID`,`Name`,`Mobile`,`ComplaintRaisedBy`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $FID) . "'
				,'" . mysqli_real_escape_string($this->db->mysql_link, $RID) . "',
				'" . mysqli_real_escape_string($this->db->mysql_link, $ComCatID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $ComNatID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $CustomComplaint) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Priority) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Remarks) . "',
				'1','0','" . mysqli_real_escape_string($this->db->mysql_link, $Name) . "','" . mysqli_real_escape_string($this->db->mysql_link, $Mobile) . "','" . mysqli_real_escape_string($this->db->mysql_link, $ComplaintRaisedBy) . "','" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "','" . date('Y-m-d H:i:s') . "','0','" . date('Y-m-d H:i:s') . "')");
				
				$comid = $this->db->getLastInsertID();
				$query = $this->db->executeQueryAndGetArray("SELECT c.ComID,c.ComCatID,b.BuildingName,f.FloorName,r.RoomName,cc.CategoryName,cn.ComplaintNature,cp.Priority,cs.StausName,c.ComplaintRemarks,c.Name,c.Mobile,c.ComplaintRaisedBy,c.CustomComplaint FROM complaints c left join building b on b.BID = c.BID left join floor f on f.FID = c.FID left join room r on r.RID = c.RID left join complaintcategory cc on cc.ComCatID = c.ComCatID left join complaintnature cn on cn.ComNatID = c.ComNatID left join complaintpriority cp on cp.PriorityID = c.ComplaintPriority left join complaintstatus cs on cs.StatusID = c.ComplaintStatus where c.ComID = '" . mysqli_real_escape_string($this->db->mysql_link, $comid) . "'", MYSQLI_ASSOC);
				

				if($images){
					for($i=0;$i<count($images);$i++){
						$this->db->executeQuery("INSERT INTO `complaintimages`(`ComCatID`,`Image`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $comid) . "','" . mysqli_real_escape_string($this->db->mysql_link, $images[$i]) . "','" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "','" . date('Y-m-d H:i:s') . "','0','" . date('Y-m-d H:i:s') . "')");
					}
				}

				$query1 = $this->db->executeQueryAndGetArray("SELECT Image FROM complaintimages where ComCatID = '" . mysqli_real_escape_string($this->db->mysql_link, $comid) . "'", MYSQLI_ASSOC);
				foreach($query1 as $rec){
					$img[]=array(
						"Image" => SiteURL.$rec['Image']
					);
				}
				$query['Images'] = $img;
				
				//echo $this->db->getLastSQLStatement();exit;
				$this->successMSG('Complaint Added Succesfully..!', $query);

				
			} catch (Exception $e) {
				$this->db->rollbackTransaction();
				$this->errorMSG(400, $e->getMessage());
			}
		
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

	function getcomplaintcategory()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$ComCatID = $this->_request['ComCatID'];
		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT c.ComCatID,c.CategoryName,c.CategoryIcon FROM complaintcategory c where c.ComCatID='" . mysqli_real_escape_string($this->db->mysql_link, $ComCatID) . "'", MYSQLI_ASSOC);
		foreach($query1 as $rec){
			$res[] = array(
				"ComCatID" => $rec['ComCatID'],
				"CategoryName" => $rec['CategoryName'],
				"CategoryIcon" => SiteURL1.$rec['CategoryIcon']
			);
		}
		
	
		$this->successMSG('complaint Category', $res);
	}

	function getcomplaints(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$EmpID = $this->EmpID;
		$OrgID = $this->OrgID;
		//echo "Dsd0";exit;
		$ComCatID = $this->_request['ComCatID'];
		$ComNatID = $this->_request['ComNatID'];
		$BID = $this->_request['BID'];
		//$BKID = $this->_request['BKID'];
		$FID = $this->_request['FID'];
		$RID = $this->_request['RID'];
		$ComplaintBy = $this->_request['ComplaintBy'];
		$ComplaintStatus = $this->_request['ComplaintStatus'];
		$FromDate = $this->_request['FromDate'];
		$ToDate = $this->_request['ToDate'];
		$FromDates = $this->_request['FromDate'] ." 00:00:00";
		$ToDates = $this->_request['ToDate'] ." 23:59:59";

		$DeptID = $this->db->getFirstRowFirstColumn("SELECT DeptID FROM employees where EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'", MYSQLI_ASSOC);
				//echo $this->db->getLastSQLStatement();exit;
	
		$DeptName = $this->db->getFirstRowFirstColumn("SELECT DeptName FROM departments where DeptID='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "'", MYSQLI_ASSOC);
	
		if($DeptName == "Admin"){
			$query = $this->db->executeQueryAndGetArray("SELECT SUM(CASE WHEN ComplaintStatus = '1' THEN 1 ELSE 0 END) AS 'UnAssigned',SUM(CASE WHEN ComplaintStatus = '2' THEN 1 ELSE 0 END) AS 'InProcess', SUM(CASE WHEN ComplaintStatus = '3' THEN 1 ELSE 0 END) AS 'Completed' FROM complaints where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);
		}else{
			$query = $this->db->executeQueryAndGetArray("SELECT SUM(CASE WHEN ComplaintStatus = '1' THEN 1 ELSE 0 END) AS 'UnAssigned',SUM(CASE WHEN ComplaintStatus = '2' THEN 1 ELSE 0 END) AS 'InProcess', SUM(CASE WHEN ComplaintStatus = '3' THEN 1 ELSE 0 END) AS 'Completed' FROM complaints where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "' AND UpdatedBy='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "'", MYSQLI_ASSOC);
		}
		$data["ComplaintsData"] = $query;
		
		
		
		$sql = "SELECT c.ComID,cc.CategoryName,cn.ComplaintNature,b.BuildingName,f.FloorName,r.RoomName,c.CreatedDate,cs.StausName,c.UpdatedBy as empid,e.EmpName as AssignedBy,c.CustomComplaint,c.ComplaintStatus,c.ComplaintRaisedBy,c.Material,cp.Priority FROM complaints c left join complaintcategory cc on cc.ComCatID = c.ComCatID left join complaintnature cn on cn.ComNatID = c.ComNatID left join building b on b.BID = c.BID left join floor f on f.FID = c.FID left join room r on r.RID = c.RID left join complaintstatus cs on cs.StatusID  = c.ComplaintStatus left join employees e on e.EmpID  = c.UpdatedBy left join complaintpriority cp on cp.PriorityID  = c.ComplaintPriority where c.OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'";
	
	/*	if($DeptName != "Admin"){
			$sql.=" AND c.UpdatedBy = '".mysqli_real_escape_string($this->db->mysql_link, $EmpID)."'";
		}
		if($ComCatID != ''){
			$sql.=" AND c.ComCatID = '".mysqli_real_escape_string($this->db->mysql_link, $ComCatID)."'";
		}
		if($ComNatID != ''){
			$sql.=" AND c.ComNatID = '".mysqli_real_escape_string($this->db->mysql_link, $ComNatID)."'";
		}
		if($BID != ''){
			$sql.=" AND c.BID = '".mysqli_real_escape_string($this->db->mysql_link, $BID)."'";
		}
		
		if($FID != ''){
			$sql.=" AND c.FID = '".mysqli_real_escape_string($this->db->mysql_link, $FID)."'";
		}
		if($RID != ''){
			$sql.=" AND c.RID = '".mysqli_real_escape_string($this->db->mysql_link, $RID)."'";
		}
		if($ComplaintBy != ''){
			if($ComplaintBy == 'ALL'){
				$sql.=" ";
			}else if($ComplaintBy == '1'){
				$sql.=" AND c.CreatedBy != '0'";
			}else if($ComplaintBy == '0'){
				$sql.=" AND c.CreatedBy = '0'";
			}
		}
		if($ComplaintStatus != ''){
			$sql.=" AND c.ComplaintStatus = '".mysqli_real_escape_string($this->db->mysql_link, $ComplaintStatus)."'";
		}
		*/
		if($FromDate !="" && $ToDate != ""){
			$sql.=" AND c.CreatedDate between '".mysqli_real_escape_string($this->db->mysql_link, $FromDates)."' and '".mysqli_real_escape_string($this->db->mysql_link, $ToDates)."'";
		}
		$sql.=" order by c.ComID DESC";
	   //echo $sql;exit;
		$query1 = $this->db->executeQueryAndGetArray($sql, MYSQLI_ASSOC);
	
		
	
		foreach($query1 as $rec ){
		    $item[] = array(
		    "ComID" => $rec["ComID"],
		    "CategoryName" => $rec["CategoryName"],
		    "ComplaintNature" => ($rec["ComplaintNature"]==""?$rec["CustomComplaint"]:$rec["ComplaintNature"]),
		    "BuildingName" => $rec["BuildingName"],
		    "FloorName" => $rec["FloorName"],
		    "RoomName" => $rec["RoomName"],
		    "CreatedDate" => $rec["CreatedDate"],
		    "StausName" => $rec["StausName"],
		    "AssignedBy" => $rec["AssignedBy"],
		    "CustomComplaint" => $rec["CustomComplaint"],
		    "ComplaintStatus" => $rec["ComplaintStatus"],
			"ComplaintRaisedBy" => $rec["ComplaintRaisedBy"],
		    "empid" => $rec["empid"],
		    "Material" => $rec["Material"],
		    "Priority" => $rec["Priority"]
		    );
		}
		
		$data["List"] = $item;
		
		
		$this->successMSG('Complaints list', $data);
	} 
	

	function getcomplaint()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$ComID = $this->_request['ComID'];
		if ($ComID == '') {
			$this->errorMSG(400, "Please enter Complaint ID");
		}
		$query = $this->db->executeQueryAndGetArray("SELECT c.ComID,cc.CategoryName,cn.ComplaintNature,b.BuildingName,f.FloorName,r.RoomName,c.CreatedDate,cs.StausName,c.UpdatedBy as empid,c.UpdatedDate,e.EmpName as AssignedBy,c.Name,c.Mobile,c.ComplaintRaisedBy,c.Material,c.CustomComplaint,c.ComplaintRemarks,c.ComplaintPriority,c.ComplaintStatus,cp.Priority,c.AssignedNote,c.DeptID,e.Contact as EmpMobile,e.WhatsApp FROM complaints c left join complaintcategory cc on cc.ComCatID = c.ComCatID left join complaintnature cn on cn.ComNatID = c.ComNatID left join building b on b.BID = c.BID left join floor f on f.FID = c.FID left join room r on r.RID = c.RID left join complaintstatus cs on cs.StatusID  = c.ComplaintStatus left join complaintpriority cp on cp.PriorityID  = c.ComplaintPriority left join employees e on e.EmpID  = c.UpdatedBy where c.ComID='" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);	
	

		$query1 = $this->db->executeQueryAndGetArray("SELECT Image FROM complaintimages where ComCatID = '" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);
		$query2 = $this->db->executeQueryAndGetArray("SELECT Image FROM complaintafterimages where ComCatID = '" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);
	
		
		foreach($query as $rec){
		    $item[] = array(
		    "ComID" => $rec["ComID"],
		    "CategoryName" => $rec["CategoryName"],
		    "ComplaintNature" => ($rec["ComplaintNature"]==""?$rec["CustomComplaint"]:$rec["ComplaintNature"]),
		    "BuildingName" => $rec["BuildingName"],
		    "FloorName" => $rec["FloorName"],
		    "RoomName" => $rec["RoomName"],
		    "CreatedDate" => $rec["CreatedDate"],
		    "StausName" => $rec["StausName"],
		    "empid" => $rec["empid"],
		    "AssignedBy" => $rec["AssignedBy"],
		    "CustomComplaint" => $rec["CustomComplaint"],
		    "ComplaintStatus" => $rec["ComplaintStatus"],
		    "UpdatedDate" => $rec["UpdatedDate"],
		    "Name" => $rec["Name"],
		    "Mobile" => $rec["Mobile"],
		    "WhatsApp" => $rec["WhatsApp"],
		    "ComplaintRemarks" => $rec["ComplaintRemarks"],
		    "ComplaintPriority" => $rec["ComplaintPriority"],
		    "Priority" => $rec["Priority"],
		    "AssignedNote" => $rec["AssignedNote"],
		    "DeptID" => $rec["DeptID"],
		    "EmpMobile" => $rec["EmpMobile"],
			"ComplaintRaisedBy" => $rec["ComplaintRaisedBy"],
			"Material" => $rec["Material"]
		    );
		}
		foreach($query1 as $rec1){
			$img[]=array(
				"Image" => SiteURL.$rec1['Image']
			);
		}
		foreach($query2 as $rec2){
			$img1[]=array(
				"AfterImage" => SiteURL.$rec2['Image']
			);
		}
		$query = $item;
		$query['Images'] = $img;
		$query['AfterImages'] = $img1;
		
		$this->successMSG('Complaint Data', $query);
	}

	function employeesbydepartment()
	{
	    if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		//$org = $this->OrgID;
		$DeptID = $this->_request['DeptID'];		
		
		$query1 = $this->db->executeQueryAndGetArray("SELECT e.EmpID,e.EmpName,e.Shift,e.Contact as Mobile,e.WhatsApp,s.ShiftDesc as Shift FROM employees e left join complaints c on c.UpdatedBy = e.EmpID left join shifts s on s.ShID = e.Shift  where e.DeptID='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "' AND e.Status = 1 group by e.EmpID", MYSQLI_ASSOC);	
		foreach($query1 as $q){
			$query2 = $this->db->executeQueryAndGetArray("SELECT SUM(CASE WHEN c.ComplaintStatus = '2' THEN 1 ELSE 0 END) AS 'InProcess', SUM(CASE WHEN c.ComplaintStatus = '3' THEN 1 ELSE 0 END) AS 'Completed', SUM(CASE WHEN c.ComplaintStatus = '1' THEN 1 ELSE 0 END) AS 'Assigned' FROM complaints c where c.UpdatedBy='" . mysqli_real_escape_string($this->db->mysql_link, $q['EmpID']) . "'", MYSQLI_ASSOC);	
			//echo "<pre>";print_r($query2);exit;
			$items[] = array(
				"EmpID" => $q['EmpID'],
				"EmpName" => $q['EmpName'],
				"Shift" => $q['Shift'],
				"Mobile" => $q['Mobile'],
				"InProcess" => ($query2[0]["InProcess"]==NULL?"0":$query2[0]["InProcess"]),
				"Completed" => ($query2[0]["Completed"]==NULL?"0":$query2[0]["Completed"]),
				"Assigned" => ($query2[0]["Assigned"]==NULL?"0":$query2[0]["Assigned"]),
			);
		}	
		
		$data = $items;
		//echo $this->db->getLastSQLStatement();exit;
		$this->successMSG('Employees List', $data);
	}

	function updatecomplaint(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$ComID = $this->_request['ComID'];	
		$DeptID = 	$this->_request['DeptID'];		
		$EmpID = $this->_request['EmpID'];		
		$ComplaintStatus = $this->_request['ComplaintStatus'];	
		$ComplaintPriority = $this->_request['Priority'];	
		$AssignedNote = $this->_request['Note'];
		$Material = $this->_request['Material'];
		$images = $this->_request['Images'];
		
		if ($ComID == '') {
			$this->errorMSG(400, "Please enter Complaint ID");
		}
		
		$DeptName = $this->db->getFirstRowFirstColumn("SELECT DeptID FROM complaints where ComID='" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);
		
		$EmpName = $this->db->getFirstRowFirstColumn("SELECT UpdatedBy FROM complaints where ComID='" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);
		
		$Status = $this->db->getFirstRowFirstColumn("SELECT ComplaintStatus FROM complaints where ComID='" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "'", MYSQLI_ASSOC);


		if ($DeptID == '') {
			$DeptID = $DeptName;
		}
		
		if ($EmpID == '') {
			$EmpID = $EmpName;
		}
		
		if ($ComplaintStatus == '') {
			$ComplaintStatus = $Status;
		}
		
		
		
		
		$sql = "UPDATE `complaints` SET `DeptID`='" . mysqli_real_escape_string($this->db->mysql_link, $DeptID) . "',`UpdatedBy`='" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "',`ComplaintStatus`='" . mysqli_real_escape_string($this->db->mysql_link, $ComplaintStatus) . "',`ComplaintPriority`='" . mysqli_real_escape_string($this->db->mysql_link, $ComplaintPriority) . "',`AssignedNote`='" . mysqli_real_escape_string($this->db->mysql_link, $AssignedNote) . "',`UpdatedDate`='" . date('Y-m-d H:i:s') . "',`Material`='" . mysqli_real_escape_string($this->db->mysql_link, $Material) . "' WHERE `ComID`='" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "';";

		if ($this->db->executeQuery($sql)) {
			if($images){
				for($i=0;$i<count($images);$i++){
					$this->db->executeQuery("INSERT INTO `complaintafterimages`(`ComCatID`,`Image`,`CreatedBy`,`CreatedDate`,`UpdatedBy`,`UpdatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $ComID) . "','" . mysqli_real_escape_string($this->db->mysql_link, $images[$i]) . "','" . mysqli_real_escape_string($this->db->mysql_link, $EmpID) . "','" . date('Y-m-d H:i:s') . "','0','" . date('Y-m-d H:i:s') . "')");
				}
			}
			$this->successMSG('Compalint Updated!', "");
		}

	}
	function getinfo(){
		if ($this->get_request_method() != "POST") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$OrgID = $this->_request['OrgID'];
		$BID = $this->_request['BID'];
		//$BKID = $this->_request['BKID'];
		$FID = $this->_request['FID'];
		$RID = $this->_request['RID'];

		if ($OrgID == '') {
			$this->errorMSG(400, "Please enter organization ID");
		}
		if ($BID == '') {
			$this->errorMSG(400, "Please enter building ID");
		}
		/*if ($BKID == '') {
			$this->errorMSG(400, "Please enter block ID");
		}*/
		if ($FID == '') {
			$this->errorMSG(400, "Please enter floor ID");
		}
		if ($RID == '') {
			$this->errorMSG(400, "Please enter Room ID");
		}

		$data['OrgName'] = $this->db->getFirstRowFirstColumn("SELECT OrgName FROM organization where OrgID='" . mysqli_real_escape_string($this->db->mysql_link, $OrgID) . "'", MYSQLI_ASSOC);

		$data['BuildingName'] = $this->db->getFirstRowFirstColumn("SELECT BuildingName FROM building where BID='" . mysqli_real_escape_string($this->db->mysql_link, $BID) . "'", MYSQLI_ASSOC);

		$data['FloorName'] = $this->db->getFirstRowFirstColumn("SELECT FloorName FROM floor where FID='" . mysqli_real_escape_string($this->db->mysql_link, $FID) . "'", MYSQLI_ASSOC);

		$data['RoomName'] = $this->db->getFirstRowFirstColumn("SELECT RoomName FROM room where RID='" . mysqli_real_escape_string($this->db->mysql_link, $RID) . "'", MYSQLI_ASSOC);

		
		$this->successMSG('Data', $data);
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
