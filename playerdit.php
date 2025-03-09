<?php
include("config.php");

class playerdit {
    private $conn;
    private $player_id;
    private $p_name;
    private $role;
    private $P_point;
    private $bat_SR;
    private $ball_SR;
    private $econ_rate;
    private $price;

    private $tot_runs;
    private $totBF;
    private $innins;
    private $tot_balls;
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
    public function setTotruns($tot_runs) {
        $this->tot_runs = $tot_runs;
    }
    public function setTotBF($totBF) {
        $this->totBF = $totBF;
    }
    public function setInnins($innins) {
        $this->innins = $innins;
    }
    public function setTotBallF($tot_balls) {
        $this->tot_balls = $tot_balls;
    }
    public function setTotwickets($tot_wickets) {
        $this->tot_wickets = $tot_wickets;
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

    public function calcBat_SR() {
        if ($this->totBF == 0) {
            return 0; // Avoid division by zero
        }
        $this->bat_SR = ($this->tot_runs / $this->totBF) * 100;
        return (float) $this->bat_SR;
    }
    
    public function calcBat_avg() {
        if ($this->innins == 0) {
            return 0; // Avoid division by zero
        }
        $this->bat_avg = ($this->tot_runs / $this->innins);
        return (float) $this->bat_avg;
    }
    
    public function calcBall_SR() {
        if ($this->tot_wickets == 0) {
            return 0; // Avoid division by zero
        }
        $this->ball_SR = ($this->tot_balls / $this->tot_wickets);
        return (float) $this->ball_SR;
    }
    
    public function calcEcon_Rate() {
        if ($this->tot_balls == 0) {
            return 0; // Avoid division by zero
        }
        $this->econ_rate = ($this->tot_runs / $this->tot_balls) * 6;
        return (float) $this->econ_rate;
    }
    
    public function calcPlayerPoint() {
        $x = ($this->tot_runs / 5);
        
        $y = ($this->bat_avg > 0) ? (($this->bat_avg * 8) / 10) : 0;
        
        $c = ($this->ball_SR > 0) ? (500 / $this->ball_SR) : 0;
        
        $v = ($this->econ_rate > 0) ? (140 / $this->econ_rate) : 0;
        
        $this->P_point = $x + $y + $c + $v;
        return (float) $this->P_point;
    }
    
    public function calcValue() {
        if ($this->P_point == 0) {
            return 100000; // Default base price when P_point is zero
        }
        $this->price = ($this->P_point * 9 + 100) * 1000;
        return number_format((float) $this->price, 2, '.', '');
    }

    
    public static function getById($id) {
        include("config.php");

        $stmt = $conn->prepare("SELECT * FROM player WHERE player_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $player = new playerdit(
                $conn,
                $data['playername'],
                $data['role'],
                $data['p_point'],
                $data['bat_SR'],
                $data['ball_SR'],
                $data['Econ_rate'],
                $data['Price']
            );

            $player->player_id = $data['player_id'];
            return $player;
        }
        return null;
    }
    public function setPlayername($playername) {
        $this->p_name = $playername;
    }
    public function setRole($role) {
        $this->role = $role;
    }



    
}
?>
