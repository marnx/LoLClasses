<?php
        
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    //include all the classes
    foreach (glob("classes/*.php") as $filename)
    {
        include_once $filename;
    }
    
    $region = "euw";
    $username = "loulex"; 
    
    //nieuw instantie van API in regia euw
    $api_eu = new riotapi($region);
    $summoner = new summoner($api_eu->getSummonerByName($username) , true);
   
    $gamejson = $summoner->getLiveGameData();
    echo var_dump($gamejson);
    //$currentgame = new livegame($gamejson);

    //$currentgame->printData();
    
?>