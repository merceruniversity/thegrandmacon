<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$third_parties = $this->main->get_integrated_plugins_for_import();
?>
<div class="wrap" id="mec-wrap">
    <h1><?php _e('MEC Import / Export', 'mec'); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="<?php echo $this->main->remove_qs_var('tab'); ?>" class="nav-tab"><?php echo __('Google Cal. Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-g-calendar-export'); ?>" class="nav-tab"><?php echo __('Google Cal. Export', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-f-calendar-import'); ?>" class="nav-tab"><?php echo __('Facebook Cal. Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-export'); ?>" class="nav-tab"><?php echo __('Export', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-import'); ?>" class="nav-tab nav-tab-active"><?php echo __('Import', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-sync'); ?>" class="nav-tab"><?php echo __('Synchronization', 'mec'); ?></a>
        <a href="<?php echo $this->main->add_qs_var('tab', 'MEC-thirdparty'); ?>" class="nav-tab"><?php echo __('Third Party Plugins', 'mec'); ?></a>
    </h2>
    <div class="mec-container">
        <div class="import-content w-clearfix extra">
            <h3><?php _e('Import MEC XML Feed', 'mec'); ?></h3>
            <form id="mec_import_form" action="<?php echo $this->main->get_full_url(); ?>" method="POST" enctype="multipart/form-data">
                <div class="mec-form-row">
                    <p><?php echo sprintf(__("You can import %s events from another website to this website. You just need an XML feed of the events that can be exported from source website!", 'mec'), '<strong>'.__('Modern Events Calendar', 'mec').'</strong>'); ?></p>
                </div>
                <div class="mec-form-row">
                    <input type="file" name="feed" id="feed" title="<?php esc_attr_e('XML Feed', 'mec'); ?>">
                    <input type="hidden" name="mec-ix-action" value="import-start" />
                    <button class="button button-primary"><?php _e('Upload & Import', 'mec'); ?></button>
                </div>
            </form>

            <?php if($this->action == 'import-start'): ?>
            <div class="mec-ix-import-started">
                <?php if($this->response['success'] == 0): ?>
                    <div class="mec-error"><?php echo $this->response['message']; ?></div>
                <?php else: ?>
                    <div class="mec-success"><?php echo $this->response['message']; ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>