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

    public function testScoreCanNotExceedFifty()
    {
        $this->knockOverTen(4);
        $this->molkky->knockOver('Aurore', [12]);
        $this->assertEquals(25, $this->molkky->score('Aurore'));
    }

    public function testSeveralPinHaveFallen()
    {
        $this->molkky->knockOver('Aurore', [12,9,6,7]);
        $this->assertEquals(4, $this->molkky->score('Aurore'));
    }

    public function testIsAMutliPlayersGame()
    {
        for ($i=0; $i < 10 ; $i++) {
            $this->molkky->knockOver('Geoffrey', [3]);
        }
        for ($i=0; $i < 10 ; $i++) {
            $this->molkky->knockOver('Paul', [5]);
        }
        $this->assertEquals(30, $this->molkky->score('Geoffrey'));
        $this->assertEquals(50, $this->molkky->score('Paul'));
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
    private $rolls;

    public function initiateOrder($players)
    {

    }

    public function knockOver($name, $pins)
    {
        if (count($pins) > 1) {
           $this->rolls[$name][] += count($pins);
        } else {
           $this->rolls[$name][] += $pins[0];
        }
    }

    public function score($name)
    {
        $score = 0;
        $playerRolls = $this->rolls[$name];
        for ($i = 0; $i < count($playerRolls); $i++) {
            $score += $playerRolls[$i];
            if ($score > 50) {
                $score = 25;
            }
        }

        return $score;
    }
}
