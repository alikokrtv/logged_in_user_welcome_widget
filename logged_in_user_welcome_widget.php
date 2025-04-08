<?php
/*
Plugin Name: My Custom Widget
Description: Giriş yapmış kullanıcılara özel bir mesaj sunar.
Version: 1.1
Author: Ali Kök
Author URI: https://sizinwebsiteniz.com

*/

// Widget sınıfını başlatma
class Logged_In_User_Welcome_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'logged_in_user_welcome_widget',
            __('Giriş Yapmış Kullanıcı Hoş Geldin Mesajı', 'text_domain'),
            array( 'description' => __( 'Yalnızca giriş yapmış kullanıcılara özel bir mesaj sunar.', 'text_domain' ), )
        );
    }

    public function widget( $args, $instance ) {
        $user = wp_get_current_user();

        if ( $user->exists() ) {
            echo '<div class="logged-in-user-widget" style="background-color:#05CAB6;  font-weight: bold; transparent; text-align:center;">';
            echo '<div class="welcome-message" style="font-family: \'Overpass\', sans-serif;   font-weight:bold; font-size: 1.17em; color: #05CAB6;">Merhaba, ' . esc_html( $user->display_name ) . '</div>';

            // Doğum günü kontrolü
            $birthday = get_user_meta( $user->ID, 'birthday', true );
            if ($birthday && date('m-d', strtotime($birthday)) === date('m-d')) {
                echo '<div class="birthday-message">Doğum Günün Kutlu Olsun! 🎂😇🥳</div>';
            }
            echo '</div>';
        }
    }

    public function form( $instance ) {
        // Form alanları (Yönetim paneli için)
    }

    public function update( $new_instance, $old_instance ) {
        // Güncelleme ayarları
    }
    
}

// Widget'ı kaydetmek ve başlatmak için kullanılan fonksiyon
function register_logged_in_user_welcome_widget() {
    register_widget( 'Logged_In_User_Welcome_Widget' );
}
add_action( 'widgets_init', 'register_logged_in_user_welcome_widget' );

// Kısa kod tanımlama
function custom_logged_in_user_welcome_shortcode() {
    ob_start();
    $user = wp_get_current_user();

    if ( $user->exists() ) {
        echo '<div class="logged-in-user-widget" style="background-color: transparent; color: #05CAB6; text-align:center;">';
        echo '<div class="welcome-message" style="font-family: \'Overpass\', sans-serif; font-size: 1.17em; color:#05CAB6;">Merhaba, ' . esc_html( $user->display_name ) . '</div>';

        // Doğum günü kontrolü
        $birthday = get_user_meta( $user->ID, 'birthday', true );
        if ($birthday && date('m-d', strtotime($birthday)) === date('m-d')) {
            echo '<div class="birthday-message">Doğum Günün Kutlu Olsun! 🎂😇🥳</div>';
        }
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode( 'logged_in_user_welcome', 'custom_logged_in_user_welcome_shortcode' );
?>
