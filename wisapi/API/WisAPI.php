<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); //
//ini_set('display_errors', 1); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mpdf\Mpdf;
//Author of this file Aparna
//require 'vendor/autoload.php';
require "../utilities/vendor/autoload.php";

use \Firebase\JWT\JWT;

define('SiteURL', 'https://igreen.systems/wissuperadmin/WisAPI/');

require_once("../utilities/Rest.inc.php");
require_once("../utilities/class.MySQL.php");
require_once("../utilities/functions.php");
class WisAPI extends REST
{
	private $db;
	private $appSecret = "dfhfhfi&9)jnd%sndn&565ggghGGdedj*nsn&jsdnjdnj";
	private $jwtPassThroughRoutes = array("logout");
	private $logIndex = 0;
	private $EmpID = 0;
	private $EmailID = '';
	private $RoleID = '';
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
	echo "sdsd";
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
		if ($this->db->hasRecords("SELECT * FROM `employees` WHERE EmpID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->EmpID) . "' AND EmailID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->EmailID) . "' AND RoleID='" . mysqli_real_escape_string($this->db->mysql_link, $data->data->Role) . "';")) {
			$this->EmpID = $data->data->EmpID;
			$this->EmailID = $data->data->EmailID;
			$this->RoleID = $data->data->RoleID;
			$this->FBTokenID = $data->data->FBTokenID;
			return 1;
		} else {
			$this->errorMSG(401, "Authentication Failed.!");
		}
	}
	private function getJWToken($userIndex, $email, $role, $FBTokenID, $secret)
	{
		$token = array(
			"iss" => "https://sonijewellers.co",
			"aud" => "https://sonijewellers.co",
			"iat" => time(),
			"nbf" => time() + 0,
			"exp" => time() + 8640000,
			"data" => [                  	// Data related to the signer user
				'EmpID'   => $userIndex, 		// userIndex from the users table
				'EmailID' => $email,
				'RoleID' => $role,
				'FBTokenID' => $FBTokenID
			]
		);
		$jwt = JWT::encode($token, $secret);
		return $jwt;
	}
	private function revokeJWToken($userIndex, $email, $role, $FBTokenID, $secret)
	{
		$token = array(
			"iss" => "https://sonijewellers.co",
			"aud" => "https://sonijewellers.co",
			"iat" => time(),
			"nbf" => time() + 0,
			"exp" => time() + 8640000,
			"data" => [                  	// Data related to the signer user
				'EmpID'   => $userIndex, 		// userIndex from the users table
				'EmailID' => $email, 	// email
				'RoleID' => $role,
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
				$sql = "SELECT e.RoleID,e.EmpID,e.EmpName,e.EmailID,e.Contact,e.Gender,e.Address,e.JobType,e.Contact,e.City,e.Password,e.Status,e.CreatedDate,e.UpdatedDate FROM employees as e LEFT JOIN roles as r
				ON r.RoleID = e.RoleID WHERE e.EmailID = '" . mysqli_real_escape_string($this->db->mysql_link, $email) . "' AND e.Status=1";
				$this->db->executeQuery($sql);
				
			//	echo $this->db->getLastSQLStatement();exit;
				if ($this->db->getRowsCount() == 1) {
					$row = $this->db->getCurrentRow();
				
					if (verifyPassword($password, $row->Password)) {
						if ($row->Status != "1") {
							$this->errorMSG(400, "Your account is temporarily suspended. Please contact administrator.");
						}
						if ($row->Status != "") {
							$FBTokenID = 0;
							if (isset($firebase_token)) {
								if ($firebase_token != "") {
									$this->db->executeQuery("INSERT INTO `fcmtokens`(`EmpID`, `Token`, `CreatedDate`) VALUES('" . mysqli_real_escape_string($this->db->mysql_link, $row->EmpID) . "','" . $firebase_token . "','" . date('Y-m-d H:i:s') . "');");
									$FBTokenID = $this->db->getLastInsertID();
								}
							}
							$jwt = $this->getJWToken($row->EmpID, $row->EmailID, $row->RoleID, $FBTokenID, $this->appSecret);
							$result = json_decode(json_encode($row), true);
							$result['accessToken'] = $jwt;
							$result['fb'] = $FBTokenID;
							$result  = filterUserData($result);
							$this->successMSG('Authentication Successful.!', $result);
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
		$role = $this->RoleID;
		$FBTokenID = $this->FBTokenID;
		//exit;

		try {

			$sql1 = "DELETE FROM `fcmtokens` WHERE TokenID='" . mysqli_real_escape_string($this->db->mysql_link, $FBTokenID) . "'";

			if (!$this->db->executeQuery($sql1)) {



				$this->errorMSG(400, "There is a network error while processing your request. Please try again later..!");
			} else {



				$jwt = $this->revokeJWToken($userIndex, $email, $role, $FBTokenID, $this->appSecret);







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
		if ($this->get_request_method() != "GET") {
			$this->errorMSG(406, "Wrong HTTP Method");
		}
		$query1 = $this->db->executeQueryAndGetArray("SELECT o.OrgID,o.OrgName,o.OrgType,o.Address,o.Langitude,o.Latitude,o.Status,ot.OrganizationType FROM organization o left join organization_type ot ot.TypeID=o.OrgType", MYSQLI_ASSOC);
		
		
		/// dropdown view
		/*foreach ($query1 as $q) {
			$items[$q['EmpID']] = $q['EmployeeName'];
		}*/
		$this->successMSG('Organizations list', $query1);
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
