<?php
class compare
{
  function is($op1,$op2,$c)
  {
     $meth = array('=' => 'eq', '<' => 'lt', '>' => 'gt', '<=' => 'lte', '>=' => 'gte', '!=' => 'ne');
     if($method = $meth[$c]) {
        return $this->$method($op1,$op2);
     }
     return null; // or throw excp.
  }
  function eq($op1,$op2)
  {
      return $op1 == $op2;
  }
  function lt($op1,$op2)
  {
      return $op1 < $op2;
  }
  function gt($op1,$op2)
  {
      return $op1 > $op2;
  }
  function lte($op1,$op2)
  {
      return $op1 <= $op2;
  }
  function gte($op1,$op2)
  {
      return $op1 >= $op2;
  }
  function ne($op1,$op2)
  {
      return $op1 != $op2;
  }
}

?>
