<?php

namespace Modules\Permission\Enums;

enum ModuleStatus: String
{
    case SUPER_ADMIN = 'Super Admin';
    case PUSAT = 'Pusat';
    case PROVINCE = 'Province';
    case KOTA_KAB = 'Kota/Kab';
    case USER = 'User';
}
