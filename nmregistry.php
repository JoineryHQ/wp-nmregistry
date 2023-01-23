<?php
/*
Plugin Name:  NM Registry
Description:  Custom WordPress plugin for NMDCC provider registry
Author:       Joinery
Author URI:   https://joineryhq.com/
Version:      0.1.1
Text Domain:  nmregistry

One User Avatar
Copyright (c) 2023 Joinery https://joineryhq.com/
License: GPLv3
Source: https://joineryhq.com/

One User Avatar is distributed under the terms of the GNU GPL v3.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

function nmregistry_editUserProfile(WP_User $user) {
  nmregistry_updateCiviHasProfileImage($user->ID);
  wp_enqueue_script( 'nmregistry_editUserProfile', plugins_url( '/js/editUserProfile.js', __FILE__ ));
}

function nmregistry_profileUpdate($userId) {
  nmregistry_updateCiviHasProfileImage($userId);
}

function nmregistry_updateCiviHasProfileImage($userId) {
  $hasAvatar = has_wp_user_avatar($userId);
  
  civicrm_initialize();
  $hasProfileImageCustomFieldId = 20;  // TODO: GET THIS FROM A SETTING.
  $cid = CRM_Core_BAO_UFMatch::getContactId($userId);
  if ($cid) {
    // We should always have a $cid here, but just in case, we only take action if we do.
    $contactUpdateParams = [
      'id' => $cid,
      'custom_' . $hasProfileImageCustomFieldId => (int)$hasAvatar,
    ];
    $contactUpdate = _nmregistry_civicrmapi('contact', 'create', $contactUpdateParams);
  }
}

add_action('wpua_show_profile', 'nmregistry_editUserProfile'); // editing another user
add_action('profile_update', 'nmregistry_profileUpdate'); // editing another user
