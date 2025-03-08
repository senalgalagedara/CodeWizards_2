<?php
class Player {
    private $player_id;
    private $p_name;
    private $role;
    private $P_point;
    private $bat_SR;
    private $ball_SR;
    private $econ_rate;
    private $price;

    private $tot_runs;
    private $tot_balls;
    private $innins;
    private $tot_wickets;
    private $bat_avg;

    public function __construct($p_name, $role, $P_point = 0, $bat_SR = 0, $ball_SR = 0, $econ_rate = 0, $price = 0) {
        $this->p_name = $p_name;
        $this->role = $role;
        $this->P_point = $P_point;
        $this->bat_SR = $bat_SR;
        $this->ball_SR = $ball_SR;
        $this->econ_rate = $econ_rate;
        $this->price = $price;
    }

    public function setBattingStats($tot_runs, $tot_balls, $innins) {
        $this->tot_runs = $tot_runs;
        $this->tot_balls = $tot_balls;
        $this->innins = $innins;
    }

    public function setBowlingStats($tot_wickets, $tot_balls, $tot_runs) {
        $this->tot_wickets = $tot_wickets;
        $this->tot_balls = $tot_balls;
        $this->tot_runs = $tot_runs;
    }

    public function getName() {
        return $this->p_name;
    }

    public function getRole() {
        return $this->role;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPlayerPoints() {
        return $this->P_point;
    }

    public function calcPlayerPoint() {
        $this->P_point = (($this->bat_SR / 5) + ($this->bat_SR * 0.8)) + ((500 / $this->ball_SR) + (140 / $this->econ_rate));
        return $this->P_point;
    }

    public function calcBat_SR() {
        $this->bat_SR = ($this->tot_runs / $this->tot_balls) * 100;
        return $this->bat_SR;
    }

    public function calcBat_avg() {
        $this->bat_avg = ($this->tot_runs / $this->innins);
        return $this->bat_avg;
    }

    public function calcBall_SR() {
        $this->ball_SR = ($this->tot_balls / $this->tot_wickets);
        return $this->ball_SR;
    }

    public function calcEcon_Rate() {
        $this->econ_rate = ($this->tot_runs / $this->tot_balls) * 6;
        return $this->econ_rate;
    }

    public function calcValue() {
        $this->price = (9 * ($this->P_point) + 100) * 100;
        return $this->price;
    }
}
?>
