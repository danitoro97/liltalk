<?php

class UsuariosCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('usuario/create');
    }

    /**
     * Comprueba si se realiza bien el registros y se manda un correo
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function crearCuenta(\FunctionalTester $I)
    {

        $I->submitForm('#create-form', [
            'Usuarios[nombre]' => 'prueba',
            'Usuarios[password]' => 'cat9eat',
            'Usuarios[password_repeat]' => 'cat9eat',
            'Usuarios[email]' => 'danitonispam@gmail.com',

        ]);
        $I->see('Se ha enviado un correo de verificacion , por favor revise su cuenta de correo');
    }

    /**
     * Crear una cuenta sin los atributos necesarios
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function crearCuentaError(\FunctionalTester $I)
    {
        $I->submitForm('#create-form', [
            'Usuarios[nombre]' => 'prueba',
        ]);

        $I->see('Repetir contraseña no puede estar vacío.');
        $I->see('Contraseña no puede estar vacío.');
        $I->see('Correo electronico no puede estar vacío');
    }

    /**
     * Un usuario cambia de correo y se le vuelve a enviar un correo de verifiacion
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function actualizarUsuario(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Usuarios(toro)');
        $I->amOnRoute('usuario/update');
        $I->submitForm('#create-form', [
            'Usuarios[nombre]' => 'toro',
            'Usuarios[email]' => 'danitonispam@gmail.com',
        ]);
        $I->see('Se ha enviado un correo de verificacion , por favor revise su cuenta de correo');
    }

}
