<?php

class SalasCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('salas/index');
    }

    /**
     * Busca sala automaticamente , pero no existe ninguna disponible
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function noHaySalas(\FunctionalTester $I)
    {
        $I->amLoggedInAs(2);
        $I->amOnRoute('salas/buscar');
        $I->see('No hay salas disponibles , crea una si lo desea');
    }

    /**
     * Crea una sala publica
     * @param  FunctionalTester $I [description]
     * @return [type]              [description]
     */
    public function createSala(\FunctionalTester $I)
    {
        $I->amLoggedInAs(2);
        $I->amOnRoute('salas/create');
        $I->submitForm('#salas-form', [
            'Salas[nombre]' => 'prueba',
            'Salas[categoria_id]' => 1,
            'Salas[numero_participantes]' => 3
        ]);
        $I->see('prueba');
    }
}
