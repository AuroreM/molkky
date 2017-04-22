<?php

class MolkkyGameTest extends PHPUnit_Framework_TestCase
{
    public function testNoPinHasFallen()
    {
        $molkky = new MolkkyGame();
        for ($i = 0; $i < 10; $i++) {
            $molkky->knockOver('Aurore', [0]);
        }
        $this->assertSame(0, $molkky->score('Aurore'));
    }

    public function testOnePinHasFallen()
    {
      $molkky = new MolkkyGame();
      for ($i = 0; $i < 10; $i++) {
          $molkky->knockOver('Aurore', [5]);
      }
        $this->assertSame(50, $molkky->score('Aurore'));
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
