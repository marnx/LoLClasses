<?php
        
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    //include all the classes
    foreach (glob("classes/*.php") as $filename)
    {
        include_once $filename;
    }
    
    $region = "euw";
    $username = "Cinazu";
    
    //nieuw instantie van API in regia euw
    $api_eu = new riotapi($region);
    
    $summoner = new summoner($region,$api_eu->getSummonerByName($username) , true);
   
   
    echo $summoner->getId();
    echo var_dump($summoner->getLiveGameData());
    //$gamejson = $summoner->getLiveGameData();
    //echo var_dump($api_eu->getSummonerByName($username));
?>