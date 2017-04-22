<?php

class MolkkyGameTest extends PHPUnit_Framework_TestCase
{
    private $molkky;

    public function setUp()
    {
        $this->molkky = new MolkkyGame();
    }

    public function testNoPinHasFallen()
    {
        $this->knockOverTen(0);
        $this->assertSame(0, $this->molkky->score('Aurore'));
    }

    public function testOnePinHasFallen()
    {
        $this->knockOverTen(5);
        $this->assertSame(50, $this->molkky->score('Aurore'));
    }

    private function knockOverTen($pin)
    {
        for ($i=0; $i < 10 ; $i++) {
            $this->molkky->knockOver('Aurore', [$pin]);
        }
    }
}

class MolkkyGame
{
    private $score;

    public function initiateOrder($players)
    {

    }

    public function knockOver($name, $pins)
    {
        $this->score += $pins[0];
    }

    public function score($name)
    {
        return $this->score;
    }
}
