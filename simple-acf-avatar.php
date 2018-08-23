<?php
/*
Plugin Name: Simple ACF Avatar
Description: A very simple plugin for adding user avatars with Advanced Custom Fields
Author: Maciej Palmowski
Version: 1.0.1
Author URI: https://pandify.pl
*/

defined( 'ABSPATH' ) or die();

if( ! class_exists( 'simpleAcfAvatar' ) ){
    class simpleAcfAvatar {

        function __construct() {
            $this->gravatars = apply_filters( 'simple_acf_avatar_use_gravatar', false );
            $this->acf_field_name = apply_filters( 'simple_acf_avatar_acf_field_name', 'avatar' );
            $this->avatar_size = apply_filters( 'simple_acf_avatar_size', 'thumbnail' );
        }

        function acf_avatar_url( $url, $id_or_email, $args ) {
            $user = false;
            if ( is_numeric( $id_or_email ) ) {
                $id = (int) $id_or_email;
                $user = get_user_by( 'id' , $id );
          
            } elseif ( is_object( $id_or_email ) ) {
                if ( ! empty( $id_or_email->user_id ) ) {
                    $id = (int) $id_or_email->user_id;
                    $user = get_user_by( 'id' , $id );
                }
            } else {
                $user = get_user_by( 'email', $id_or_email );
            }
            
            if ( $user && is_object( $user ) ) {
                if ( '' != get_field( $this->acf_field_name, 'user_'.$user->data->ID ) ) {
                    $url = wp_get_attachment_image_src( get_field( $this->acf_field_name, 'user_' . $user->data->ID ), $this->avatar_size )[0];
                } elseif ( $this->gravatars === false ) {
                    $url = '//2.gravatar.com/avatar/e709a9ddafc430751cabdb5d59382732?s=32&d=blank&f=y&r=g';
                }
            }
            return $url;
        }

        function disable_gravatars() {
            if ( $this->gravatars === false ) {
                add_action( 'load-profile.php', function() {
                    add_filter( 'option_show_avatars', '__return_false' );
                } );
            }
        }
    }
}


function simple_acf_avatar_run() {
    $simple_acf_avatar = new simpleAcfAvatar();
    add_filter( 'get_avatar_url' , [ $simple_acf_avatar, 'acf_avatar_url' ] , 10 , 3 );
    add_filter( 'init' , [ $simple_acf_avatar, 'disable_gravatars' ] );
}
add_action( 'init', 'simple_acf_avatar_run' );
