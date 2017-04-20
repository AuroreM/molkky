<?php

class MolkkyGameTest extends PHPUnit_Framework_TestCase
{
    public function testNoPinHasFallen()
    {
        $molkky = new MolkkyGame();
        for ($i=0; $i < 10 ; $i++) {
            $molkky->knockOver('Aurore', [0]);
        }

        $this->assertSame(0, $molkky->score('Aurore'));
    }
}

class MolkkyGame
{
    public function initiateOrder($players)
    {

    }

    public function knockOver($name, $pins)
    {

    }

    public function score($name)
    {
        return 0;
    }
}
