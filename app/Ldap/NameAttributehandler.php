<?php

namespace App\Ldap;

use App\Models\User as DatabaseUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class NameAttributehandler
{
    public function handle(LdapUser $ldap, DatabaseUser $database)
    {

        $database->name=ucwords(strtolower(explode('-',  $ldap->getFirstAttribute('cn'))[0]));
    }
}
