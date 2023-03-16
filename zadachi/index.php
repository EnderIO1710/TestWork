<?php
    //Задача 4
    if(!empty($_GET['gid'])){$groupId=(int)$_GET['gid'];}
    else{$groupId=0;}
    
    $groupList='';
    $prodList='';

    $query="WITH Recursive Query (`id`, `id_parent`, `name`)
      AS
      (
        SELECT `id`, `id_parent`, `name`
        FROM `groups` g
        WHERE g.`id` = '$groupId'
        UNION ALL
        SELECT g.`id`, g.`id_parent`, g.`name`
        FROM `groups` g
        JOIN Query rec ON rec.`id_parent` = g.`id`
      )
      SELECT * FROM `groups` WHERE `id_parent` IN (SELECT `id_parent` FROM Query) OR `id_parent`='$groupId';";

    $db=mysqli_connect('localhost', 'root', '', 'testproject');
    $result=mysqli_query($db, $query);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $all[]=$row;
        }
        if(isset($all)){ 
            $groupList=PrintUl($all);
        }
        if(!empty($groupList)){$groupList='<ul>'.$groupList.'</ul>';}
    }

    function PrintUl($arr, $lvl=0){
      $return='';
      foreach($arr as $val){
          if($val['id_parent']==$lvl){
              $return.='<li><a href="/?gid='.$val['id'].'">'.$val['name'].'</a></li>'.PHP_EOL;
              $temp=PrintUl($arr, $val['id']);
              if(!empty($temp)){$return.='<ul>'.$temp.'</ul>'.PHP_EOL;}
          }
      }
    return $return;
}
    $query2="WITH Recursive Query (`id`, `id_parent`, `name`)
    AS
    (
      SELECT `id`, `id_parent`, `name`
      FROM `groups` g
      WHERE g.`id_parent` = '$groupId'
      UNION ALL
      SELECT g.`id`, g.`id_parent`, g.`name`
      FROM `groups` g
      JOIN Query rec ON rec.`id` = g.`id_parent`
    )
    SELECT * FROM `products` WHERE `id_group` IN (SELECT `id` FROM `groups` WHERE `id_parent` IN (SELECT `id_parent` FROM Query) OR `id_group`='$groupId');";
    $result=mysqli_query($db, $query2);
    if($result){
      $prodList.='<ol>';
      while($row=mysqli_fetch_assoc($result)){
          $prodList.='<li>'.$row['name'].'</li>';
      }
      $prodList.='</ol>';
    }

  mysqli_close($db);
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>Test Project</title>
 </head>
 <body>
    <Table><tr>
      <td style="vertical-align:top;"><?=$groupList?></td>
      <td style="vertical-align:top;"><?=$prodList?></td>
    </tr></table>
 </body>
</html>