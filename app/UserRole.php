<?php

namespace App;

enum UserRole:string
{
    //
    case admin = 'admin';
    case user = 'user';
    case manager = 'manager';
}
