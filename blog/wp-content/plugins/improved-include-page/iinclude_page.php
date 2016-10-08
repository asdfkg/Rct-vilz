<?php
/*
Plugin Name: Improved Include Page
Version: 1.0
Plugin URI: http://infolific.com/technology/software-worth-using/include-page-plugin-for-wordpress/
Description: This plugin allows you to include the contents of a page into a template or page/post (via a shortcode) with several options.
Author: Marios Alexandrou
Author URI: http://infolific.com/technology/
License: GPLv2 or later
Text Domain: improved-include-page
*/

/*
Copyright 2015 Marios Alexandrou

Based on the Include Page plugin by Brent Loertscher (http://beetle.cbtlsl.com/categories/include_page).

Transferred to Marios Alexandrou by the original author, Vito Tardia (http://www.vtardia.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define("DT_TEASER_MORE",0);             //Teaser with more link (default)
define("DT_TEASER_ONLY",1);             //Teaser only without more link
define("DT_FULL_CONTENT",2);            //Full content with teaser
define("DT_FULL_CONTENT_NOTEASER",3);   //Full content without teaser

/**
 * Displays or return the content of a static page
 * 
 * @param  int $post_id      The page ID to include
 * @param  int $params       An array of additional paramenters
 * @param  boolean $return   Tells wether return or display the content
 */
function iinclude_page( $post_id, $params = null, $return = false ) {
    global $wpdb, $post, $page;
   
    $tempPost = $post;
    $tempPage = $page;
    $post = array();
    
    $out = '';

    //Parsing custom parameters string
    if ( isset( $params ) ) {
		parse_str( $params );
	}

    //Loading default parameters
    if ( !isset( $displayTitle ) ) {
		$displayTitle = false;
	}
	
    if ( !isset( $titleBefore ) ) {
		$titleBefore = '<h2>';
	}
	
    if ( !isset( $titleAfter ) ) {
		$titleAfter = '</h2>';
	}

    if ( !isset( $displayStyle ) ) {
        $displayStyle = DT_TEASER_MORE;
    } else {
        $displayStyle = constant($displayStyle);
    }
    
    if ( !isset( $allowStatus ) ) {
        $status = array( 'publish' );
    } else {
        $status = explode( ',', $allowStatus );
        if ( !is_array( $status ) ) {
			$status = array( 'publish' );
		}
    }

    if ( !isset( $allowType ) ) {
        $type = array( 'page' );
    } else {
        $type = explode( ',', $allowType );
        if ( !is_array( $type ) ) {
			$type = array( 'page' );
		}
    }

    if ( !isset( $more ) ) {
		$more = 'Read on &raquo;';
	}
	
    if ( $page = IIP::get_page( $post_id, $type, $status ) ) {
        //echo "<pre>"; print_r($page); echo "</pre>";

        if ( $displayTitle ) {
            $title = $page->post_title;

            //Apply filters for Polyglot
            $title = apply_filters( 'the_title', $title );

            $out .= stripslashes( $titleBefore ) . $title . stripslashes( $titleAfter ) . "\n";
        }

        // Get the content an process it before display
        $content = $page->post_content;
        
        // stripslashes fixes an issues found by Nikhil Dabas which outputs too many slashes if the more tag is an image
        $content = IIP::get_the_content( $page,_(stripslashes( $more ) ),0,'',$displayStyle );

        // Uncomment the following line if you are using EventCalendar plugin
        // remove_filter('the_content',  'ec3_filter_the_content', 20);

        // Apply filters for Polyglot
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        $out .= $content;

        // Uncomment the following line below if you are using EventCalendar plugin
        // add_filter('the_content',  'ec3_filter_the_content', 20);

    } // end if
    
    $post = $tempPost;  
    $page = $tempPage;
    
    if ($return === true) {
        return $out;
    }
    
    echo $out;

}

/**
 * Support util class for IIP
 */
class IIP {
    
