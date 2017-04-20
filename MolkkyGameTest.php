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
        $this->knockOverTen('Aurore', 0);
        $this->assertSame(0, $this->molkky->score('Aurore'));
    }

    public function testOnePinHasFallen()
    {
        $this->knockOverTen('Aurore', 5);
        $this->assertSame(50, $this->molkky->score('Aurore'));
    }

    public function testScoreCanNotExceedFifty()
    {
        $this->knockOverTen('Aurore', 4);
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
        $this->knockOverTen('Geoffrey', 3);
        $this->knockOverTen('Paul', 5);
        $this->assertEquals(30, $this->molkky->score('Geoffrey'));
        $this->assertEquals(50, $this->molkky->score('Paul'));
    }

    public function testGoBackToZeroIfFirstPlayerHasBeenCaughtUp()
    {
        $this->molkky->initiateOrder(['Geoffrey', 'Paul']);
        $this->molkky->knockOver('Geoffrey', [3]);
        $this->molkky->knockOver('Paul', [8]);
        $this->molkky->knockOver('Geoffrey', [11]);
        $this->molkky->knockOver('Paul', [6]);
        $this->molkky->knockOver('Geoffrey', [4]);
        $this->molkky->knockOver('Paul', [6]);

        $this->assertEquals(4, $this->molkky->score('Geoffrey'));
        $this->assertEquals(20, $this->molkky->score('Paul'));
    }

    private function knockOverTen($name, $pin)
    {
        for ($i=0; $i < 10 ; $i++) {
            $this->molkky->knockOver($name, [$pin]);
        }
    }
}

class MolkkyGame
{
    private $rolls;
    private $lapOrder;

    public function initiateOrder($players)
    {
        if (count($players) > 1) {
            foreach ($players as $player) {
                $this->lapOrder[] = $player;
            }
        }
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
            if ($this->lapOrder) {
                foreach ($this->rolls as $playerName => $rolls) {
                    if (array_search($playerName, $this->lapOrder) > array_search($name, $this->lapOrder) && $this->getLapScore($playerName, $i) === $score) {
                        $score = 0;
                    }
                }
            }
            if ($score > 50) {
                $score = 25;
            }
        }

        return $score;
    }

    public function getLapScore($name, $lap)
    {
        $score = 0;
        $playerRolls = $this->rolls[$name];
        for ($i = 0; $i <= $lap; $i++) {
            $score += $playerRolls[$i];
            if ($score > 50) {
                $score = 25;
            }
        }

        return $score;
    }
}
