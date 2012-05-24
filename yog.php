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
    const tab = 4;

    /*\
    }o{ Variable Declaration
    \*/
    private static $curLevel  = 0;
    private static $preLevel  = array();

    /*\
    }o{ Methods
    \*/

    function yogThis($text) {
        $text = htmlentities($text);
        $text = yog::escape($text);
        $text = yog::parseSections($text);
        return $text;
    }

    private static function escape($text)
    {
        $regex = array(
        // typography
        '/\*+? (*SKIP)(*FAIL)|(?<=\s)\*(.+?)\*/m', // *example*
        '/\/+? (*SKIP)(*FAIL)|(?<=\s)\/([^\/]+?)\//m', // /example/
        '/\++? (*SKIP)(*FAIL)|(?<=\s)\+([^\+]+?)\+/m', // +example+
        '/=+? (*SKIP)(*FAIL)|(?<=\s)=([^=]+?)=/m',   // =example=

        // glyphs
        // kudos: "Textile" http://textile.thresholdstate.com/.
        '/(\w)\'(\w)/',                   // apostrophe's
        '/(\s)\'(\d+\w?)\b(?!\')/',       // back in '88
        '/(\S)\'(?=\s|[[:punct:]]|<|$)/', // single closing
        '/\'/',                           // single opening
        '/(\S)\"(?=\s|[[:punct:]]|<|$)/', // double closing
        '/"/',                            // double opening
        '/\b( )?\.{3}/',                  // ellipsis
        '/(\s\w+)--(\w+\s)/',             // em dash
        '/[^\s]-(?:\s|$)/',               // en dash
        '/(\d+)( ?)x( ?)(?=\d+)/',        // dimension sign
        '/\b ?[([]TM[])]/i',              // trademark
        '/\b ?[([]R[])]/i',               // registered
        '/\b ?[([]C[])]/i',               // copyright

        // list
        '/^( *?)- (.+)?/m',

        '/\[\[(.+?)\]\[(.+?)\]\]/m',      // URL

        );
        $final = array(
        // typography
        "<strong>$1</strong>", // <strong>example*</strong>
        "<em>$1</em>",         // <italic>example/</em>
        "<del>$1</del>",       // <del>example+</del>
        '<code>$1</code>',

        // glyphs
        "$1&#8217;$2",  // apostrophe's&#8220;
        "$1&#8217;$2",  // back in '88
        "$1&#8217;",    // single closing
        "&#8216;",      // single opening
        "$1&#8221;",    // double closing
        "&#8220;",      // double opening
        "$1&#8230;",    // ellipsis
        "$1&#8212;$2",  // em dash
        "&#8211;",      // en dash
        "$1$2&#215;$3", // dimension sign
        "&#8482;",      // trademark
        "&#174;",       // registered
        "&#169;",       // copyright

        // list
        "$1<li>$2",

        '<a href="$1" title="$2" target="_blank">$2</a>',
        );
        $out = preg_replace($regex, $final, $text);

        $out = preg_replace_callback('/(\$\$.*?\$\$)|(\\\\\(.*?\\\\\))|
        (<code>.*?<\/code>)/', 'yog::unescape',$out, -1, $m);
        $out = preg_replace_callback('/(href=".*?")/', create_function(
        '$m','return urldecode($m[0]);'),$out, -1, $m);
        return $out;
    }

    private static function unescape($m)
    {
        //print_r($m);
        $regex = array(
        "/<strong>(.*)<\/strong>/m", // <strong>example*</strong>
        "/<em>(.*)<\/em>/m",         // <italic>example/</em>
        "/<del>(.*)<\/del>/m",       // <del>example+</del>
        "/(?<=[.])<code>(.*)<\/code>/m",
        '/\&#8216;/','/\&#8217;/','/\&#8220;/','/\&#8221;/',

        );
        $final = array(
        "*$1*", // <strong>example*</strong>
        "/$1/", // <italic>example/</em>
        "+$1+", // <del>example+</del>
        '=$1=',
        "'","'",'"','"',

        );
        return preg_replace($regex, $final, array_pop($m));
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
            $labelstr.= yog::t(1)."<span class=\"label\">".strtr(ucfirst($label),"_"," ")."</span>\n";
        }

        $text     = explode(" - ",trim($text));
        $id       = strtr($text[0]," ","-");
        $finalstr.= yog::t()."<h$level data-toggle=\"collapse\" data-target=\"#$id\">\n";
        if (isset($text[1]))
        $text = $text[0]." <br>\n".yog::t(1)."<small>".$text[1]."</small>";
        else
        $text = $text[0];

        $finalstr.= yog::t(1).$text."\n";
        $finalstr.= yog::t()."</h$level>\n";
        if ($level == 1)
        $finalstr.= yog::t()."<hr class=\"soften\">\n";
        if ($labelstr != "")
        $finalstr.= yog::t()."<div class=\"tags\">\n".$labelstr.yog::t()."</div>\n";
        $finalstr.=yog::t()."<div id=\"".$id."\" class=\"collapse\">\n";
        return $finalstr;
    }

    private static function t($int=0)
    {
        return str_repeat("    ", end(yog::$preLevel)+$int+yog::tab);
    }

    private static function parseSections($text)
    {
        $finalstr = "\n";
        foreach (explode("\n", $text) as $line)
        {
            if (preg_match('/^(\*+?) (.*)/', $line, $matches))
            {
                $text        = $matches[2];
                $level       = strlen($matches[1]);

                if ($level > end(yog::$preLevel))
                yog::$preLevel[] = $level;
                else if (end(yog::$preLevel) == $level)
                $finalstr.= yog::t()."</div>\n";
                else
                {
                    while ($level <= end(yog::$preLevel))
                    {
                        $finalstr.= yog::t()."</div>\n";
                        array_pop(yog::$preLevel);
                    }
                    yog::$preLevel[] = $level;
                }
                $finalstr.= yog::mktitle($text, $level);
            }
            else if(preg_match('/^\s$/', $line))
            $finalstr.= yog::t(1)."<br>\n";
            else
            $finalstr.= yog::t(1)."<p>".wordwrap($line, 80, "\n".yog::t(1), false)."</p>\n";
        }
        while (!empty(yog::$preLevel))
        {
            $finalstr.= yog::t()."</div>\n";
            array_pop(yog::$preLevel);
        }
        $finalstr.="\n";

        return $finalstr;
    }

}