    /**
     * Fetch a page object from an ID or a page path
     * 
     * The path function is available since WP 2.1.
     * The type switch in available since WP 2.5
     */
    static function get_page($post_id, $type, $status) {
        
        if (is_numeric($post_id)) {
            $_page = get_page($post_id);
        } elseif( is_string($post_id) && function_exists('get_page_by_path')) {
            $_page = get_page_by_path($post_id);
        } else {
            return false;
        } // end if

        if (empty($_page)) {
            return false;
        }
        
        if (isset($_page->post_type)) {

            // addressing  WP 2.5 or better
            if (in_array($_page->post_status , $status) && in_array($_page->post_type , $type)) {
                return $_page;
            }
        } else {
            
            // dealing with previous version
            $status = array_merge($status, array('static'));

            if (in_array($_page->post_status , $status)) {
                return $_page;
            }
        }

        return false;
    } // end function
    
    /**
     * Formats content of a page
     */
    static function get_the_content(&$post, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '', $displayStyle = DT_TEASER_MORE) {
        
        $output = '';

        //Manage password protected post
        if (!empty($post->post_password)) { // if there's a password
            if (stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) != $post->post_password) {  // and it doesn't match the cookie
                $output = __('This post is password protected.');
                return $output;
            }
        }

        //$content = $post->post_content;

        $content = preg_split( '/<!--more.*-->/', $post->post_content, 2 );

        // Retrieve the more text set in the <!--more --> tag
        if ( sizeof( $content ) > 1 && $more_link_text == 'Read on &raquo;' ) {
            $tmp = preg_split( '/<!--more/', $post->post_content, 2 );
            $tmp = preg_split( '/-->/', $tmp[1], 2 );
            $post_more_text = trim( $tmp[0] );
            if ( $post_more_text != '' ) {
               $more_link_text = $post_more_text.' &raquo;';
            }
        }

        if ( ( preg_match( '/<!--noteaser-->/', $post->post_content ) ) || $displayStyle == DT_FULL_CONTENT_NOTEASER ) {
            $stripteaser = 1;
        }

        $teaser = $content[0];

        if ( $displayStyle == DT_FULL_CONTENT_NOTEASER ) {
			$teaser = '';
		}

        $output .= $teaser;

        if ( count( $content ) > 1 ) {
            if ( $displayStyle == DT_FULL_CONTENT_NOTEASER || $displayStyle == DT_FULL_CONTENT ) {
                $output .= '<span id="more-'.$post->ID.'"></span>'.$content[1];
            } elseif ( $displayStyle == DT_TEASER_MORE ) {
                $output .= ' <a class="more-link iip-more-link" href="' . get_permalink( $post->ID ) . '#more-' . $post->ID . '">' . $more_link_text . '</a>';
            }
        }

        return $output;

    }
    
    /**
     * Manage WP Shortcode API
     */
    static function shortcode_handler( $atts, $content=null ) {
        global $post;

        if ( !function_exists( 'add_shortcode' ) ) {
			return false;
		}

        $out = '';
        $params = array();

        // Parsing parameters other than ID
        foreach ( $atts as $name => $value ) {

            // WP transforms all attributes in lowercase
            // re-setting normal case
            switch ( $name ) {
                case 'displaystyle':
                    $name = 'displayStyle';
                    break;
                case 'displaytitle':
                    $name = 'displayTitle';
                    if ($value == "false" ) {
						$value = false;
					}
                    break;
                case 'titlebefore':
                    $name = 'titleBefore';
                    break;
                case 'titleafter':
                    $name = 'titleAfter';
	                break;
                case 'allowstatus':
                    $name = 'allowStatus';
	                break;
                case 'allowtype':
                    $name = 'allowType';
	                break;
                default:
	                continue;
            }

            if ($name != 'id') {
                $params[] .= $name . '=' . html_entity_decode($value);
            }

            $out .= "$name = $value ";

        }
        
        // Call IIP only with a valid ID
        if ( !empty($atts['id'] ) && $post->ID != $atts['id'] ) {
            
            // Fix type of page ID (thanks to Mike Woods)
            $page_id = $atts['id'];
            if ( is_numeric( $atts['id'] ) ) {
				$page_id = (int) $atts['id'];
			}
            $out = iinclude_page( $page_id, implode( '&', $params ), true );
        } else {
			$out = '';
		}

		return $out;
    }
}

if (function_exists('add_shortcode')) {
    add_shortcode( 'include-page', array( 'IIP','shortcode_handler' ) );
}

if (function_exists('iinclude_page')) {
    add_action( 'include-page', 'iinclude_page', 2, 3 );
}
?>