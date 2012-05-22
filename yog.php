<?php

class yog {

  private static $level = 0;
  private static $array = array();

  function yogThis($text) {
    $text = yog::parseSections($text);
    return $text;
  }
  
  
  function mktitle($text)
  {
    $actions  = '/^(\*+) (TODO|DONE|WAITING|CONTACT|NEXT|STARTED|CLOSED) (.*)/';
    $tags     = "/(.*) (:.*):/s";
    
    $labels   = array();
    $labelstr = "";
    
    if (preg_match($actions, $text, $matches))
    {
      $text = $matches[2];
      $label  = strtolower($matches[1]);
      
      switch($label)
      {
        case "todo":
          $labelstr.= "<span class=\"label label-important\">$label</span> ";
        break;
        
        case "done":
        case "close":
          $labelstr.= "<span class=\"label label-success\">$label</span> ";
        break;
        
        case "waiting":
        case "contact":
          $labelstr.= "<span class=\"label label-warning\">$label</span> ";
        break;
        
        case "next":
        case "started":
        default:
          $labelstr.= "<span class=\"label label-info\">$label</span> ";
        break;
      }
    }
    
    if (preg_match($tags, $text, $matches))
    {
      $text   = $matches[1];
      $labels = explode(":",substr($matches[2],1));
      
      foreach($labels as $label)
        $labelstr.= "<span class=\"label\">$label</span> ";
    }

    if ($level == 1)
    {
      return  $this->tl()."<div class=\"page-header\">\n".
              sprintf("<h%d>%s %s</h%d>\n", $level, trim($text), $labelstr, $level).
              $this->tl()."</div>\n";
    }
    else
    {
      return sprintf("<h%d>%s %s</h%d>\n", $level, trim($text), $labelstr, $level);
    }
  }

  function parseSections($text)
  {
     return $text;   
  }
  
}