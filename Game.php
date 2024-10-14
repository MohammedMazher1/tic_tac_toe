<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'GameStatue.php';
require_once 'Player.php';
require_once 'Gamemove.php';
header('Content-Type','application/json');
// header('Content-Type','application/json');


// $username ='mohammed';
$id=0;
if(isset($_GET["id"])){
    $id = $_GET["id"];
}

class Game {

    private  $players=[];
     public $board =[];
     private  $statue ;
     private   $Gamestatue ;

     private $playermove=0;

     function __construct() {
        $this->board =[
            [-1,-1,-1],
            [-1,-1,-1],
            [-1,-1,-1]
        ];
        $this->Gamestatue = new Gamestatue();
        $this->statue = $this->Gamestatue::AwitingPlayers;
     }
     public function showBoard(){

        echo '<table border="1" width=150 height=150>';
        foreach($this->board as $row){
            echo '<tr>';
            foreach($row as $column){
                if($column==0){
                    $column="X";
                }elseif($column== 1){
                    $column="O";}
                    else{
                        $column= "";
                    }
                echo '<td>'.$column.'</td>';
            }
            echo '</tr>';
     }
     echo '</table>';
    }

    function addplayer(Player $player){
        if($this->statue==1){
            if(count($this->players)< 2){
                $this->players[]=$player;
            }
            if(count($this->players)==2){
                $this->statue=$this->Gamestatue::Inplay;
            }
        }
        else{

            throw new Exception('you can not');
            
        }
    }
    function move(Gamemove $move){
        if($this->statue== 2){
            if($this->board[$move->x][$move->y]==-1){
                $this->board[$move->x][$move->y]=$this->playermove;
                if($this->isGameFinished($this->board)== 'win'){
                    echo 'win';
                    session_destroy();
                    return  'you win';
                }
                if(!$this->isGameFinished($this->board)){
                    echo 'draw';
                    session_destroy();
                    return  'draw';
                }
                echo $this->playermove;
                $this->playermove++;
                $this->playermove=$this->playermove % 2;

            }
            
        }
    }
    function isGameFinished($board){
        if($this->win($board)){ 
            return 'win';
        }
        elseif(!in_array(-1,$board[0]) && !in_array(-1,$board[1]) && !in_array(-1,$board[2])){
            return false;
        }else{
            return 'playing';
            
        }
    }
    function win($board){
        $article1 = [];
        $article2 = [];
        $sum1 =0;
        $sum2 =0;
    for($i=0;$i<count($board);$i++){
        if((array_sum(array_column($board,$i))== 0 || array_sum(array_column($board,$i)) == 3) && !in_array(-1,array_column($board,$i))){
            return true;
        }
        if((array_sum($board[$i])==0 || array_sum($board[$i]) == 3) && !in_array(-1,$board[$i])){
            return true;
        }
        for($j=0;$j<count($board[$i]);$j++){
            if($i==$j){
                if(isset($sum1)){
                    $article1[$i] = $board[$i][$j];
                    $sum1+=$board[$i][$j];
                }else{
                    $sum1=$board[$i][$j];
                }
            }
            if($i+$j==2){
                $sum2+=$board[$i][$j];
                $article2[$i] = $board[$i][$j];
            }
        }
        
    }   
     if(($sum1 == 0 || $sum1 ==3) && !in_array(-1,$article1)){
        return true;
     }
     if(($sum2 == 0 || $sum2 ==3) && !in_array(-1,$article2)){
        return true;
     }

     return false;
}
}
   
   
if(!isset($_SESSION['game'])){
    $_SESSION['game'] = new Game();
    $_SESSION['player1'] = new Player('mohammed');
    $_SESSION['player2']  = new Player('ahmed');
    $_SESSION['game']->addplayer($_SESSION['player1']);
    $_SESSION['game']->addplayer($_SESSION['player2']);
} 
function myGame($id){
    $game = $_SESSION['game'];
    switch ($id) {
        case 1:
            $point1=new Gamemove(0,0);
            $game->move($point1);
          break;
        case 2:
            $point2=new Gamemove(0,1);
            $game->move($point2);
          break;
        case 3:
            $point3=new Gamemove(0,2);
            $game->move($point3);
          break;
          case 4:
            $point4=new Gamemove(1,0);
            $game->move($point4);
          break;
          case 5:
            $point5=new Gamemove(1,1);
            $game->move($point5);
          break;
          case 6:
            $point6=new Gamemove(1,2);
            $game->move($point6);
          break;
          case 7:
            $point7=new Gamemove(2,0);
            $game->move($point7);
          break;
          case 8:
            $point8=new Gamemove(2,1);
            $game->move($point8);
          break;
          case 9:
            $point9=new Gamemove(2,2);
            $game->move($point9);
          break;
      }
    //   json_decode($_SESSION['game'])->showBoard();

      return json_encode($game->board);
}

// $Gamemove1_1=new Gamemove(0,2);
// $Gamemove2_1=new Gamemove(1,0);
// $Gamemove1_2=new Gamemove(2,0);
// $Gamemove2_2=new Gamemove(1,1);
// $Gamemove1_3=new Gamemove(2,1);
// $Gamemove2_3=new Gamemove(2,2);
// $Gamemove2_4=new Gamemove(0,1);
// $Gamemove2_5=new Gamemove(1,2);
// $game->move($Gamemove1_1);
// $game->move($Gamemove2_1);
// $game->move($Gamemove1_2);
// $game->move($Gamemove2_2);
// $game->move($Gamemove1_3);
// $game->move($Gamemove2_3);
// $game->move($Gamemove2_4);
// $game->move($Gamemove2_5);
// $game->showBoard();
// echo '<br>';
// echo '<br>';
// echo '<br>';
myGame($id);