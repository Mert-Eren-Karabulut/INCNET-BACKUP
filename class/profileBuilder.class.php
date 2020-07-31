<?

class profileBuilder extends dbase{
	public $id;
	public $name;
	public $registerId;
	// in case of need to use info again...
	// empty arrays
	// once functions are used. we won't have to use'em again.
	public $userInfo = array();
	public $motherInfo = array();
	public $fatherInfo = array();
	public $relativeInfo = array();
	public $deviceInfo = array();
	public $summerCamp = array();

	public function __construct($userId){
	
		parent::__construct();		
	
		$this -> id = $userId;
	
		$getRegisterId_query = $this -> con -> prepare('SELECT registerId FROM profilesmain WHERE user_id = :id');
		
		$getRegisterId_query -> execute(array(':id' => $userId));

		$registerIdResults = $getRegisterId_query -> fetchAll();

		foreach($registerIdResults as $registerIdQuery){
		
			$this -> registerId = $registerIdQuery['registerId'];

		}
	
		$getName_query = $this -> con -> prepare('SELECT name, lastname FROM coreusers WHERE user_id = :id');
		
		$getName_query -> execute(array(':id' => $userId));

		$nameResults = $getRegisterId_query -> fetchAll();

		foreach($nameResults as $nameQuery){
		
			$this -> name = $nameQuery['name'] . ' ' . $nameQuery['lastname'];

		}
	
	}

	public function getStudentInfo(){
	
		//////////********** Get Student Info with this.id Return As Array **********\\\\\\\\\\
	
		$getStudentInfo_query = $this -> con -> prepare('SELECT * FROM profilesmain WHERE user_id = :id');
		
		$getStudentInfo_query -> execute(array(':id' => $this -> id));

		$studentInfoResults = $getStudentInfo_query -> fetchAll();

		foreach($studentInfoResults as $studentInfoQuery){

			
			array_push($this -> userInfo, 
						$studentInfoQuery['tckn'],	 $studentInfoQuery['class'], 		$studentInfoQuery['address'], 
						$studentInfoQuery['semt'],	 $studentInfoQuery['ilce'], 		$studentInfoQuery['il'], 
						$studentInfoQuery['zipcode'],	 $studentInfoQuery['homePhone'], 	$studentInfoQuery['cellPhone'], 
						$studentInfoQuery['email'],	 $studentInfoQuery['socialSecurity'], $studentInfoQuery['parent'],	
            $studentInfoQuery['parentsUnity'],  $studentInfoQuery['motherBio'],  $studentInfoQuery['motherLive'], 	
            $studentInfoQuery['fatherBio'], $studentInfoQuery['fatherLive']	);
			/*
			$this -> userInfo[] = $studentInfoQuery['tckn'];		
			$this -> userInfo[] = $studentInfoQuery['class'];		
			$this -> userInfo[] = $studentInfoQuery['address'];		
			$this -> userInfo[] = $studentInfoQuery['semt'];		
			$this -> userInfo[] = $studentInfoQuery['ilce'];		
			$this -> userInfo[] = $studentInfoQuery['il'];		
			$this -> userInfo[] = $studentInfoQuery['zipcpde'];		
			$this -> userInfo[] = $studentInfoQuery['homePhone'];		
			$this -> userInfo[] = $studentInfoQuery['cellPhone'];		
			$this -> userInfo[] = $studentInfoQuery['email'];		
			$this -> userInfo[] = $studentInfoQuery['socialSecurity'];		
			$this -> userInfo[] = $studentInfoQuery['parentsUnity'];		
			$this -> userInfo[] = $studentInfoQuery['motherBio'];		
			$this -> userInfo[] = $studentInfoQuery['fatherBio'];		
			$this -> userInfo[] = $studentInfoQuery['motherLive'];		
			$this -> userInfo[] = $studentInfoQuery['fatherLive'];		
			$this -> userInfo[] = $studentInfoQuery['parent'];
			*/
			}
	}
	public function getRelativeInfo(){
	
		//////////********** Get Relative Info with this.id Return As Array **********\\\\\\\\\\

		//get Mother Info First
		//Ladies First ;) :D
	
		$getMotherInfo_query = $this -> con -> prepare('SELECT * FROM profilesmotherinfo WHERE registerId = :registerId');
		
		$getMotherInfo_query -> execute(array(':registerId' => $this -> registerId));

		$motherInfoResults = $getMotherInfo_query -> fetchAll();

		foreach($motherInfoResults as $motherInfo){

			array_push($this -> motherInfo,
							$motherInfo['name'],       $motherInfo['lastname'],      		$motherInfo['DOB'], 		
              $motherInfo['tckn'],       $motherInfo['address'],        	$motherInfo['semt'], 		
              $motherInfo['ilce'],       $motherInfo['il'], 	           	$motherInfo['zipcode'], 	
              $motherInfo['homePhone'],  $motherInfo['cellPhone'],      	$motherInfo['fax'], 		
              $motherInfo['email'],      $motherInfo['socialSecurity'], 	$motherInfo['profession'], 	
              $motherInfo['work'],       $motherInfo['company'], 	        $motherInfo['workAddress'], 	
              $motherInfo['workCity'],   $motherInfo['workPhone']);

		}

		//Then Father Info
	
		$getFatherInfo_query = $this -> con -> prepare('SELECT * FROM profilesfatherinfo WHERE registerId = :registerId');
		
		$getFatherInfo_query -> execute(array(':registerId' => $this -> registerId));

		$fatherInfoResults = $getFatherInfo_query -> fetchAll();

		foreach($fatherInfoResults as $fatherInfo){

			array_push($this -> fatherInfo,
							$fatherInfo['name'],        $fatherInfo['lastname'],      		$fatherInfo['DOB'], 		
              $fatherInfo['tckn'],        $fatherInfo['address'],          	$fatherInfo['semt'], 		
              $fatherInfo['ilce'],        $fatherInfo['il'], 	            	$fatherInfo['zipcode'], 	
              $fatherInfo['homePhone'],   $fatherInfo['cellPhone'],       	$fatherInfo['fax'], 		
              $fatherInfo['email'],	      $fatherInfo['socialSecurity'], 	  $fatherInfo['profession'], 	
              $fatherInfo['work'],	      $fatherInfo['company'],          	$fatherInfo['workAddress'], 	
              $fatherInfo['workCity'],    $fatherInfo['workPhone']);

		}

		//Now its time for relatives
	
		$getRelativesInfo_query = $this -> con -> prepare('SELECT * FROM profilesrelatives WHERE registerId = :registerId');
		
		$getRelativesInfo_query -> execute(array(':registerId' => $this -> registerId));

		$relativesInfoResults = $getRelativesInfo_query -> fetchAll();

		foreach($relativesInfoResults as $relativesInfo){

			// 0-12 for first relative 13-25 for 2nd relative, 25-37 for 3rd and goes on ...

			array_push($this -> relativeInfo,
							$relativesInfo['name'],         $relativesInfo['lastname'], 	 		$relativesInfo['relation'],	
              $relativesInfo['address'],    	$relativesInfo['semt'], 		      $relativesInfo['ilce'],		
              $relativesInfo['il'],           $relativesInfo['zipcode'],     		$relativesInfo['homePhone'],	
               $relativesInfo['cellPhone'],   $relativesInfo['fax'], 	      		$relativesInfo['email'],
						 	$relativesInfo['profession'], 		$relativesInfo['workPhone'], $relativesInfo['relativeId']); 

		}

	}

