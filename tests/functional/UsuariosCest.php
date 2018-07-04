<?php

class UsuariosCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('usuario/create');
    }

    public function crearCuenta(\FunctionalTester $I)
    {

        $I->submitForm('#create-form', [
            'Usuarios[nombre]' => 'prueba',
            'Usuarios[password]' => 'cat9eat',
            'Usuarios[password_repeat]' => 'cat9eat',
            'Usuarios[email]' => 'danitonispam@gmail.com',

        ]);
        $I->see('Review email');
    }

}
