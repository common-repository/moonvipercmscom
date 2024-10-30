<?php
/*  Copyright 2008 Felix Triller  (email : eric@moonvipoer.com)

 

    Plugin Name: Spoil Me
    Plugin URI: http://moonviper.com
    Description: Transforms [spoiler]text[/spoiler] to a hidden box with a Show/Hide Button
    Version: 1.2
    Author: Felix Triller
    Author URI: http://moonviper.com


    Features:
    - easy to use, only one tag for a spoilertext
    - useable for every text, not only spoilers
    - less code, very fast

    Installation:
    - extract the archive, and upload the wpSpoiler directory to your wp-content/plugins/ folder!
    - active wpSpoiler in your wordpress admin panel
    - customize you stylesheet if wished

    Usage:
    - for use in posts and pages
    - enclose spoiler text between [spoiler] and [/spoiler]



*/

function wpSpoiler($text) {

    /* Config */
    $showtext = 'show';
    $hidetext = 'hide';
   
    // dont edit!
    $pattern = '@(\[spoiler\](.*?)\[/spoiler\])@is';
 
    // replace every [spoiler]...[/spoiler] tags
    if (preg_match_all($pattern, $text, $matches)) {
        
        for ($i = 0; $i < count($matches[0]); $i++) {
            $id   = 'id'.rand();
            $html = '';
       
            $html .= '<a class="spoiler_link_show" href="javascript:void(0)" onclick="wpSpoilerToggle(document.getElementById(\''.$id.'\'), this, \''.$showtext.'\', \''.$hidetext.'\')">'.$showtext.'</a>'.PHP_EOL;
            $html .= '<div class="spoiler_div" id="'.$id.'" style="display:none">'.$matches[2][$i].'</div>'.PHP_EOL;

            $text = str_replace($matches[0][$i], $html, $text);
        }

    }

    return $text;
}

function wpSpoiler_head() {

    // javascript
    $s = "<!-- wpSpoiler Code -->
        <script type=\"text/javascript\">
            function wpSpoilerToggle(spoiler, link, showtext, hidetext) {
                if (spoiler.style.display != 'none') {
                    spoiler.style.display = 'none';
                    link.innerHTML = showtext;
                    link.className = 'spoiler_link_show';
                } else {
                    spoiler.style.display = 'block';
                    link.innerHTML = hidetext;
                    link.className = 'spoiler_link_hide';
                }
            }
          </script>".PHP_EOL;
    echo $s;
}

// hooks
add_filter('the_content', 'wpSpoiler');
add_filter('the_excerpt', 'wpSpoiler');
add_filter('wp_head', 'wpSpoiler_head');

?>
