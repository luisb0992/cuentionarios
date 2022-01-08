<?php

/**
 * Final clase para la enumeración de los roles de distintos usuarios
 *
 * @author LuisBarDev <luisbardev@gmail.com> <luisbardev.com>
 * @copyright 2022 Project 4 Design
 */

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Lang;

final class RolEnum extends Enum
{
    // Rol para administradores.
    const ADMIN = 1;

    // Rol para usuarios normales.
    const USER = 2;

    // Rol para usuarios desarrolladores.
    const DEV = 3;

    /**
     * Proporciona casting de la enumeración al tipo string
     *
     * @return string   Nombre del rol
     */
    public function __toString():string
    {
        switch ($this->value) {
            case self::ADMIN:
                return Lang::get('Administrador');
            case self::USER:
                return Lang::get('Usuario');
            case self::DEV:
                return Lang::get('Desarrollador');
            default:
        }
    }
}
