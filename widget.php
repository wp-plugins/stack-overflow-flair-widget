<?php
/**
 * @package Stack Overflow Flair Widget
 */
/*

Plugin Name: Stack Overflow Flair Widget
Plugin URI: https://twuni.org/projects/stack-overflow-flair-widget
Description: This sidebar widget displays your Stack Overflow flair.
Version: 1.0.0
Author: Twuni
Author URI: https://twuni.org
License: Apache License 2.0

*/
/*

   Copyright 2011 Twuni

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

*/


function widget_stackoverflow_flair_initialize() {

  if( !function_exists( "register_sidebar_widget" ) || !function_exists( "register_widget_control" ) ) {
    return;
  }

  function widget_stackoverflow_flair( $args ) {

    $WIDGET_NAME = "stackoverflow_flair_widget";

    extract( $args );

    $options = get_option( $WIDGET_NAME );

    $title = empty( $options["title"] ) ? "Stack Overflow" : $options["title"];
    $userId = $options["user_id"];
    $theme = empty( $options["theme"] ) ? "default" : $options["theme"];

    echo $before_widget;
    echo $before_title . $title . $after_title;
    echo '<a href="http://stackoverflow.com/users/' . $userId . '">';
    echo '<img src="http://stackoverflow.com/users/flair/' . $userId . '.png?theme=' . $theme . '" style="max-width:100%;"/>';
    echo '</a>';
    echo $after_widget;

  }

  function widget_stackoverflow_flair_control() {

    $WIDGET_NAME = "stackoverflow_flair_widget";
    $WIDGET_THEMES = array( "default", "clean", "dark", "hotdog" );
    $WIDGET_FIELDS = array( "title", "user_id", "theme" );

    $options = get_option( $WIDGET_NAME );

    foreach( $WIDGET_FIELDS as $field ) {
      if( $_POST[ $WIDGET_NAME . "-" . $field ] ) {
        $options[ $field ] = strip_tags( stripslashes( $_POST[ $WIDGET_NAME . "-" . $field ] ) );
        update_option( $WIDGET_NAME, $options );
      }
    }

    $title = $options["title"];
    $user_id = $options["user_id"];
    $theme = $options["theme"];

    echo '<div><label for="' . $WIDGET_NAME . '-title">Title:</label></div>';
    echo '<div><input id="' . $WIDGET_NAME . '-title" type="text" name="' . $WIDGET_NAME . '-title" value="' . $title . '"/></div>';

    echo '<div><label for="' . $WIDGET_NAME . '-user_id">User ID:</label></div>';
    echo '<div><input id="' . $WIDGET_NAME . '-user_id" type="text" name="' . $WIDGET_NAME . '-user_id" value="' . $user_id . '"/></div>';

    echo '<div><label for="' . $WIDGET_NAME . '-theme">Theme:</label></div>';
    echo '<div><select id="' . $WIDGET_NAME . '-theme" type="text" name="' . $WIDGET_NAME . '-theme">';
    foreach( $WIDGET_THEMES as $theme_option ) {
      echo '<option value="' . $theme_option . '"' . ( $theme == $theme_option ? ' selected="selected"' : '' ) . '>' . $theme_option . '</option>';
    }
    echo '</select></div>';

  }

  register_sidebar_widget( "Stack Overflow Flair", "widget_stackoverflow_flair" );
  register_widget_control( "Stack Overflow Flair", "widget_stackoverflow_flair_control" );

}

add_action('plugins_loaded', 'widget_stackoverflow_flair_initialize');

?>
