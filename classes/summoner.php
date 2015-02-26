<?php

include_once 'api.php';
//include_once 'livegame.php';
//class representing a summoner and its data
class summoner {

    private $responseCode;
    private $key;
    private $id;
    private $name;
    private $level;
    private $iconid;
    private $rev;
    private $json;
    private $value;    
    private $regionid;

	private static $errorCodes = array(0   => 'NO_RESPONSE',
									   400 => 'BAD_REQUEST',
									   401 => 'UNAUTHORIZED',
									   404 => 'NOT_FOUND',
									   429 => 'RATE_LIMIT_EXCEEDED',
									   500 => 'SERVER_ERROR',
									   503 => 'UNAVAILABLE');
    
    
	public function __construct($region,$summonerjson,$decoded = FALSE)
	{
	   if(!$decoded)
       {
            
            $this->json = json_decode($summonerjson, true);
       }
       else
       {
            $this->json = $summonerjson;
       } 
      
  	    list($key, $value) = each($this->json);
    
        $this->id       = $value['id'];
        $this->name     = $value['name'];
        $this->level    = $value['summonerLevel'];
        $this->iconid   = $value['profileIconId'];
        $this->rev      = $value['revisionDate'];
        
        $api = new riotapi($region);
	}
    
    public function getLiveGameData()
    {
        $url = "https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/$this->id?api_key=27f8cd68-9842-4e1b-bcd5-2baaaa32dc62";
    	//call the API and return the result
    	$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        curl_exec($ch);
        $this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($this->responseCode == 200) 
        {
            $this->json = curl_exec($ch);
            $array = json_decode($this->json,true);
            return $array;
        } 
        else 
        {
            echo 'ERROR    :   <b>' . self::$errorCodes[$this->responseCode];
        }	
    	curl_close($ch);
    }
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function getIconId()
    {
        return $this->iconid;
    }
    
    public function getLastRevisionDate()
    {
        return $this->rev;
    }
    
    public function getArray()
    {
        return array($this->id,$this->name,$this->level,$this->iconid,$this->rev);
    }
    
    public function getJSON()
    {
        return json_encode(array($this->id,$this->name,$this->level,$this->iconid,$this->rev));
    }
    
    public function print_values()
    {
        echo '<br>id ' .$this->id .'<br>';
        echo '<br>name ' .$this->name .'<br>';
        echo '<br>level ' .$this->level .'<br>';
        echo '<br>icon ' .$this->iconid .'<br>';
        echo '<br>rev ' .$this->rev;
    }
    
}

?>