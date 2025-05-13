<?php

namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class LocationAttributehandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database)
    {
        $stateNames = ['Agartala','Ahmedabad','Ankleshwar','Bokaro','Cambay','Chennai','Dehradun','Goa','Hazira','Hyderabad','Jodhpur','Jorhat','Karaikal','Kolkata','Mehsana','Mumbai','Nazira','Panvel','Rajamundary','Sibsagar','Silchar','Uran','Vadodra','Nhava'];
        $pattern = '/OU=(' . implode('|', array_map('preg_quote', $stateNames)) . '),/';
        $matchedState=null;
        if (preg_match($pattern, $ldap->getFirstAttribute('distinguishedname'), $matches)) {
            $matchedState = $matches[1];
        }
        // $location=SapLocationCodeMapping::where('saplocationcode',$ldap->getFirstAttribute('physicaldeliveryofficename'))->first();
        $database->location = $matchedState;
        // $database->location = $location->location;

    }
}
