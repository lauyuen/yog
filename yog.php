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
  
  private static $dlevel  = 1;
  private static $hlevel  = 0;

  
  /*\
  }o{ Methods
  \*/
  
  function yogThis($text) {
    $text = yog::parseSections($text);
    return $text;
  }
  
  private static function mktitle($text, $level)
  {
    $rkeys    = '/^('.join("|",array_keys(yog::$keys)).') (.*)/';
    $rtags    = '/(.*) (:.*):/';
    $finalstr = "";
    $labelstr = "";
    
    if (preg_match($rkeys, $text, $matches))
    {
      $text     = $matches[2];
      $label    = $matches[1];
      $labelstr.= yog::t(1)."<span class=\"label label-".yog::$keys[$label]."\">"
                  .ucfirst(strtolower($label))."</span>\n";
    }
    
    if (preg_match($rtags, $text, $matches))
    {
      $text   = $matches[1];
      $labels = explode(":",substr($matches[2],1));
      foreach($labels as $label)
        $labelstr.= yog::t(1)."<span class=\"label\">".ucfirst($label)."</span>\n";
    }
    
    $text     = trim($text);
    $id       = strtr($text," ","-");
    $finalstr.= yog::t()."<h$level data-toggle=\"collapse\" data-target=\"#$id\">\n";
    $finalstr.= yog::t(1).$text."\n";
    $finalstr.= yog::t()."</h$level>\n";
    if ($level == 1)
      $finalstr.= yog::t()."<hr class=\"soften\">\n";
    if ($labelstr != "")
      $finalstr.= yog::t()."<div class=\"tags\">\n".$labelstr.yog::t()."</div>\n";
    
    return $finalstr;
  }
  
  public static function t($int=0)
  {
    return str_repeat("  ", yog::$hlevel+$int);
  }
  
  public static function parseSections($text)
  {
    foreach (explode("\n", $text) as $line)
    {
        if (preg_match('/^(\*+?) (.*)/', $line, $matches))
        {
          $text        = $matches[2];
          yog::$hlevel = strlen($matches[1]);
          echo yog::mktitle($text, yog::$hlevel);
          echo yog::t()."<div id=\"$text\">\n";
        }
        else
        {
          echo yog::t(1).$line."\n";
        }
    }
    
    //return preg_replace_callback('/^(\*+?) (.*)/m', "yog::mktitle", $text);
  }
  
}