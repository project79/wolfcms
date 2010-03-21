<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package wolf
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */
?>
<h1><?php echo __(ucfirst($action).' user'); ?></h1>

<form action="<?php echo $action=='edit' ? get_url('user/edit/'.$user->id): get_url('user/add'); ; ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
  <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
    <tr>

      <td class="label"><label for="user_name"><?php echo __('Name'); ?></label></td>
      <td class="field"><input class="textbox" id="user_name" maxlength="100" name="user[name]" size="100" type="text" value="<?php echo $user->name; ?>" /></td>
      <td class="help"><?php echo __('Required.'); ?></td>
    </tr>
    <tr>
      <td class="label"><label class="optional" for="user_email"><?php echo __('E-mail'); ?></label></td>
      <td class="field"><input class="textbox" id="user_email" maxlength="255" name="user[email]" size="255" type="text" value="<?php echo $user->email; ?>" /></td>

      <td class="help"><?php echo __('Optional. Please use a valid e-mail address.'); ?></td>
    </tr>
    <tr>
      <td class="label"><label for="user_username"><?php echo __('Username'); ?></label></td>
      <td class="field"><input class="textbox" id="user_username" maxlength="40" name="user[username]" size="40" type="text" value="<?php echo $user->username; ?>" <?php echo $action == 'edit' ? 'disabled="disabled" ': ''; ?>/></td>
      <td class="help"><?php echo __('At least 3 characters. Must be unique.'); ?></td>
    </tr>

    <tr>
      <td class="label"><label for="user_password"><?php echo __('Password'); ?></label></td>
      <td class="field"><input class="textbox" id="user_password" maxlength="40" name="user[password]" size="40" type="password" value="" /></td>
      <td class="help" rowspan="2"><?php echo __('At least 5 characters.'); ?> <?php if($action=='edit') { echo __('Leave password blank for it to remain unchanged.'); } ?></td>
    </tr>
    <tr>
      <td class="label"><label for="user_confirm"><?php echo __('Confirm Password'); ?></label></td>

      <td class="field"><input class="textbox" id="user_confirm" maxlength="40" name="user[confirm]" size="40" type="password" value="" /></td>
    </tr>
<?php if (AuthUser::hasPermission('administrator')): ?> 
    <tr>
      <td class="label"><?php echo __('Roles'); ?></td>
      <td class="field">
<?php $user_permissions = ($user instanceof User) ? $user->getPermissions(): array(); ?>
<?php foreach ($permissions as $perm): ?>
        <span class="checkbox"><input<?php if (in_array($perm->name, $user_permissions)) echo ' checked="checked"'; ?>  id="user_permission-<?php echo $perm->name; ?>" name="user_permission[<?php echo $perm->name; ?>]" type="checkbox" value="<?php echo $perm->id; ?>" />&nbsp;<label for="user_permission-<?php echo $perm->name; ?>"><?php echo __(ucwords($perm->name)); ?></label></span>
<?php endforeach; ?>
      </td>
      <td class="help"><?php echo __('Roles restrict user privileges and turn parts of the administrative interface on or off.'); ?></td>
    </tr>
<?php endif; ?>

    <tr>
        <td class="label"><label for="user_language"><?php echo __('Language'); ?></label></td>
        <td class="field">
          <select class="select" id="user_language" name="user[language]">
<?php foreach (Setting::getLanguages() as $code => $label): ?>
            <option value="<?php echo $code; ?>"<?php if ($code == $user->language) echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
<?php endforeach; ?>
          </select>
        </td>
        <td class="help"><?php echo __('This will set your preferred language for the backend.'); ?></td>
      </tr>

  </table>

  <p class="buttons">
    <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
    <?php echo __('or'); ?> <a href="<?php echo (AuthUser::hasPermission('administrator')) ? get_url('user') : get_url(); ?>"><?php echo __('Cancel'); ?></a>
  </p>

</form>

<script type="text/javascript">
// <![CDATA[
    function setConfirmUnload(on, msg) {
        window.onbeforeunload = (on) ? unloadMessage : null;
        return true;
    }

    function unloadMessage() {
        return '<?php echo __('You have modified this page.  If you navigate away from this page without first saving your data, the changes will be lost.'); ?>';
    }

    $j(document).ready(function() {
        // Prevent accidentally navigating away
        $j(':input').bind('change', function() { setConfirmUnload(true); });
        $j('form').submit(function() { setConfirmUnload(false); return true; });
    });
    
Field.activate('user_name');
// ]]>
</script>
