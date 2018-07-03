<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$ix = $this->main->get_ix_options();
?>
<div class="wrap" id="mec-wrap">
    <h1><?php _e('Auto Synchronization', 'mec'); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" class="nav-tab"><?php echo __('Google Cal. Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-g-calendar-export'); ?>" class="nav-tab"><?php echo __('Google Cal. Export', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-f-calendar-import'); ?>" class="nav-tab"><?php echo __('Facebook Cal. Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-export'); ?>" class="nav-tab"><?php echo __('Export', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-import'); ?>" class="nav-tab"><?php echo __('Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-sync'); ?>" class="nav-tab nav-tab-active"><?php echo __('Synchronization', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-thirdparty'); ?>" class="nav-tab"><?php echo __('Third Party Plugins', 'mec'); ?></a>
    </h2>
    <div class="mec-container">
        <div class="sync-content w-clearfix extra">
            <form id="mec_ix_sync_form" action="<?php echo $this->main->get_full_url(); ?>" method="POST">
                <div class="mec-form-row">
                    <input type="hidden" name="ix[sync_g_import]" value="0" />
                    <label class="mec-col-3" for="mec_ix_sync_g_import">
                        <input type="checkbox" id="mec_ix_sync_g_import" name="ix[sync_g_import]" value="1" <?php echo (isset($ix['sync_g_import']) and $ix['sync_g_import'] == '1') ? 'checked="checked"' : ''; ?> onchange="jQuery('#mec_sync_g_import_cron').toggleClass('mec-util-hidden');" />
                        <?php _e('Auto Google Import', 'mec'); ?>
                    </label>
                    <?php $cron = _MEC_ABSPATH_.'app'.DS.'crons'.DS.'g-import.php'; ?>
                    <p id="mec_sync_g_import_cron" class="mec-col-12 <?php echo (isset($ix['sync_g_import']) and $ix['sync_g_import'] == '1') ? '' : 'mec-util-hidden'; ?>"><strong><?php _e('Important Note', 'mec'); ?>: </strong><?php echo sprintf(__("Set a cronjob to call %s file atleast once per day otherwise it won't import Google Calendar events.", 'mec'), '<code>'.$cron.'</code>'); ?></p>
                </div>
                <div class="mec-form-row">
                    <input type="hidden" name="ix[sync_g_export]" value="0" />
                    <label class="mec-col-3" for="mec_ix_sync_g_export">
                        <input type="checkbox" id="mec_ix_sync_g_export" name="ix[sync_g_export]" value="1" <?php echo (isset($ix['sync_g_export']) and $ix['sync_g_export'] == '1') ? 'checked="checked"' : ''; ?> onchange="jQuery('#mec_sync_g_export_cron').toggleClass('mec-util-hidden');" />
                        <?php _e('Auto Google Export', 'mec'); ?>
                    </label>
                    <?php $cron = _MEC_ABSPATH_.'app'.DS.'crons'.DS.'g-export.php'; ?>
                    <p id="mec_sync_g_export_cron" class="mec-col-12 <?php echo (isset($ix['sync_g_export']) and $ix['sync_g_export'] == '1') ? '' : 'mec-util-hidden'; ?>"><strong><?php _e('Important Note', 'mec'); ?>: </strong><?php echo sprintf(__("Set a cronjob to call %s file atleast once per day otherwise it won't export your website events into Google Calendar.", 'mec'), '<code>'.$cron.'</code>'); ?></p>
                </div>
                <div class="mec-form-row">
                    <input type="hidden" name="ix[sync_f_import]" value="0" />
                    <label class="mec-col-3" for="mec_ix_sync_f_import">
                        <input type="checkbox" id="mec_ix_sync_f_import" name="ix[sync_f_import]" value="1" <?php echo (isset($ix['sync_f_import']) and $ix['sync_f_import'] == '1') ? 'checked="checked"' : ''; ?> onchange="jQuery('#mec_sync_f_import_cron').toggleClass('mec-util-hidden');" />
                        <?php _e('Auto Facebook Import', 'mec'); ?>
                    </label>
                    <?php $cron = _MEC_ABSPATH_.'app'.DS.'crons'.DS.'f-import.php'; ?>
                    <p id="mec_sync_f_import_cron" class="mec-col-12 <?php echo (isset($ix['sync_f_import']) and $ix['sync_f_import'] == '1') ? '' : 'mec-util-hidden'; ?>"><strong><?php _e('Important Note', 'mec'); ?>: </strong><?php echo sprintf(__("Set a cronjob to call %s file atleast once per day otherwise it won't import any event from Facebook.", 'mec'), '<code>'.$cron.'</code>'); ?></p>
                </div>
                <div class="mec-options-fields">
                    <input type="hidden" name="mec-ix-action" value="save-sync-options" />
                    <button class="button button-primary mec-button-primary" type="submit"><?php _e('Save', 'mec'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>