	public function getDeviceInfo(){
	
		//////////********** Get Device Info with this.id Info Return As Array **********\\\\\\\\\\
	
		$getDevicesInfo_query = $this -> con -> prepare('SELECT * FROM profilesdevices WHERE registerId = :registerId');
		
		$getDevicesInfo_query -> execute(array(':registerId' => $this -> registerId));

		$devicesInfoResults = $getDevicesInfo_query -> fetchAll();

		foreach($devicesInfoResults as $devicesInfo){

			// 0-3 for 1st device , 4-7 for 2nd device and goes on ... 

			array_push($this -> deviceInfo,
							$devicesInfo['registerDate'], 	$devicesInfo['type'],		
							$devicesInfo['make'], 		$devicesInfo['identifier'],
              $devicesInfo['deviceId']); 

		}
	}

	public function  getSummerCamp(){
	
		//////////********** Get Summer Camps Info with this.id Info Return As Array **********\\\\\\\\\\
	
		$getSummerCampInfo_query = $this -> con -> prepare('SELECT * FROM profilessummercamps WHERE registerId = :registerId');
		
		$getSummerCampInfo_query -> execute(array(':registerId' => $this -> registerId));

		$summerCampInfoResults = $getSummerCampInfo_query -> fetchAll();

		foreach($summerCampInfoResults as $summerCampInfo){
	
			//0-4 for 1st camp, 5-9  for 2dn camp, and goes on ...

			array_push($this -> summerCamp,
							$summerCampInfo['institution'], 	$summerCampInfo['program'],		
							$summerCampInfo['country'], 		$summerCampInfo['city'],
							$summerCampInfo['dateAdded'], $summerCampInfo['campId']); 

		}

	}
  
  public function checkTCKN($tckn){
    if(($tckn[0] == 0)||(($tckn[10]%2)==1)||(!(((((($tckn[0]+$tckn[2]+$tckn[4]+$tckn[6]+$tckn[8])*7)-($tckn[1]+$tckn[3]+$tckn[5]+$tckn[7]))%10)==$tckn[9])&&((($tckn[0]+$tckn[1]+$tckn[2]+$tckn[3]+$tckn[4]+$tckn[5]+$tckn[6]+$tckn[7]+$tckn[8]+$tckn[9])%10)==$tckn[10])))){
      return false;
    }else{
      return true;
    } 
  }

}
?>
