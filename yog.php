<?php

class yog {

  /*\
  }o{ Configurations
  \*/
  
  private static $keys  = array("TODO"    => "important",
                                "DONE"    => "success", 
                                "WAITING" => "warning",
                                "CONTACT" => "warning",
                                "NEXT"    => "info",  
                                "STARTED" => "info",
                                "CLOSED"  => "success");
  /*\
  }o{ Variable Declaration
  \*/
  
  private static $level   = 0;

  
  /*\
  }o{ Methods
  \*/
  function yogThis($text) {
    $text = yog::parseSections($text);
    return $text;
  }
  
  
  private static function mktitle($matches)
  {
    $text     = $matches[2];
    $level    = strlen($matches[1]);
    $rkeys    = '/^('.join("|",array_keys(yog::$keys)).') (.*)/';
    $rtags     = '/(.*) (:.*):/s';
    
    $labels   = array();
    $labelstr = "";
    
    if (preg_match($rkeys, $text, $matches))
    {
      $text     = $matches[2];
      $label    = $matches[1];
      $labelstr.= "<span class=\"label label-".yog::$keys[$label]."\">"
                  .strtolower($label)."</span> ";
    }
    
    if (preg_match($rtags, $text, $matches))
    {
      $text   = $matches[1];
      $labels = explode(":",substr($matches[2],1));
      foreach($labels as $label)
        $labelstr.= "<span class=\"label\">$label</span> ";
    }

    if ($level == 1)
    {
      return  "<div class=\"page-header\">\n".
              sprintf("<h%d>%s %s</h%d>\n", $level, trim($text), $labelstr, $level).
              "</div>\n";
    }
    else
    {
      return sprintf("<h%d>%s %s</h%d>\n", $level, trim($text), $labelstr, $level);
    }
  }

  public static function parseSections($text)
  {
    return preg_replace_callback('/^(\*+?) (.*)/m', "yog::mktitle", $text);
  }
  
}